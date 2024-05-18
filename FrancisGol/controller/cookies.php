<?php

    // Este código es lo primero que se ejecuta y en todas las páginas. Está incluido al principio del model Usuario.php

    $mensajeCookies = "";

    if (isset($_SESSION['usuario'])) { // Si la sesión está inciada...

        $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario

        if ($usuario->__get("cookies") == 0) { // Si es 0 significa que no ha respondido al mensaje de confirmación de las cookies, por tanto..
            
            $mensajeCookies = $usuario->generarMensajeCookies(); // Genera el mensaje que se incluye en el template del footer
        }

    } else { // Si la sesión no está inciada...

        if(isset($_COOKIE['email']) && isset($_COOKIE['contrasenia'])) { // Si las cookies de contraseña e email están inciadas

            // Recojo los datos
            $email = $_COOKIE['email'];
            $contrasenia = $_COOKIE['contrasenia'];

            $usuario = new Usuario($email); // Creo el objeto del usuario con el email
            $usuario->comprobarInicioSesion($contrasenia, "cookie"); // Incia la sesión si los datos en las cookies son correctos
        }
    }