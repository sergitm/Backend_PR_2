<?php
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */
    
// Generem la petició que cridarà a la BBDD perque els camps del formulari s'emplenin amb les dades originals
$env = json_decode(file_get_contents("../environment/environment.json"));

$environment = $env->environment;

if (!empty($_GET)) {

    foreach ($_GET as $key => $value) {
        $dni = $key;
    }

    $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->read;
    
    $data = array('dni' => $dni);
    
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = json_decode(file_get_contents($url, false, $context));

    if (!empty($result)) {
        $usuari = $result->user;

        include "update_form.php";
    }
// Incluim la vista (formulari)
} elseif (!empty($_POST)) {
    include "update_form.php";
}

?>