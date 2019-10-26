<?php
    // Incluir sesión y MySQL
    include_once 'session.php';
    // Inicio de sesión simplificado (Temporal)
    $error = false;
    // Obtener variables del POST
    $username = $_POST['user'];
    $password = $_POST['pass'];
    // Si el usuario y contraseña son correctos
    if ($username == "admin" && $password == "admin" ) {
        // Guardar ID
        $_SESSION['status'] = true;
    } else {
        $_SESSION['status'] = false;
        $error = true;
        $msg = "Contraseña o usuario incorrecto";
    }
    // Verificar
    if ($error) {
        // Hay error
        print("<p>$msg</p>");
        print("<a href='/creditx'>Intentar de nuevo</a>");
    } else {
        // OK
        print("<p>Correcto! Ir a Inicio</p>");
        print("<a href='/creditx'>Inicio</a>");
    }
?>