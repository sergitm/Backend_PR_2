<?php
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */

    // Generem una petició per eliminar l'usuari que hem clicat
    $env = json_decode(file_get_contents("../environment/environment.json"));

    $environment = $env->environment;

    if (!empty($_POST)) {

        foreach ($_POST as $key => $value) {
            $dni = $key;
        }

        $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->delete;
        
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

        // Mostrem el missatge adecuat
        if ($result !== null) {
            if ($result->deleted) {
                print '<h1 style=\'color:green;text-align:center\'>' . 'Usuari eliminat' . '</h1>';
            } else {
                print '<h1 style=\'color:red;text-align:center\'>' . 'Usuari no eliminat' . '</h1>';
            }
        } else {
            print '<h1 style=\'color:red;text-align:center\'>' . "L'usuari no existeix" . '</h1>';
        }
        // Redirigim al home 3 segons després de mostrar el missatge
        header("refresh:3;url=" . $environment->protocol . $environment->baseUrl);

    } else {
        // Redirigim a l'inici si s'intenta accedir a aquesta pàgina d'una forma que no sigui a través del formulari
        $url = $environment->protocol . $environment->baseUrl;

        header("refresh:3;url=" . $url);
    }

?>