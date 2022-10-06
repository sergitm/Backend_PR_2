<?php
    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */
    
    /**
     * Validators
     */
    class Validators {
        
        /**
         * dni_exists
         *
         * @param  mixed $dni
         * @return boolean $resultat->exists que ve del Backend
         * 
         * Fa una petició al backend per comprobar si el dni que passem per paràmetre existeix a la BBDD
         */
        public static function dni_exists($dni){

            $env = json_decode(file_get_contents("../environment/environment.json"));
            $environment = $env->environment;
            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->read;
            
            $data = array('dni' => $dni, 'check' => true);

            // Construïm la petició a /modules/api/ (què és el que seria l'entrada al Backend)
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context  = stream_context_create($options);
            $result = json_decode(file_get_contents($url, false, $context));

            // Retorna true o false depenen de si ha trobat alguna coincidencia
            if($result !== null) {
                return $result->exists;
            } else {
                throw new Exception('Error: Base de dades desconnectada.');
            }
            
        }
    }
?>