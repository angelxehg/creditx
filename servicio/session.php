<?php
    // Inicia la sesión
    @session_start();
    // Ocultar errores de PHP
    error_reporting(0);
    //
    if (!isset($_SESSION['status'])) {
        $_SESSION['status'] = false;
    }
?>