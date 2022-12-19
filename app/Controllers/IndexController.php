<?php 

    namespace App\Controllers;
    use MF\Controller\Action;

    class IndexController extends Action{

        public function index(){
            $this->render('index');

        }

        public function auth(){
            if($this->autentication()){
                header('location: /');
            }

            $this->render('auth', 'defaultLay');
        }

        public function teste(){
            $this->render('teste');
        }
    }

?>