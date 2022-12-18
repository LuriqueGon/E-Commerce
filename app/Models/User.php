<?php

    namespace App\Models;
    use MF\Model\Model;

    class User extends Model {
        protected $username;
        protected $email;
        protected $emailConfirm;
        protected $password;
        protected $passwordConfirm;


        public function register(){
            $res = $this->resgiterValidation();

            if($res[0]){
                return $this->userRegister();
            }else{
                // TRATATIVA DA MSG
                echo $res[1];
            }
        }

        public function autentication(){
            $res = $this->loginValidation();

            if($res[0]){
               $this->sessionAuth($this->userLogin());
            }else{
                // TRATATIVA DA MSG
                echo $res[1];
            }
        }

        private function resgiterValidation(){
            if(strlen($this->__get('username')) > 4 && $this->__get('username')){
                if($this->__get('email')){
                    if(strlen($this->__get('password')) >= 8 && $this->__get('password')){
                        if($this->__get('email') == $this->__get('emailConfirm')){
                            if($this->__get('password') == $this->__get('passwordConfirm')){
                                if(empty($this->findByEmail())){
                                    return [true, "Sucesso"];
                                }else{
                                    return [false, "Email já cadastrado"];
                                }
                            }else{
                                return [false, "As senhas não são iguais"];
                            }
                        }else{
                            return [false, "os endereços de E-mail não são iguais"];
                        }
                    }else{
                        return [false, "A senha deve ter pelo menos 8 caracteres"];
                    }
                }else{
                    return [false, "insira seu email"];
                }
            }else{
                return [false, "Usuario precisa ter pelo menos 4 caracteres"];
            }
            
        }

        private function loginValidation(){
            if($this->__get('email')){
                if(strlen($this->__get('password')) >= 8 && $this->__get('password')){
                    return [true, "Sucesso"];
                }else{
                    return [false, "A senha deve ter pelo menos 8 caracteres"];
                }
            }else{
                return [false, "insira seu email"];
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
            $query = "SELECT * FROM users WHERE email = ? AND `password` =?";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindValue(1,$this->__get('email'));
            $stmt->bindValue(2,md5($this->__get('password')));

            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        



        private function findByEmail(){
            $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->bindValue(1, $this->__get('email'));
            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        private function sessionAuth($user){
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['perm'] = $user['perm'];
            $_SESSION['ativo'] = $user['ativo'];
        }

    }
