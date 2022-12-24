<?php 

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action{

        public function register(){

            if(!isset($_POST['username'])){
                header('location: / ');
                exit;
            }
            
            $user = Container::getModel('User');
            $user->__set('username',$_POST['username']);
            $user->__set('email',$_POST['email']);
            $user->__set('emailConfirm',$_POST['emailConfirm']);
            $user->__set('password',$_POST['password']);
            $user->__set('passwordConfirm',$_POST['passwordConfirm']);

            if($user->register()){
                $user->autentication();
                
                $msg = Container::getModel('message');
                $msg->setMessage('Cadastro feito com sucesso', 'success','/');
        
            }


        }

        public function login (){

            if(!isset($_POST['email'])){
                header('location: / ');
                exit;
            }
            
            $user = Container::getModel('User');
            $user->__set('email',$_POST['email']);
            $user->__set('password',$_POST['password']);
            
            if($user->autentication()){
                $msg = Container::getModel('message');
                $msg->setMessage('Login feito com sucesso', 'success','/');
            }
            

        }

        public function logout(){
            $_SESSION['username'] = "";
            $_SESSION['email'] = "";
            $_SESSION['perm'] = "";
            $_SESSION['ativo'] = "";
            $msg = Container::getModel('message');
            $msg->setMessage('Logout feito com sucesso', 'success','/');
        }

    }

?>