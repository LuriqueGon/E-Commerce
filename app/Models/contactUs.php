<?php

    namespace App\Models;
    use MF\Model\Model;

    class ContactUs extends Model {
        protected $id;
        protected $username;
        protected $emailSend;
        protected $numberContact;
        protected $msg;
        protected $protocol;
        protected $sendDate;
        protected $responseDate;
        protected $seen;
        protected $answered	;
        protected $replyEmail;

        private function protocolsDontExists(){
            $stmt = $this->db->prepare('SELECT protocol FROM message WHERE protocol = ? LIMIT 1');
            $stmt->bindValue(1, $this->__get('protocol'));
            $stmt->execute();

            if(!empty($stmt->fetch(\PDO::FETCH_ASSOC))){
                return false;
            }
            return true;
        }

        private function generateProtocol(){
            return bin2hex(random_bytes(20));
        }

        public function saveMessage(){
            $this->__set('protocol', $this->generateProtocol());
            if($this->protocolsDontExists()){

                $query = "INSERT INTO message(username, emailSend, numberContact, `message`, protocol, id_user) VALUES (?,?,?,?,?,?)";

                $stmt = $this->db->prepare($query);
                $stmt->bindValue(1, $this->__get('username'));
                $stmt->bindValue(2, $this->__get('emailSend'));
                $stmt->bindValue(3, $this->__get('numberContact'));
                $stmt->bindValue(4, $this->__get('msg'));
                $stmt->bindValue(5, $this->__get('protocol'));
                $stmt->bindValue(6, $_SESSION['id']);
                $stmt->execute();

            }else{
                $this->__set('protocol', $this->generateProtocol());
                $this->saveMessage();
            }
        }
    }
