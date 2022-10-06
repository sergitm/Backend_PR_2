<?php
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */

    require_once "../control/llista_usuaris.php";
    require_once "../config/database.php";
    require_once "../model/usuari.php";

    // Fitxer d'entrada al backend quan es vol fer un DELETE

    if (!empty($_POST['dni'])) {
        $dni = $_POST['dni'];

        $response = LlistaUsuaris::delete_usuari($dni);

        if(!$response){
            echo json_encode(
                array('deleted' => false)
            );
        } else {
            echo json_encode(
                array('deleted' => true)
            );
        }
    } else {
        echo json_encode(
            array('deleted' => false)
        );
    }

?>