<?php
//iniciamos la sesion del sistema
//para guardar quien entra despues
session_start();

//traemos el archivo de conexion
//para poder hablar con la base
require_once '../../conexion.php';

//vemos si nos mandaron datos
//desde el boton de enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //limpiamos los espacios vacios
    //para que no haya errores
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    //creamos una conexion nueva
    //para buscar al administrador
    $conexionObjeto = new Conexion();
    $db = $conexionObjeto->conectar();

    //preparamos la busqueda en la tabla
    //filtrando por el usuario escrito
    $sql = "SELECT * FROM administrador WHERE usuario = :usuario LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    
    //guardamos el resultado encontrado
    //como si fuera una lista
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    //comparamos la contraseña guardada
    //con la que escribieron en la web
    if ($admin && $admin['contrasena'] === $contrasena) {
        
        //guardamos el id en la sesion
        //para recordarlo en otras paginas
        $_SESSION['idAdmin'] = $admin['id_administrador'];
        
        //lo mandamos al panel principal
        //porque puso todo bien
        header('Location: ../../panel_admin/admin_panel.php');
        exit;
    } else {
        
        //lo devolvemos a la pagina de login
        //porque los datos estan mal
        header('Location: login.php?error=1');
        exit;
    }
} else {
    
    //si entran sin usar el formulario
    //los mandamos de vuelta al login
    header('Location: login.php');
    exit;
}
?>