<?php

    /**
     * @author Sergi Triadó <s.triado@sapalomera.cat>
     */
        
    /**
     * Usuari
     * implementa la interfície JsonSerializable perque els objectes d'aquesta classe es 
     * puguin convertir en objectes JSON
     */
    class Usuari implements JsonSerializable{

        // PROPERTIES
        private $id;
        private $nom;
        private $dni;
        private $email;

        // CONSTRUCT
        public function __construct($nom, $dni, $email, $id = null)
        {
            $this->nom = $nom;
            $this->dni = $dni;
            $this->email = $email;
            $this->id = $id; 
        }

        // GETTERS
        public function getNom(){
            return $this->nom;
        }
        public function getDni(){
            return $this->dni;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getId(){
            return $this->id;
        }

        // SETTERS
        public function setNom($nom){
            $this->nom = $nom;
        }
        public function setDni($dni){
            $this->dni = $dni;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function setId($id){
            $this->id = $id;
        }

        // METHODS        
        /**
         * create
         *
         * @return void
         * 
         * Métode per introduir un usuari a la BBDD
         */
        public function create(){
            $query = "INSERT INTO usuaris (id, nom, dni, adresa)
                        VALUES (:id, :nom, :dni, :adresa)";

            $params = array(':id' => $this->getId(), 
                            ':nom' => strtoupper($this->getNom()), 
                            ':dni' => strtoupper($this->getDni()), 
                            ':adresa' => strtolower($this->getEmail())
            );

            Connexio::connect();
            $stmt = Connexio::execute($query,$params);

            if ($stmt) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * delete
         *
         * @return void
         * 
         * Métode per eliminar un usuari de la BBDD
         */
        public function delete(){
            $query = "DELETE FROM usuaris WHERE dni = :dni";

            $params = array(':dni' => $this->getDni());

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);
            Connexio::close();

            return $stmt;
        }
        
        /**
         * update
         *
         * @return void
         * 
         * Métode per modificar un usuari de la BBDD
         */
        public function update(){
            $query = "UPDATE usuaris SET nom = :nom, adresa = :adresa WHERE id = :id";

            $params = array(':nom' => $this->getNom(), ':adresa' => $this->getEmail(), ':id' => $this->getId());

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);
            Connexio::close();
            
            return $stmt;
        }
        
        /**
         * jsonSerialize
         *
         * @return void
         * 
         * Métode de la interfícia JsonSerializable que indica la seva estructura quan es converteixi a JSON
         */
        public function jsonSerialize(){
            return [
                'nom' => $this->getNom(),
                'dni' => $this->getDni(),
                'adresa' => $this->getEmail(),
                'id' => $this->getId()
            ];
        }
    }

?>