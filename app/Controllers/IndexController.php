<?php 

    namespace App\Controllers;
    use MF\Controller\Action;
use MF\Model\Container;

    class IndexController extends Action{

        public function index(){
            $this->render('index', 'layoutCatego');

        }

        public function auth(){
            if($this->autentication()){
                header('location: /');
            }

            $this->render('auth', 'defaultLay');
        }

        public function cart(){

            $msg = Container::getModel('message');
            if(!$this->autentication()){
                $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            }

            $this->render('cart');
        }

        public function profile(){

            $msg = Container::getModel('message');
            if(!$this->autentication()){
                $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            }
            
            $this->render('profile');
        }

        public function favorite(){
            
            $msg = Container::getModel('message');
            if(!$this->autentication()){
                $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            }
            
            $this->render('favorite');
        }

        public function teste(){
            $this->render('teste');
        }
    }

?>