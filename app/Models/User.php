<?php

    namespace App\Models;
    use MF\Model\Model;
    use MF\Model\Container;

    class User extends Model {
        protected $id;
        protected $username;
        protected $email;
        protected $emailConfirm;
        protected $password;
        protected $passwordConfirm;
        protected $msg;
        protected $perfil;

        public function register(){
            if($this->resgiterValidation()){
                return $this->userRegister();
            }else{
                // TRATATIVA DA MSG
            }
        }

        public function autentication(){
            if($this->loginValidation()){
                echo 2;
                $user = $this->userLogin();
                if(!empty($user)){
                    echo 3;
                    $this->sessionAuth($user);

                    $_SESSION['id'] = $this->getIdByEmail();
                    return true;
                }else{
                    $this->msg = Container::getModel('message');
                    $this->msg->setMessage('Email não cadastrado ou Inativo', 'error','back');
                }
            }
        }

        public function setImage(){
            $stmt = $this->db->prepare('UPDATE users SET perfil = ? WHERE email = ?');
            $stmt->bindValue(1,$this->__get('perfil'));
            $stmt->bindValue(2,$this->__get('email'));

            if($stmt->execute()){
                return true;

            }
        }

        public function getImage(){
            $stmt = $this->db->prepare('SELECT perfil FROM users WHERE id = ?');
            $stmt->bindValue(1,$this->__get('id'));

            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC)['perfil'];
        }

        public function edit(){
            $query = "UPDATE users SET username = ?, email = ?, `password` = ? WHERE email = ?";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(1,$this->__get('username'));
            $stmt->bindValue(2,$this->__get('email'));
            $stmt->bindValue(3,$this->__get('password'));
            $stmt->bindValue(4,$_SESSION['email']);

            $_SESSION['username'] = $this->__get('username');
            $_SESSION['email'] = $this->__get('email');

            if($stmt->execute()){
                return true;
            }
        }

        private function resgiterValidation(){
            $this->msg = Container::getModel('message');

            if(strlen($this->__get('username')) > 4 && $this->__get('username')){
                if($this->__get('email')){
                    if(strlen($this->__get('password')) >= 8 && $this->__get('password')){
                        if($this->__get('email') == $this->__get('emailConfirm')){
                            if($this->__get('password') == $this->__get('passwordConfirm')){
                                if(empty($this->findByEmail())){
                                    return true;
                                }else{
                                    $this->msg->setMessage('Email já cadastrado','error','back');
                                }
                            }else{
                                $this->msg->setMessage('As senhas não são iguais','error','back');
                            }
                        }else{
                            $this->msg->setMessage('os endereços de E-mail não são iguais','error','back');
                        }
                    }else{
                        $this->msg->setMessage('A senha deve ter pelo menos 8 caracteres','error','back');
                    }
                }else{
                    $this->msg->setMessage('insira seu email','error','back');
                }
            }else{
                $this->msg->setMessage('Usuario precisa ter pelo menos 4 caracteres','error','back');
            }
            
        }

        private function loginValidation(){
            $this->msg = Container::getModel('message');

            if($this->__get('email')){
                if(strlen($this->__get('password')) >= 8 && $this->__get('password')){
                    return true;
                }else{
                    $this->msg->setMessage('A senha deve ter pelo menos 8 caracteres','error','back');
                }
            }else{
                $this->msg->setMessage('insira seu email','error','back');
            }
        }

       
        private function userRegister(){
            $query = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?,?,?)";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindValue(1,$this->__get('username'));
            $stmt->bindValue(2,$this->__get('email'));
            $stmt->bindValue(3,md5($this->__get('password')));

            $stmt->execute();
            return true;
        }

        private function userLogin(){
            $query = "SELECT * FROM users WHERE email = ? AND `password` =? AND ativo = 1";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindValue(1,$this->__get('email'));
            $stmt->bindValue(2,md5($this->__get('password')));

            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function findByEmail(){
            $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->bindValue(1, $this->__get('email'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function getIdByEmail(){
            $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->bindValue(1, $this->__get('email'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC)['id'];
        }

        public function haveLocale(){
            $stmt = $this->db->prepare('SELECT localeMainId FROM users WHERE email = ?');
            $stmt->bindValue(1, $this->__get('email'));
            $stmt->execute();

            if(empty($stmt->fetch(\PDO::FETCH_ASSOC)['localeMainId'])){
                return false;
            }else{
                return true;
            }
        }

        private function sessionAuth($user){
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['perm'] = $user['perm'];
            $_SESSION['ativo'] = $user['ativo'];
        }

    }
