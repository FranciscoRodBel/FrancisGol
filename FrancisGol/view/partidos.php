<?php

    
    // foreach ($resultado->response as $key => $partido) {

    //     print_r($partido);          
    //     echo "<p>ID del partido: ".$partido->fixture->id."<br>";
    //     echo "ID del partido2: ".$partido->fixture->venue->id."<br>";
    //     echo "Estado del partido: ".$partido->fixture->status->long."<br>";
    //     echo "Estado del partido2: ".$partido->fixture->status->short."<br>";
    //     echo "Tiempo transcurrido: ".$partido->fixture->status->elapsed."<br><br>";

    //     echo "Id liga: ".$partido->league->id."<br>";
    //     echo "nombre liga: ".$partido->league->name."<br>";
    //     echo "<img src=".$partido->league->logo." alt='logo'><br><br>";

    //     echo "ID equipo local: ".$partido->teams->home->id."<br>";
    //     echo "Nombre equipo local: ".$partido->teams->home->name."<br>";
    //     echo "Ganando equipo local: ".$partido->teams->home->winner."<br>";
    //     echo "<img src=".$partido->teams->home->logo." alt='logo'><br><br>";

    //     echo "ID equipo visitante: ".$partido->teams->away->id."<br>";
    //     echo "Nombre equipo visitante: ".$partido->teams->away->name."<br>";
    //     echo "Ganando equipo visitante: ".$partido->teams->away->winner."<br>";
    //     echo "<img src=".$partido->teams->away->logo." alt='logo'><br><br>";
        
    //     echo "Goles de equipo local: ".$partido->goals->home."<br>";
    //     echo "Goles de equipo visitante: ".$partido->goals->away."<br><br>";
    //     echo "</p>";
    // }

?>

<main>
    <h1 class="titulo_pagina">Partidos</h1>
    <article>
        <section class="fechas_partidos">
            <div>
                <?= $fechas_partidos ?>
            </div>
        </section>
        <!-- <section class="seccion_negra">
            <div class="partidos_liga">
                <a href="../controller/competicion.php">
                    <img src="../view/assets/images/logo.png" alt="Logo">
                    <span>La liga</span>
                </a>
                <i class="fa-solid fa-star icono_estrella"></i>
            </div>
            <hr>
            <div class="enfrentamiento_equipos">
                <a href="../controller/resumen_partido.php">
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Celta de Vigooooooooooooooooooo oooooooooooooo</span>
                    </div>
                    <div>
                        <p>VS</p>
                        <p>1 - 3</p>
                    </div>
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Rayo Vallecano</span>
                    </div>
                </a>
            </div>
            <hr class="separacion_partidos">
            <div class="enfrentamiento_equipos">
                <a href="../controller/resumen_partido.php">
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Celta de Vigo</span>
                    </div>
                    <div>
                        <p>VS</p>
                        <p>1 - 3</p>
                    </div>
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Rayo Vallecano</span>
                    </div>
                </a>
            </div>
        </section>
        <section class="seccion_negra">
            <div class="partidos_liga">
                <a href="../controller/competicion.php">
                    <img src="../view/assets/images/logo.png" alt="Logo">
                    <span>La liga</span>
                </a>
                <i class="fa-solid fa-star icono_estrella"></i>
            </div>
            <hr>
            <div class="enfrentamiento_equipos">
                <a href="../controller/resumen_partido.php">
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Celta de Vigo</span>
                    </div>
                    <div>
                        <p>VS</p>
                        <p>1 - 3</p>
                    </div>
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Rayo Vallecano</span>
                    </div>
                </a>
            </div>
            <hr class="separacion_partidos">
            <div class="enfrentamiento_equipos">
                <a href="../controller/resumen_partido.php">
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Celta de Vigo</span>
                    </div>
                    <div>
                        <p>VS</p>
                        <p>1 - 3</p>
                    </div>
                    <div>
                        <img src="../view/assets/images/logo.png" alt="Logo">
                        <span>Rayo Vallecano</span>
                    </div>
                </a>
            </div> -->
        <!-- </section> -->
        
        <?php

            foreach ($resultado->response as $key => $partido) {

                echo '
                    <section class="seccion_negra">
                    <div class="partidos_liga">
                        <a href="../controller/competicion.php">
                            <img src="'.$partido->league->logo.'" alt="Logo">
                            <span>'.$partido->league->name.'</span>
                        </a>
                        <i class="fa-solid fa-star icono_estrella"></i>
                    </div>
                    <hr>
                    <div class="enfrentamiento_equipos">
                        <a href="../controller/resumen_partido.php">
                            <div>
                                <img src="'.$partido->teams->home->logo.'" alt="Logo">
                                <span>'.$partido->teams->home->name.'</span>
                            </div>
                            <div>
                                <p>VS</p>
                                <p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>
                            </div>
                            <div>
                                <img src="'.$partido->teams->away->logo.'" alt="Logo">
                                <span>'.$partido->teams->away->name.'</span>
                            </div>
                        </a>
                    </div>
                    <hr class="separacion_partidos">
                    </section>';
            }

        ?>
    </article>
</main>