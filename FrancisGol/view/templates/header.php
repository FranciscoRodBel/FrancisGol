<header>
    <a href="../controller/partidos.php">
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

        echo "<div class='menu_ordenador'><a href='../controller/cerrarSesion.php'>Cerrar sesión</a>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($usuario->__get("foto")) . "'/></div>";

        } else { ?>

            <div class="menu_ordenador">
                <a href="../controller/inicioSesion.php">Iniciar sesión</a>
                <a href="../controller/registro.php">Registrarse</a>
            </div>
            
        <?php } ?>
    </div>
</header>
<script src="../view/assets/scripts/menu_hamburguesa.js"></script>