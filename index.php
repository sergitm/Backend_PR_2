<?php

    include_once "modules/config/environment.php";
    include_once "modules/model/usuari.php";

    $url = ENVIRONMENT->protocol . ENVIRONMENT->baseUrl . ENVIRONMENT->dir->modules->api->read;

    if (!empty($_GET['buscador'])) {
        $param = '?buscador=' . $_GET['buscador'];
    } else {
        $param = '';
    }
    
    // Construïm la petició a /modules/api/ (què és el que seria l'entrada al Backend)
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET'
        )
    );
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url . $param, false, $context);

    $llista_usuaris = array();
    
    foreach (json_decode($result) as $usuariJson) {
        $usuari = new Usuari($usuariJson->nom, $usuariJson->dni, $usuariJson->adresa, $usuariJson->id);
        array_push($llista_usuaris, $usuari);
    }
    
    include "public/buscador.php";
    include "public/new_user.html";

    if (count($llista_usuaris) > 0) {
        include "templates/read_users_table.php";
    }

?>