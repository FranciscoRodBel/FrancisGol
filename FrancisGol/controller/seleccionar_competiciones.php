<?php
    if (isset($_POST['query'])) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://v3.football.api-sports.io/leagues',
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
    
        $competiciones_pais = "";
        $codigoPais = $_POST['query'];

        foreach ($resultado->response as $key => $liga) {

            $competiciones = "<div>";
                // $competiciones .= "<p>ID: ".$liga->league->id."<br>";
                $competiciones .= "<img src=".$liga->league->logo." alt='logo competición'>";
                $competiciones .= "<p>".$liga->league->name."</p>";
                $competiciones .= '<i class="fa-solid fa-star icono_estrella"></i>';
                // $competiciones .= "Tipo: ".$liga->league->type."<br>";
            $competiciones .= "</div><hr>";

            if ($liga->country->code == $codigoPais) {
                $competiciones_pais .= $competiciones;
            }
    
        }

        echo $competiciones_pais;
    }