<?php
    function comprobarDatos(string $dato) : string { // Comprueba que todos los datos no lleven código oculto

        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);

        return $dato;
    }

    function comprobarVacio(iterable $dato) : string { // Comprueba que el array de datos pasados no esté vacío

        foreach ($dato as $datoArray) {

            if (empty($datoArray)) {
                return false;
            }

        }
    
        return true;
    }

    function comprobarSesionIniciada($operacion) { // Se usa para redirigir a una página cuando esté o no la sesión iniciada

        // Operación será true o false dependiendo de lo que se quiera comprobar, hay dos opciones:
        if ($operacion) {
    
            // Que si la sesión está iniciada lo devuelva al inicio, se usa en páginas de iniciar sesión y registro
            if (isset($_SESSION['usuario'])) {
            
                header('Location: ./inicio.php');
                die();
            
            }
        
        } else {
            
            // Que si la sesión no está iniciada que lo reenvíe al inicio, en cualquier página en la que cambie la base de datos
            if (!isset($_SESSION['usuario'])) {
            
                header('Location: ./inicio.php');
                die();
            
            }
        }
    }
?>