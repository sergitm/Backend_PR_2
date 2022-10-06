<?php

    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */

    // Fem un include del model per poder utilitzar-lo per crear la vista
    include_once "modules/model/usuari.php";


    // Construïm la petició a /modules/api/ (què és el que seria l'entrada al Backend) per recollir una llista d'usuaris
    $env = json_decode(file_get_contents("environment/environment.json"));

    $environment = $env->environment;

    $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->read;

    if (!empty($_GET['buscador'])) {
        $param = '?buscador=' . $_GET['buscador'];
    } else {
        $param = '';
    }
    
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET'
        )
    );
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url . $param, false, $context);

    $llista_usuaris = array();

    // Tenim la llista completa d'usuaris així que convertim les dades a objectes per poder treballar-les millor
    foreach (json_decode($result) as $usuariJson) {
        $usuari = new Usuari($usuariJson->nom, $usuariJson->dni, $usuariJson->adresa, $usuariJson->id);
        array_push($llista_usuaris, $usuari);
    }
    
    //Afegim la vista que ens mostrarà les dades
    include "public/buscador.php";
    include "public/new_user.html";

    if (count($llista_usuaris) > 0) {
        include "templates/read_users_table.php";
    }

?>