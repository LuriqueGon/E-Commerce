<?php

    namespace App\Models;
    use MF\Model\Model;

    class Locale extends Model {
        protected $id;
        protected $cep;
        protected $estado;
        protected $cidade;
        protected $bairro;
        protected $logadouro;
        protected $complemento;
        protected $rua;
        protected $number;
        protected $obs;
        protected $idUser;

        public function setLocale(){
            $query = "INSERT INTO locale (id, cep, estado, cidade, bairro, logadouro, rua, numero, complemento, obs, id_user) VALUES (NULL,?,?,?,?,?,?,?,?,?,?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(1,$this->__get('cep'));
            $stmt->bindValue(2,$this->__get('estado'));
            $stmt->bindValue(3,$this->__get('cidade'));
            $stmt->bindValue(4,$this->__get('bairro'));
            $stmt->bindValue(5,$this->__get('logadouro'));
            $stmt->bindValue(6,$this->__get('rua'));
            $stmt->bindValue(7,$this->__get('number'));
            $stmt->bindValue(8,$this->__get('complemento'));
            $stmt->bindValue(9,$this->__get('obs'));
            $stmt->bindValue(10,$this->__get('idUser'));

            if($stmt->execute()){
                return true;
            }
        }

        public function getIdByIdUser(){
            $stmt = $this->db->prepare("SELECT id FROM locale  WHERE id_user = ? ");
            $stmt->bindValue(1,$this->__get('idUser'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC)['id'];
        }
        
        public function setMainLocale(){
            $stmt = $this->db->prepare("UPDATE users SET localeMainId = ? WHERE id = ?");
            $stmt->bindValue(1,$this->__get('id'));
            $stmt->bindValue(2,$this->__get('idUser'));
            $stmt->execute();
        }

        public function findById(){
            $stmt = $this->db->prepare("SELECT * FROM locale WHERE id_user = ? LIMIT 1");
            $stmt->bindValue(1,$this->__get('idUser'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
    }
