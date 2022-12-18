<?php 

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action{

        public function register(){

            if($this->autentication()){
                echo 1;
                header('location: /');
            }else{
                $user = Container::getModel('User');
                $user->__set('username',$_POST['username']);
                $user->__set('email',$_POST['email']);
                $user->__set('emailConfirm',$_POST['emailConfirm']);
                $user->__set('password',$_POST['password']);
                $user->__set('passwordConfirm',$_POST['passwordConfirm']);
    
                if($user->register()){
                    $user->autentication();
                    header('location: /');
                }else{
                    header('location: '.$_SERVER['HTTP_REFERER'].'?error=1&msg=ErroAoCadastrarUsuario');
                }
            }


        }

        public function login (){
            if($this->autentication()){
                header('location: /');
            }else{
                $user = Container::getModel('User');
                $user->__set('email',$_POST['email']);
                $user->__set('password',$_POST['password']);
    
                if($user->autentication()){
                    header('location: /');
                }else{
                    header('location: '.$_SERVER['HTTP_REFERER'].'?error=1&msg=ErroAoCadastrarUsuario');
                }
            }

        }

        public function logout(){
            session_destroy();
            header('location: '.$_SERVER['HTTP_REFERER']);
        }

    }

?>