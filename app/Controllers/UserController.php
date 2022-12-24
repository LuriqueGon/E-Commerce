<?php 

    namespace App\Controllers;
    use MF\Controller\Action;
    use MF\Model\Container;

    class UserController extends Action{

        public function setImage(){

            $msg = Container::getModel('message');
            if(!$this->autentication()){
                $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            }
            

            $arquivo = $_FILES['perfil'];

            if(!empty($arquivo['tmp_name']) && isset($_FILES['perfil'])){
                $arquivo['type'] = explode('/',$arquivo['type'])[1];
                if(in_array($arquivo['type'], ["jpeg","jpg","JPEG","JPG", "PNG",'png'])){
                    if(in_array($arquivo['type'], ["jpeg","jpg","JPEG","JPG"])){
                        $imageFile = imagecreatefromjpeg($arquivo['tmp_name']);
                    }else{
                        $imageFile = imagecreatefrompng($arquivo['tmp_name']);
                    }
    
                    $imageName = bin2hex(random_bytes(20)). 'jpg';
                    @mkdir(__DIR__.'../../../public/img/profiles/'.$_SESSION['username'], 0777, true);
                    imagejpeg($imageFile, "img/profiles/".$_SESSION['username']."/".$imageName,100);
    
                    $user = Container::getModel('user');
                    $user->__set('email',$_SESSION['email']);
                    $user->__set('perfil', $_SESSION['username']."/".$imageName);
    
                    if($user->setImage()){
                        $msg->setMessage('Imagem adicionada com sucesso', 'success', 'back');
                    }else{
                        $msg->setMessage('Erro ao adicionar Imagem', 'error', 'back');
                    }
                }else{
                    $msg->setMessage('Envie somente imagens', 'error', 'back');
                }

                
            }      
            
            
        }

        public function editProfile(){

            $msg = Container::getModel('message');
            if(!$this->autentication()){
                $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
                exit;
            }

            $user = Container::getModel('user');

            $user->__set('email', $_SESSION['email']);
            $userDefault = $user->findByEmail();
            

            $user->__set('username', empty($_POST['username']) ? $userDefault['username'] : $_POST['username']);
            $user->__set('email', empty($_POST['email']) ? $userDefault['email'] : $_POST['email']);

            if(!empty($_POST['password'])){
                if($_POST['password'] == $_POST['passwordConfirm']){
                    $user->__set('password', md5($_POST['password']));
                }else{
                    $msg->setMessage('As senhas não coincidem', 'error', 'back');
                }
            }else{
                $user->__set('password', $userDefault['password']);
            }

            

            if($user->edit()){
                $msg = Container::getModel('message');
                $msg->setMessage('Perfil Editado Com Sucesso', 'success', 'back');
            }else{
                $msg = Container::getModel('message');
                $msg->setMessage('Erro ao Editar Perfil', 'error', 'back');
            }
        }

        public function setLocale(){
            $msg = Container::getModel('message');
            if(!$this->autentication()){
                $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            }
            

            $user = Container::getModel('user');
            $user->__set('email', $_SESSION['email']);

            $locale = Container::getModel('locale');
            $locale->__set('cep', $_POST['cep']);
            $locale->__set('estado', $_POST['estado']);
            $locale->__set('cidade', $_POST['cidade']);
            $locale->__set('bairro', $_POST['bairro']);
            $locale->__set('logadouro', $_POST['logadouro']);
            $locale->__set('complemento', $_POST['complemento']);
            $locale->__set('rua', $_POST['rua']);
            $locale->__set('number', $_POST['number']);
            $locale->__set('obs', $_POST['obs']);
            $locale->__set('idUser', $_SESSION['id']);

            if($locale->setLocale()){

                if(!$user->haveLocale()){
                    $locale->__set('id', $locale->getIdByIdUser());
                    $locale->setMainLocale(); 
                }


                $msg->setMessage('Endereço adicionado com sucesso', 'success', 'back');
            }else{
                $msg->setMessage('Erro ao Adicionar Endereço', 'error', 'back');
            }
            
            
        }
        
    }

?>