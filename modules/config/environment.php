<?php

    $environment = array(
        
        'protocol' => 'http://',
        
        // IMPORTANT CANVIAR EN CAS DE QUE SIGUI NECESSARI
        'baseUrl' => 'localhost/practiques_backend/UF1/practiques/Pt02_Sergi_Triado/',

        'dir' => (object)array(
            'modules' => (object)array(
                'api' => (object)array(
                    'create' => 'modules/api/create.php',
                    'read' => 'modules/api/read.php'
                ),
                'config' => (object)array(
                    'database' => 'modules/config/database.php',
                ),
                'control' => (object)array(
                    'usuaris' => 'modules/control/llista_usuaris.php'
                ),
                'model' => (object)array(
                    'usuari' => 'modules/model/usuari.php'
                )
            ),
            'public' => (object)array(
                'styles' => (object)array(),
                'buscador' => 'public/buscador.php',
                'newUser' => 'public/new_user.html'
            ),
            'templates' => (object)array(
                'newUser' => 'templates/new_user.php',
                'usersTable' => 'read_users_table.php'
            )
        )
    );

    define("ENVIRONMENT",(object)$environment);

?>