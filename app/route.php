<?php

namespace App; 
use MF\Init\Bootstrap; 

    class Route extends Bootstrap{

        protected function initRoutes(){
            $routes['home'] = array(
                'route' => '/',
                'controller' => 'IndexController',
                'action' => 'index'
            );            

            $routes['categoriaRoupas'] = array(
                'route' => '/categorias/roupas',
                'controller' => 'IndexController',
                'action' => 'index'
            );            

            


            $this->setRoutes($routes);
        }

        
    }

?>