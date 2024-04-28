<?php
    
    if (isset($_GET["idEquipo"]) && isset($_GET["anio"]) && isset($_GET["idCompeticion"])) {
        
        $idEquipo = $_GET["idEquipo"];
        $idCompeticion = $_GET["idCompeticion"];
        $anio = $_GET["anio"];

        $equipoEstadisticas = realizarConsulta("equipo_estadisticas_$idEquipo", "teams/statistics?league=$idCompeticion&season=$anio&team=$idEquipo", 86400); 

        // echo pintarEstadisticasEquipo($equipoEstadisticas);


    }

    function pintarEstadisticasEquipo($equipoEstadisticas) {
 
        // $tablaEstadisticas = "";
        $tipoEstadistica = array("Tiros a puerta", "Tiros a fuera", "Tiros totales", "Tiros bloqueados", "Tiros dentro del área", "Tiros fuera del área", "Faltas cometidas", "Saques de esquina", "Fueras de juego", "Posesión del balón", "Tarjetas amarillas", "Tarjetas rojas", "Tiros parados", "Pases totales", "Pases efectivos", "% de pases", "Goles esperados");

        // foreach ($$equipoEstadisticas->response as $key => $equipo) {
    
        //     $tablaEstadisticas .= "<div><div>Estadísticas</div>";
        //     $tablaEstadisticas .= "<div>Totales</div>";
        //     $tablaEstadisticas .= "<div>LocalVisitante</div>";
    
        //     foreach ($equipo->statistics as $key => $estadistica) {
    
        //         $tablaEstadisticas .= "
        //                 <tr>
        //                     <td>".."</td>
        //                     <td>". $estadistica->value ."</td>
        //                 </tr>";
    
        //     }
    
        //     $tablaEstadisticas .= "</tbody>
        //     </table>";
        // }
    
        // return $tablaEstadisticas;
    }
    