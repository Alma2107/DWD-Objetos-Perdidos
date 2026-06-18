<?php

require_once __DIR__ . '/dao.php';
require_once __DIR__ . '/../php/objeto.php'; 
require_once __DIR__ . '/../../conexion.php';

class ObjetoDAO implements dao { 
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

public function insertar($obj): void {
    $sql = "INSERT INTO objeto (id_categoria, id_ubicacion, id_estado_objeto, id_administrador, nombre, descripcion, color, marca, fecha_encontrado, fecha_registro, foto, observaciones) 
            VALUES (:cat, :ubi, :est, :adm, :nom, :des, :col, :mar, :fecE, :fecR, :foto, :obs)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
        ':cat' => $obj->getIdCategoria(), ':ubi' => $obj->getIdUbicacion(), ':est' => $obj->getIdEstadoObjeto(),
        ':adm' => $obj->getIdAdministrador(), ':nom' => $obj->getNombre(), ':des' => $obj->getDescripcion(),
        ':col' => $obj->getColor(), ':mar' => $obj->getMarca(), ':fecE' => $obj->getFechaEncontrado(),
        ':fecR' => $obj->getFechaRegistro(), ':foto' => $obj->getFoto(), ':obs' => $obj->getObservaciones()
    ]);
}

    public function modificar($obj): void {
        $sql = "UPDATE objeto SET 
                    id_categoria = :id_categoria, 
                    id_ubicacion = :id_ubicacion, 
                    id_estado_objeto = :id_estado_objeto, 
                    id_administrador = :id_administrador, 
                    nombre = :nombre, 
                    descripcion = :descripcion, 
                    color = :color, 
                    marca = :marca, 
                    fecha_encontrado = :fecha_encontrado, 
                    fecha_registro = :fecha_registro, 
                    foto = :foto, 
                    observaciones = :observaciones 
                WHERE id_objeto = :id_objeto";
                
        $stmt = $this->conexion->prepare($sql);
        
        $stmt->bindValue(':id_categoria', $obj->getIdCategoria());
        $stmt->bindValue(':id_ubicacion', $obj->getIdUbicacion());
        $stmt->bindValue(':id_estado_objeto', $obj->getIdEstadoObjeto());
        $stmt->bindValue(':id_administrador', $obj->getIdAdministrador());
        $stmt->bindValue(':nombre', $obj->getNombre());
        $stmt->bindValue(':descripcion', $obj->getDescripcion());
        $stmt->bindValue(':color', $obj->getColor());
        $stmt->bindValue(':marca', $obj->getMarca());
        $stmt->bindValue(':fecha_encontrado', $obj->getFechaEncontrado());
        $stmt->bindValue(':fecha_registro', $obj->getFechaRegistro());
        $stmt->bindValue(':observaciones', $obj->getObservaciones());
        $stmt->bindValue(':id_objeto', $obj->getIdObjeto());

        // Manejo seguro de la imagen en formato BLOB para la actualización
        $foto = $obj->getFoto();
        if ($foto !== null) {
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
        } else {
            $stmt->bindValue(':foto', null, PDO::PARAM_NULL);
        }

        $stmt->execute();
    }

    public function eliminar($id): void {
        $sql = "DELETE FROM objeto WHERE id_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM objeto WHERE id_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return new Objeto(
                $fila['id_objeto'],
                $fila['id_categoria'],
                $fila['id_ubicacion'],
                $fila['id_estado_objeto'],
                $fila['id_administrador'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['color'],
                $fila['marca'],
                $fila['fecha_encontrado'],
                $fila['fecha_registro'],
                $fila['foto'],
                $fila['observaciones']
            );
        }
        return null;
    }

    public function listar() {
        $sql = "SELECT * FROM objeto ORDER BY id_objeto DESC";
        $stmt = $this->conexion->query($sql);
        $resultados = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Objeto(
                $fila['id_objeto'],
                $fila['id_categoria'],
                $fila['id_ubicacion'],
                $fila['id_estado_objeto'],
                $fila['id_administrador'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['color'],
                $fila['marca'],
                $fila['fecha_encontrado'],
                $fila['fecha_registro'],
                $fila['foto'],
                $fila['observaciones']
            );
        }
        return $resultados;
    }

    public function buscarFiltrado($id_categoria = '', $texto = '') {
        $sql = "SELECT * FROM objeto WHERE 1=1";
        $params = [];

        if ($id_categoria !== '' && is_numeric($id_categoria)) {
            $sql .= " AND id_categoria = :id_categoria";
            $params[':id_categoria'] = (int)$id_categoria;
        }

        if ($texto !== '') {
            $sql .= " AND (nombre LIKE :texto OR descripcion LIKE :texto)";
            $params[':texto'] = '%' . $texto . '%';
        }

        $sql .= " ORDER BY fecha_registro DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($params);
        
        $resultados = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = new Objeto(
                $fila['id_objeto'],
                $fila['id_categoria'],
                $fila['id_ubicacion'],
                $fila['id_estado_objeto'],
                $fila['id_administrador'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['color'],
                $fila['marca'],
                $fila['fecha_encontrado'],
                $fila['fecha_registro'],
                $fila['foto'],
                $fila['observaciones']
            );
        }
        return $resultados;
    }

    public function listarTodos() {
        return $this->listar();
    }

    public function buscarPorId($id) {
        return $this->obtenerPorId($id);
    }
}
?>