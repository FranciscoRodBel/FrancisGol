<?php

    
    // foreach ($partidos->response as $key => $partido) {

    //     print_r($partido);          
        // echo "<p>ID del partido: ".$partido->fixture->id."<br>";
        // echo "ID del partido2: ".$partido->fixture->venue->id."<br>";
        // echo "Estado del partido: ".$partido->fixture->status->long."<br>";
        // echo "Estado del partido2: ".$partido->fixture->status->short."<br>";
        // echo "Tiempo transcurrido: ".$partido->fixture->status->elapsed."<br><br>";

        // echo "Id liga: ".$partido->league->id."<br>";
        // echo "nombre liga: ".$partido->league->name."<br>";
        // echo "<img src=".$partido->league->logo." alt='logo'><br><br>";

        // echo "ID equipo local: ".$partido->teams->home->id."<br>";
        // echo "Nombre equipo local: ".$partido->teams->home->name."<br>";
        // echo "Ganando equipo local: ".$partido->teams->home->winner."<br>";
        // echo "<img src=".$partido->teams->home->logo." alt='logo'><br><br>";

        // echo "ID equipo visitante: ".$partido->teams->away->id."<br>";
        // echo "Nombre equipo visitante: ".$partido->teams->away->name."<br>";
        // echo "Ganando equipo visitante: ".$partido->teams->away->winner."<br>";
        // echo "<img src=".$partido->teams->away->logo." alt='logo'><br><br>";
        
        // echo "Goles de equipo local: ".$partido->goals->home."<br>";
        // echo "Goles de equipo visitante: ".$partido->goals->away."<br><br>";
        // echo "</p>";
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
        <?= $partidosSeleccionados ?>
    </article>
</main>