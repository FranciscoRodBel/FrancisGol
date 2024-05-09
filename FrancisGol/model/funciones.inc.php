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
?>