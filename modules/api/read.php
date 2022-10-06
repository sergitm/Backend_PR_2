<?php
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */
    require_once "../control/llista_usuaris.php";
    require_once "../config/database.php";
    require_once "../model/usuari.php";

    //Fitxer d'entrada al backend quan es vol fer un READ

    if (!empty($_GET['buscador'])) {

        $value = $_GET['buscador'];

        LlistaUsuaris::read_usuaris($value);
        $llista_usuaris = LlistaUsuaris::getUsuaris();

    } elseif (!empty($_POST['dni'])) {
        if (!empty($_POST['check'])) {
            $dni = $_POST['dni'];
        
            $llista_usuaris = array('exists' => LlistaUsuaris::check_dni($dni));
        } else {
            $dni = $_POST['dni'];

            $llista_usuaris = array('user' => LlistaUsuaris::read_usuari($dni));
        }
        
    } else {

        LlistaUsuaris::read_all_usuaris();
        $llista_usuaris = LlistaUsuaris::getUsuaris();    
    }

    echo json_encode($llista_usuaris);

?>