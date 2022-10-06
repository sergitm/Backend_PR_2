<?php

    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */
    
    /**
     * LlistaUsuaris
     * 
     * Clase controladora amb métodes estatics per treballar amb els objectes 
     * de la clase usuari i gestionar les peticions que arribin al Backend
     */
    class LlistaUsuaris{
        
        private static $llistaUsuaris;
        
        // GETTER
        public static function getUsuaris(){
            return self::$llistaUsuaris;
        }

                
        /**
         * check_dni
         *
         * @param  mixed $dni
         * @return Boolean 
         * 
         * Métode que comproba a la BBDD si el DNI del paràmetre existeix
         */
        public static function check_dni($dni){
            $query = 'SELECT * FROM usuaris WHERE dni = :dni';

            $params = array(':dni' => strtoupper($dni));

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                return true;
            } else {
                return false;
            }
        }
        
        /**
         * read_all_usuaris
         *
         * @return void
         * 
         * Métode que consulta a la BBDD tots els usuaris i els afegeix a la propietat $llistaUsuaris
         */
        public static function read_all_usuaris(){
            self::$llistaUsuaris = array();

            $query = 'SELECT * FROM usuaris';

            Connexio::connect();
            $stmt = Connexio::execute($query);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                foreach ($result as $row) {
                    extract($row);
                    
                    $usuari = new Usuari($row['nom'], $row['dni'], $row['adresa'], $row['id']);

                    array_push(self::$llistaUsuaris, $usuari);

                }
            }

            Connexio::close();
        }
        
        /**
         * read_usuaris
         *
         * @param  mixed $value
         * @return void
         * 
         * Métode que busca usuaris buscant coincidències amb el valor que arriba per paràmetre (ve del buscador)
         */
        public static function read_usuaris($value){
            self::$llistaUsuaris = array();

            $keyword = '%' . $value . '%';

            $query = "SELECT * FROM usuaris WHERE nom LIKE :nom OR dni LIKE :dni OR adresa LIKE :adresa;";
            $params = array(':nom' => strtoupper($keyword), ':dni' => strtoupper($keyword), ':adresa' => strtolower($keyword));

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if($num > 0){
                foreach($result as $row){
                    extract($row);

                    $usuari = new Usuari($row['nom'], $row['dni'], $row['adresa'], $row['id']);

                    array_push(self::$llistaUsuaris, $usuari);
                }
            }

            Connexio::close();
        }
        
        /**
         * read_usuari
         *
         * @param  mixed $dni
         * @return Usuari 
         * 
         * Métode que llegeix un usuari específic per DNI
         */
        public static function read_usuari($dni){
            $query = 'SELECT * FROM usuaris WHERE dni = :dni';

            $params = array(':dni' => $dni);

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                $row = $result[0];

                $usuari = new Usuari($row['nom'], $row['dni'], $row['adresa'], $row['id']);

                Connexio::close();

                return $usuari;
            } else {
                Connexio::close();
                throw new Exception("No s'han trobat usuaris.");
            }
        }
        
        /**
         * create_usuari
         *
         * @param  mixed $data
         * @return boolean
         * 
         * Crea l'usuari que arriba per petició a la BBDD
         */
        public static function create_usuari($data){
            $usuari = new Usuari($data['nom'], $data['dni'], $data['adresa']);

            $res = $usuari->create();

            Connexio::close();
            
            return $res;
        }
        
        /**
         * delete_usuari
         *
         * @param  mixed $dni
         * @return boolean
         * 
         * Métode que elimina l'usuari que tingui el DNI que arribi per petició
         */
        public static function delete_usuari($dni){
            $usuari = self::read_usuari($dni);

            return $usuari->delete();
        }
        
        /**
         * compare_usuaris
         *
         * @param  Usuari $usuari
         * @param  Usuari $usuari_original
         * @return Usuari
         * 
         * Métode que compara usuari i usuari_original per fer les modificacions pertinents a la BBDD
         */
        public static function compare_usuaris($usuari, $usuari_original){

            $nom = ($usuari->getNom() !== $usuari_original->getNom()) ? $usuari->getNom() : $usuari_original->getNom();
            $dni = $usuari_original->getDni();
            $email = ($usuari->getEmail() !== $usuari_original->getEmail()) ? $usuari->getEmail() : $usuari_original->getEmail();

            return new Usuari($nom, $dni, $email, $usuari_original->getId());
        }
        
        /**
         * update_usuari
         *
         * @param  mixed $data
         * @return boolean
         * 
         * Métode que modifica l'usuari a la BBDD
         */
        public static function update_usuari($data){
            $usuari = new Usuari($data['nom'], $data['dni'], $data['adresa']);
            $usuari_original = self::read_usuari($data['dni']);

            $usuari_final = self::compare_usuaris($usuari, $usuari_original);

            return $usuari_final->update();
        }
    }
?>