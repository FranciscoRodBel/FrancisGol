<?php
    require_once "../model/Usuario.php";

    Usuario::comprobarSesionIniciada(false);

    $usuario = unserialize($_SESSION['usuario']);

    echo $usuario->borrarCuenta();