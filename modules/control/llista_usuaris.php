<?php

    class LlistaUsuaris{
        
        private static $llistaUsuaris;

        public static function getUsuaris(){
            return self::$llistaUsuaris;
        }

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

        public static function create_usuari($data){
            $usuari = new Usuari($data['nom'], $data['dni'], $data['adresa']);

            $res = $usuari->create();

            Connexio::close();
            
            return $res;
        }
    }
?>