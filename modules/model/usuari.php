<?php
    
    class Usuari implements JsonSerializable{

        //PROPERTIES
        private $id;
        private $nom;
        private $dni;
        private $email;

        //CONSTRUCT
        public function __construct($nom, $dni, $email, $id = null)
        {
            $this->nom = $nom;
            $this->dni = $dni;
            $this->email = $email;
            $this->id = $id; 
        }

        //GETTERS
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

        //SETTERS
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

        //METHODS
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