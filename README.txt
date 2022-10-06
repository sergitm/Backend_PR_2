@author Sergi Triadó <s.triado@sapalomera.cat>


Primer de tot, el que milloraria es el frontend. 
Els formularis es poden controlar molt millor però, essent sincers, gestionar el frontend amb PHP és una mica dolorós.
També podria millorar la presentació pero m'he centrat massa en l'estructura del Backend. Conformi escali l'aplicació aniré millorant coses

L'estructura de la aplicació es la següent

/environment/
        /environment.json   *** IMPORTANT CANVIAR EL VALOR DE LA BASEURL D'AQUEST FITXER PERQUE FUNCIONI

/modules/                   *** Aquesta carpeta és el propi Backend
        /api/               *** Entrada al Backend, cada fitxer s'encarrega d'una funció específica
            /create.php 
            /delete.php
            /read.php
            /update.php

        /config/            *** Fitxers amb les clases que pertanyen a la connexió a la BBDD
            /database.php

        /control/           *** Controlador
            /llista_usuaris.php

        /model/             *** model
            /usuari.php

/public/                    *** Fitxers HTML i PHP senzills que pertanyen a la VISTA
    /buscador.php           *** Buscador per buscar usuaris
    /new_user.html          *** Botó per afegir un nou usuari

/templates/                 *** Fitxers de PHP i formularis més complexes que necessiten de més codi
    /delete_user.php        *** Fitxer que s'executa quan es clica al botó d'eliminar un usuari
    /new_user.php           *** Fitxer que s'executa quan es clica al botó de crear un usuari, inclou el formulari amb les seves validacions
    /read_users_table.php   *** Fitxer que genera una taula segons una llista d'usuaris
    /update_form.php        *** Fitxer amb el formulari amb les seves validacions per modificar un usuari
    /update_user.php        *** Fitxer que consulta a la BBDD la informació d'un usuari per omplir els camps del formulari de modificació
    /validators.php         *** Clase amb funcions estàtiques per fer validacions més complexes als formularis

/index.php                  ***