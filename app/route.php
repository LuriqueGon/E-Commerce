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
            $routes['cart'] = array(
                'route' => '/cart',
                'controller' => 'IndexController',
                'action' => 'cart'
            );         
            $routes['profile'] = array(
                'route' => '/profile',
                'controller' => 'IndexController',
                'action' => 'profile'
            );         
            $routes['favorite'] = array(
                'route' => '/favorite',
                'controller' => 'IndexController',
                'action' => 'favorite'
            );         
            $routes['Teste'] = array(
                'route' => '/teste',
                'controller' => 'IndexController',
                'action' => 'teste'
            );     
            $routes['contactUs'] = array(
                'route' => '/contactUs',
                'controller' => 'IndexController',
                'action' => 'contactUs'
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
            

            $routes['setImage'] = array(
                'route' => '/profile/setImage',
                'controller' => 'UserController',
                'action' => 'setImage'
            );            
            $routes['editProfile'] = array(
                'route' => '/profile/editProfile',
                'controller' => 'UserController',
                'action' => 'editProfile'
            );            
            $routes['setLocale'] = array(
                'route' => '/profile/setLocale',
                'controller' => 'UserController',
                'action' => 'setLocale'
            );            
            
            $routes['sendMessage'] = array(
                'route' => '/contactUs/sendMessage',
                'controller' => 'AdminController',
                'action' => 'sendMessage'
            );            
            
            
                    
            
            

            
            


            $this->setRoutes($routes);
        }

        
    }

?>