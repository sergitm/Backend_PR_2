<?php
    require_once "../control/llista_usuaris.php";
    require_once "../config/database.php";
    require_once "../model/usuari.php";


    if (!empty($_GET['buscador'])) {

        $value = $_GET['buscador'];

        LlistaUsuaris::read_usuaris($value);
        $llista_usuaris = LlistaUsuaris::getUsuaris();

    } else {

        LlistaUsuaris::read_all_usuaris();
        $llista_usuaris = LlistaUsuaris::getUsuaris();    
    }

    echo json_encode($llista_usuaris);

?>