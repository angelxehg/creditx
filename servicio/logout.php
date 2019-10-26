<?php
    // Incluir sesión y MySQL
    include_once 'session.php';
    // Destruir sesión
    if(session_destroy()) {
        @session_start();
    }
    // 
    print("<p>Se cerró sesión</p>");
    print("<a href='/creditx'>Inicio</a>");
?>