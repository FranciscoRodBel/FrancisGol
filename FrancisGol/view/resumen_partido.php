
<?php
    // print_r($eventosPartido);

    // echo "<h3>Eventos del partido: </h3>";
    // foreach ($eventosPartido->response as $key => $evento) {

    //     echo "<p>Equipo: ".$evento->team->name."<br>";
    //     echo "Jugador: ".$evento->player->name."<br>";
    //     echo "Tipo: ".$evento->type."<br>";
    //     echo "Tiempo transcurrido: ".$evento->time->elapsed."<br>";
    //     echo "Detalle: ".$evento->detail."<br>";
    //     echo "Comentarios: ".$evento->comments."<br><br>";
    //     echo "</p>";

    // }
?>
<main>
    <h1 class="titulo_pagina">Resumen del partido</h1>
    <article>
        <section class="seccion_negra">
            <div class="enfrentamiento_equipos">
                <a href="../controller/partido.php">
                    <div>
                        <img src="<?= $partido->teams->home->logo ?>" alt="Logo">
                        <span><?= $partido->teams->home->name ?></span>
                    </div>
                    <div>
                        <p>VS</p>
                        <p><?= $partido->goals->home.' - '.$partido->goals->away ?></p>
                    </div>
                    <div>
                        <img src="<?= $partido->teams->away->logo ?>" alt="Logo">
                        <span><?= $partido->teams->away->name ?></span>
                    </div>
                </a>
            </div>
            <div class="conjunto_botones">
                <a href="../controller/resumen_partido.php?partido=<?= urlencode(json_encode($partido)) ?>" class="boton_gris"><span>Resumen</span></a>
                <a href="../controller/estadisticas_partido.php?partido=<?= urlencode(json_encode($partido)) ?>" class="boton_gris"><span>Estadísticas</span></a>
                <a href="../controller/alineaciones_partido.php?ipartido=<?= urlencode(json_encode($partido)) ?>"><span>Alineaciones</span></a>
            </div>
            <hr>
            <div class='eventos_partidos'>
                <?= $resumenPartido ?> 
            <!--
                <div>
                    <h3 class="titulo_informacion">Celta de Vigo</h3>
                    <div class="evento">
                        <p class="minuto">31'</p>
                        <i class="fa-solid fa-futbol icono_evento"></i>
                        <p class="nombre_evento">Iago Aspassssssssssssssssss</p>
                    </div>
                    <div class="evento">
                        <p class="minuto">65'</p>
                        <i class="fa-solid fa-futbol icono_evento"></i>
                        <p class="nombre_evento">Iago Aspas</p>
                    </div>
                    <div class="evento">
                        <p class="minuto">82'</p>
                        <i class="fa-solid fa-arrows-rotate icono_evento"></i>
                        <div class="nombre_evento cambio">
                            <p>Iago Aspas</p>
                            <p>Larsen</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                    <h3 class="titulo_informacion">Rayo Vallecano</h3>
                    <div class="evento tarjeta">
                        <p class="minuto">178'</p>
                        <div class="icono_evento"><div class="tarjeta_amarilla"></div></div>
                        <p class="nombre_evento">Florian Lejeune</p>
                    </div>
                    <div class="evento">
                        <p class="minuto">85'</p>
                        <div class="icono_evento gol_anulado">
                            <i class="fa-solid fa-futbol"></i>
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <p class="nombre_evento">Gol anulado</p>
                    </div>
                    <div class="evento">
                        <p class="minuto">86'</p>
                        <div class="icono_evento"><div class="tarjeta_roja"></div></div>
                        <p class="nombre_evento">Florian Lejeune</p>
                    </div>
                </div> -->
                </div>
        </section>
    </article>
</main>