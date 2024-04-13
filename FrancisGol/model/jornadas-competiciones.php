<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures?league='.$liga.'&season='.$anio,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-rapidapi-key: be6e260f0828d5854c973280d67305cd',
            'x-rapidapi-host: v3.football.api-sports.io'
        ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);

        $resultado = json_decode($response);
        // print_r($resultado);

        echo "<h3>Jornadas de liga: </h3>";
        foreach ($resultado->response as $key => $jornada) {

            print_r($jornada);
            echo "<p>ID del partido: ".$jornada->fixture->id."<br>";
            echo "Arbitro: ".$jornada->fixture->referee."<br>";
            echo "Ciudad: ".$jornada->fixture->venue->city."<br>";
            echo "ID Estadio: ".$jornada->fixture->venue->id."<br>";
            echo "Estadio: ".$jornada->fixture->venue->name."<br>";
            echo "Estado del partido: ".$jornada->fixture->status->long."<br>";
            echo "Tipo de finalización: ".$jornada->fixture->status->short."<br>";
            echo "Tiempo jugado: ".$jornada->fixture->status->elapsed."<br>";

            echo "<br>Liga<br>";
            echo "id: ".$jornada->league->id."<br>";
            echo "Nombre: ".$jornada->league->name."<br>";
            echo "Pais: ".$jornada->league->country."<br>";
            echo "Año: ".$jornada->league->season."<br>";
            echo "La jornada: ".$jornada->league->round."<br>";
            echo "<img src=".$jornada->league->logo." alt='logo'>";
            echo "<img src=".$jornada->league->flag." alt='bandera'><br>";

            echo "<br>Equipos<br>";
            echo "Equipo local:<br>";
            echo "id: ".$jornada->teams->home->id."<br>";
            echo "Nombre: ".$jornada->teams->home->name."<br>";
            echo "Resultado: ".$jornada->teams->home->winner."<br>";
            echo "<img src=".$jornada->teams->home->logo." alt='logo'><br>";

            echo "Equipo Visitante:<br>";
            echo "id: ".$jornada->teams->away->id."<br>";
            echo "Nombre: ".$jornada->teams->away->name."<br>";
            echo "Resultado: ".$jornada->teams->away->winner."<br>";
            echo "<img src=".$jornada->teams->away->logo." alt='logo'><br>";

            echo "<br>Resultado: ".$jornada->goals->home." - ".$jornada->goals->away."<br>";


            echo "</p>";

        }

        
    ?>
</body>
</html>

<!-- https://dashboard.api-football.com/# -->
<!-- 100 peticiones gratuitas al día durante un año-->
<!-- https://www.api-football.com/news/category/tutorials -->
<!-- https://www.api-football.com/documentation-v3#section/Changelog   -> ENDPOINTS -->