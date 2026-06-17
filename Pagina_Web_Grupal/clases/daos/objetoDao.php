<?php
// Archivo: clases/daos/objetoDao.php

// Usamos __DIR__ para evitar fallos de rutas relativas desde index.php
require_once __DIR__ . '/dao.php';
require_once __DIR__ . '/../php/objeto.php'; 
require_once __DIR__ . '/../../conexion.php';

class ObjetoDAO implements dao { 
    private $conexion;

    // El constructor recibe la conexión PDO directamente
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /**
     * Inserta un nuevo objeto perdido en la base de datos tecnolost.
     */
    public function insertar($obj): void {
        $sql = "INSERT INTO objeto (id_categoria, id_ubicacion, id_estado_objeto, id_administrador, nombre, descripcion, color, marca, fecha_encontrado, fecha_registro, foto, observaciones) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        // Si el objeto no trae una fecha de registro asignada, usamos la del día de hoy (AAAA-MM-DD)
        $fechaRegistro = $obj->getFechaRegistro() ? $obj->getFechaRegistro() : date('Y-m-d');

        $stmt->execute([
            $obj->getIdCategoria(),
            $obj->getIdUbicacion(),
            $obj->getIdEstadoObjeto(),
            $obj->getIdAdministrador(),
            $obj->getNombre(),
            $obj->getDescripcion(),
            $obj->getColor(),
            $obj->getMarca(),
            $obj->getFechaEncontrado(),
            $fechaRegistro,
            $obj->getFoto(),
            $obj->getObservaciones()
        ]);
    }

    /**
     * Modifica un objeto existente (Cumple con dao::modificar)
     */
    public function modificar($obj): void {
        $sql = "UPDATE objeto SET 
                    id_categoria = ?, 
                    id_ubicacion = ?, 
                    id_estado_objeto = ?, 
                    id_administrador = ?, 
                    nombre = ?, 
                    descripcion = ?, 
                    color = ?, 
                    marca = ?, 
                    fecha_encontrado = ?, 
                    fecha_registro = ?, 
                    foto = ?, 
                    observaciones = ? 
                WHERE id_objeto = ?";
                
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            $obj->getIdCategoria(),
            $obj->getIdUbicacion(),
            $obj->getIdEstadoObjeto(),
            $obj->getIdAdministrador(),
            $obj->getNombre(),
            $obj->getDescripcion(),
            $obj->getColor(),
            $obj->getMarca(),
            $obj->getFechaEncontrado(),
            $obj->getFechaRegistro(),
            $obj->getFoto(),
            $obj->getObservaciones(),
            $obj->getIdObjeto()
        ]);
    }

    /**
     * Elimina físicamente un objeto de la base de datos por su ID.
     */
    public function eliminar($id): void {
        $sql = "DELETE FROM objeto WHERE id_objeto = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
    }

    /**
     * Busca un objeto específico filtrándolo por su ID (Cumple con dao::obtenerPorId)
     */
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

    /**
     * Devuelve una lista con todos los objetos guardados.
     */
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

    /**
     * Alias por si tu index.php o controladores llaman a 'listarTodos()' o 'buscarPorId()'
     */
    public function listarTodos() {
        return $this->listar();
    }

    public function buscarPorId($id) {
        return $this->obtenerPorId($id);
    }
}
?>