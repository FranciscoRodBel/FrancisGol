<header>
    <a href="../controller/inicio.php">
        <img src="../view/assets/images/logo.png" alt="Logo">
        <span>FrancisGol</span>
    </a>
    <div>
        <div class="menu_hamburguesa" id="menu_hamburguesa">
            <hr>
            <hr>
            <hr>
        </div>
        <?php if (isset($_SESSION["usuario"])) {

        $usuario = unserialize($_SESSION['usuario']);

        echo "<div class='menu_ordenador'><a href='../controller/cerrarSesion.php' class='boton_registrar'>Cerrar sesión</a>";
        echo "<a href='../controller/cuenta_favoritos.php'><img src='data:image/jpeg;base64," . base64_encode($usuario->__get("foto")) . "'></a></div>";

        } else { ?>

            <div class="menu_ordenador">
                <a href="../controller/inicioSesion.php" class="boton_iniciar">Iniciar sesión</a>
                <a href="../controller/registro.php" class="boton_registrar">Registrarse</a>
            </div>
            
        <?php } ?>
    </div>
</header>
<script src="../view/assets/scripts/menu_hamburguesa.js"></script>
<script> iniciarMenuHamburguesa(); </script>