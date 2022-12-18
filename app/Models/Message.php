<?php

    namespace App\Models;
    use MF\Model\Model;

    class Message extends Model {
        protected $msg;

        public function setMessage($msg, $type, $redirect = "/"){
            $_SESSION['msg'] = $msg;
            $_SESSION['type'] = $type;

            if($redirect == "back"){
                header('location: '. $_SERVER['HTTP_REFERER']);
            }else{
                header('location: '. $redirect);
            }
        }
        
        public function getMessage(){
            if(!empty($_SESSION['msg'])){
                return [
                    "type" => $_SESSION['type'],
                    "msg" => $_SESSION['msg']
                ];
            }else{
                return false;
            }
        }

        public function clearMessage(){
            $_SESSION['msg'] = "";
            $_SESSION['type'] = "";
        }
    }
