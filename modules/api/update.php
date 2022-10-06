<?php

    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */

require_once "../control/llista_usuaris.php";
require_once "../config/database.php";
require_once "../model/usuari.php";

//Fitxer d'entrada al Backend quan es vol fer un UPDATE

if (!empty($_POST['dni']) && !empty($_POST['nom']) && !empty($_POST['adresa'])) {
    $data = $_POST;

    $response = LlistaUsuaris::update_usuari($data);

    if(!$response){
        echo json_encode(
            array('updated' => false, 
                    'message' => 'Ha fallat alguna cosa en el procés de modificació')
        );
    } else {
        echo json_encode(
            array('updated' => true,
                    'message' => 'Usuari modificat')
        );
    }
} else {
    echo json_encode(
        array('updated' => false,
                'message' => 'Falten dades per poder modificar!')
    );
}

?>