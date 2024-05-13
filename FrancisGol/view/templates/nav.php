<nav id="navegacion">
    <a href="../controller/partidos.php"><span>Partidos</span></a>
    <a href="../controller/buscar.php"><span>Buscar</a></span>
    <a href="../controller/fichajes.php"><span>Fichajes</span></a>
    <a href="../controller/plantillas_mis.php"><span>Plantillas</span></a>
    <?php if (isset($_SESSION['usuario'])) { ?>
        <a href="../controller/cuenta_favoritos.php" class="vista_ordenador">Cuenta</a>
        <a href="../controller/cerrarSesion.php" class="vista_ordenador">Cerrar sesión</a>
    <?php } else { ?>
        <a href="../controller/inicioSesion.php" class="vista_ordenador">Iniciar sesión</a>
        <a href="../controller/registro.php" class="vista_ordenador">Registrarse</a>
    <?php } ?>
</nav>