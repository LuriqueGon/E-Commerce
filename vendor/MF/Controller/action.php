<?php

    namespace MF\Controller;
    use Smarty;

    abstract class Action{

        protected $view;   

        public function __construct(){
            $this->view = new \stdClass();
            $this->constructSmarty();
        }

        protected function render($view, $layout = 'layout'){
            $this->view->page = $view;
            if(file_exists("../app/View/layouts/$layout.tpl")){
                require_once "../app/View/layouts/$layout.tpl";
            }else{
                require "../app/view/error404.phtml";
            }
        }

        protected function content(){
            $atualClass =  strtolower(str_replace('Controller', '',str_replace('App\\Controllers\\', '', get_class($this)))); 
            $this->view->class = $atualClass;
            if(file_exists("../app/View/$atualClass/".$this->view->page.".tpl")){
                $this->view->smarty->display("$atualClass/".$this->view->page.".tpl");
            }else{
                require "../app/view/error404.phtml";
                exit;
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
    }

?>