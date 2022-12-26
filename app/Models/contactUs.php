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
        protected $answered;
        protected $answer;
        protected $emailResponse;
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

        public function getMessages(){
            $stmt = $this->db->prepare('SELECT m.id, m.username, m.emailSend, m.numberContact, m.message, m.protocol, m.sendDate, m.id_user, m.seen, m.answered, u.ativo, u.perfil FROM `message` as m LEFT JOIN users as u ON m.id_user = u.id WHERE u.ativo = 1 ORDER BY seen ASC, answered ASC');
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getMessage(){
            $stmt = $this->db->prepare('SELECT m.id, m.username, m.emailSend, m.numberContact, m.message, m.protocol, m.sendDate, m.id_user, m.seen, m.answered, m.replyEmail, m.answer, m.responseDate, u.ativo, u.perfil FROM `message` as m LEFT JOIN users as u ON m.id_user = u.id WHERE u.ativo = 1 AND m.id = ? ORDER BY seen ASC, answered ASC');
            $stmt->bindValue(1, $this->__get('id'));
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function seeMessage(){
            $stmt = $this->db->prepare('UPDATE `message` SET seen = 1 WHERE id = ?');
            $stmt->bindValue(1, $this->__get('id'));
            $stmt->execute();
        }

        public function answerMessage(){
            $stmt = $this->db->prepare('UPDATE `message` SET responseDate = ?, answered = 1, answer = ?, replyEmail = ? WHERE id = ?');
            $stmt->bindValue(1, $this->__get('responseDate'));
            $stmt->bindValue(2, $this->__get('answer'));
            $stmt->bindValue(3, $this->__get('emailResponse'));
            $stmt->bindValue(4, $this->__get('id'));
            $stmt->execute();
        }
        
        
    }
