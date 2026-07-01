<?php
//arrancamos la sesion aca
//para chequear si ya entro antes
session_start();

//si ya tiene una sesion activa
//lo mandamos al panel directo
if (isset($_SESSION['idAdmin'])) {
    header('Location: ../../panel_admin/admin_panel.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tecnolost</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/admin/panel-admin-estilo.css">
    
    <link rel="stylesheet" href="../../css/admin/estilo-verificar_login.css">
</head>
<body>
    <div class="login-wrapper">
        <form action="procesar_login.php" method="POST" class="form-card login-card">
            <h3>
                <i class="fa-solid fa-user-lock"></i> Acceso Admin
            </h3>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error" style="margin: 0 0 20px 0; padding: 15px;">
                    Usuario o contraseña incorrectos.
                </div>
            <?php endif; ?>

            <div class="input-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario">
            </div>

            <div class="input-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required placeholder="Ingresa tu contraseña">
            </div>

            <button type="submit" class="btn-enviar">
                Entrar al Panel
            </button>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="../../index.php" class="panel-link" style="border: none; background: transparent;">
                    <i class="fa-solid fa-arrow-left"></i> Volver a la web
                </a>
            </div>
        </form>
    </div>
</body>
</html>