<?php
    require_once "../model/Usuario.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    // Se ejecuta este archivo para realizar las acciones de rechazar o aceptar las cookies

    if (isset($_GET['accion']) && !empty($_GET['accion'])) { // Si la sesión está iniciada y se ha enviado rechazar o aceptar...
        
        $usuario = unserialize($_SESSION['usuario']); // Se recoge el objeto del usuario

        if ($_GET['accion'] == "aceptar") { // Si acepta las cookies
        
            $usuario->guardarCookies(); // Almacena en la BBDD que aceptó las cookies para que al abrir la página sepa que aceptó las cookies
            $usuario->crearCookies();

        } // Si rechaza las cookies o acepta...

        $usuario->__set("cookies", "1"); // Cambia el valor de las cookies a 1 para que no se muestre la pregunta de aceptar las cookies hasta que cierre la página
        $_SESSION['usuario'] = serialize($usuario); // Actualiza el objeto guardado en la sesión
    }