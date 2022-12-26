<?php

    namespace MF\Controller;

    use MF\Model\Container;
    use Smarty;

    abstract class Action{

        protected $view;   

        public function __construct(){
            $this->view = new \stdClass();
            $this->view->class = strtolower(str_replace('Controller', '',str_replace('App\\Controllers\\', '', get_class($this))));;
            $this->constructSmarty();
            $this->constructConsts();
            session_start();
        }

        protected function render($view, $layout = 'layout'){
            $this->view->page = $view;
            if(file_exists("../app/View/layouts/$layout.phtml")){
                require_once "../app/View/layouts/$layout.phtml";
            }else{
                echo 1;
                require "../app/view/error404.phtml";
            }
        }

        protected function autentication(){
            if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
                return true;
            }else{
                return false;
            }

        }

        protected function content(){
            if(file_exists("../app/View/".$this->view->class."/".$this->view->page.".phtml")){
                require "../app/view/".$this->view->class."/".$this->view->page.".phtml";
            }else{
                require "../app/view/error404.phtml";
                exit;
            }
        }

        protected function loadComponents($component){

            if($component == 'header'){
                require "../app/View/components/header.phtml";
            }else if($component == 'footer'){
                require "../app/View/components/footer.phtml";
            }else if($component == 'sidebar'){
                require "../app/View/components/sidebar.phtml";
            }else if($component == 'category'){
                require "../app/View/components/category.phtml";
            }else if($component == 'getImage'){
                require "../app/View/components/getImage.phtml";
            }else{
                if(file_exists("../app/view/components/".$this->view->class."/$component.phtml")){
                    require "../app/view/components/".$this->view->class."/$component.phtml";
                }else{
                    require "../app/view/components/$component.phtml";
                }
            }
        }

        private function constructSmarty(){
            $this->view->smarty = new Smarty();
            $this->view->smarty->setTemplateDir("../app/View/");
            $this->view->smarty->setConfigDir("../app/Config/");
            $this->view->smarty->setCompileDir("../app/View/Compiler/");
            $this->view->smarty->setCacheDir("../app/View/Cache/");
            $this->view->smarty->assign("nome", "Luiz Henrique");
        }

        private function constructConsts(){
            // PHPMAILER

            $this->view->phpMailer['emailHost'] = "smtp.gmail.com";
            $this->view->phpMailer['emailSiteAdmin'] = "gamenizados@gmail.com";
            $this->view->phpMailer['user'] = "";
            $this->view->phpMailer['name'] = "Contato E-Commerce";
            $this->view->phpMailer['password'] = "hfkmjxeiqxyywgsf";
            $this->view->phpMailer['port'] = 587;
            $this->view->phpMailer['smtpAuth'] = true;
            $this->view->phpMailer['smtpSecure'] = "tls";
            $this->view->phpMailer['emailCopy'] = "gamenizados@gmail.com";
        }
    }

?>