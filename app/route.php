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
            $routes['auth'] = array(
                'route' => '/auth',
                'controller' => 'IndexController',
                'action' => 'auth'
            );  
                      

            $routes['categoriaRoupas'] = array(
                'route' => '/categorias/roupas',
                'controller' => 'IndexController',
                'action' => 'index'
            );            
            $routes['Teste'] = array(
                'route' => '/teste',
                'controller' => 'IndexController',
                'action' => 'teste'
            );            
            

            $routes['cadastrar'] = array(
                'route' => '/auth/register',
                'controller' => 'AuthController',
                'action' => 'register'
            );            
            $routes['entrar'] = array(
                'route' => '/auth/login',
                'controller' => 'AuthController',
                'action' => 'login'
            );            
            $routes['sair'] = array(
                'route' => '/logout',
                'controller' => 'AuthController',
                'action' => 'logout'
            );            
            

            
            


            $this->setRoutes($routes);
        }

        
    }

?>