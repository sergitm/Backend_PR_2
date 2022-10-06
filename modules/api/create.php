<?php
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */

    require_once "../config/database.php";
    include_once "../control/llista_usuaris.php";
    include_once "../model/usuari.php";

    // Fitxer d'entrada al backend quan es vol fer un INSERT

    if (empty($_POST['nom']) || empty($_POST['dni']) || empty($_POST['adresa'])) {
        echo array('error' => 'Hi ha camps buits');
    } else {
        $data = $_POST;
        $res = LlistaUsuaris::create_usuari($data);

        if ($res === TRUE) {
            echo json_encode(
                array('success' => 'Usuari introduit correctament!')
            );
        } else {
            echo json_encode(
                array('error' => 'Usuari no introduit, alguna cosa ha fallat')
            );
        }

    }

?>