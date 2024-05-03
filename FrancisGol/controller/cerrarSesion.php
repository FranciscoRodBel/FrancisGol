<?php
    session_start();

    // cuando se redirige a este archivo automaticamente se cierra sesion y se redirige a la página de partidos

    session_unset();
    session_destroy();

    header("Location: ./partidos.php");