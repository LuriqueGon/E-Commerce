<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

class AdminController extends Action
{

    public function sendMessage()
    {
        // ENVIAR MENSAGEM POR EMAIL

        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";

        $message = Container::getModel('contactUs');
        $message->__set('username',$_POST['txtName']);
        $message->__set('emailSend',$_POST['txtEmail']);
        $message->__set('numberContact',$_POST['txtPhone']);
        $message->__set('msg',$_POST['txtMsg']);
        $message->saveMessage();

        $protocolo = $message->__get('protocol');

        $mail = new PHPMailer(true);

        try {
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->view->phpMailer['emailHost'];//Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->view->phpMailer['emailSiteAdmin'];                     //SMTP username
            $mail->Password   = $this->view->phpMailer['password'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($_POST['txtEmail'],$_POST['txtName']);
            $mail->addReplyTo($_POST['txtEmail']);
            $mail->addAddress($this->view->phpMailer['emailSiteAdmin'], $_POST['txtName']. "-" . $_POST['txtPhone']);
        
            $mail->isHTML(true);
            $mail->Subject = "Mensagem enviada por ". $_POST['txtName']. " - Data de envio: ". date('d/m/y H:i');
            $mail->Body    = "Mensagem enviada por ". $_POST['txtName']. "<br><br><br><hr>". $_POST['txtMsg']."<br><br><br> Número de contato: ". $_POST['txtPhone']. "<br><br><br><hr>". "Protocolo da mensagem: ". $protocolo. "<br><br><br><hr>";
        
            $mail->send();
            $msg = Container::getModel('message');
            $msg->setMessage('Mensagem enviada com sucesso', 'success','/');

            
        } catch (Exception $e) {
            $msg = Container::getModel('message');
            $msg->setMessage('Não foi possível enviar a mensagem por e-mail, mas ela foi salva no nosso sistema, e logo será enviada', 'success','/');
        }
        
    }
    
    public function adminConfig(){
        $msg = Container::getModel('message');
        if(!$this->autentication()){
            $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            exit;
        }
        if($_SESSION['perm'] < 3){
            $msg->setMessage('Você precisa ter nivel de acesso 3 ou superior', 'error','/');
            exit;

        }

        $this->render('admin', 'admin');
    }

    public function messages(){
        $msg = Container::getModel('message');
        if(!$this->autentication()){
            $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            exit;
        }
        if($_SESSION['perm'] < 3){
            $msg->setMessage('Você precisa ter nivel de acesso 3 ou superior', 'error','/');
            exit;

        }

        $this->render('messages', 'admin');
    }

    public function message(){
        $msg = Container::getModel('message');
        if(!$this->autentication()){
            $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            exit;
        }
        if($_SESSION['perm'] < 3){
            $msg->setMessage('Você precisa ter nivel de acesso 3 ou superior', 'error','/');
            exit;

        }
        if(!isset($_GET['id']) || empty($_GET['id'])){
            $msg->setMessage('Você precisa informar a mensagem', 'error','/');
            exit;

        }
        $this->render('message', 'admin');

    }

    public function answerMessage(){
        $msg = Container::getModel('message');
        if(!$this->autentication()){
            $msg->setMessage('Você precisa estar logado para acessar essa página', 'error','/');
            exit;
        }
        if($_SESSION['perm'] < 3){
            $msg->setMessage('Você precisa ter nivel de acesso 3 ou superior', 'error','/');
            exit;

        }
        if(!isset($_POST['msg']) || empty($_POST['msg'])){
            $msg->setMessage('Você precisa informar a mensagem', 'error','/');
            exit;

        }

        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';

        $message = Container::getModel('contactUs');
        $message->__set('answer',$_POST['msg']);
        $message->__set('protocol',$_POST['protocol']);
        $message->__set('id',$_POST['id']);
        $message->__set('emailResponse',$_SESSION['email']);
        $message->__set('responseDate', date('y/m/d H:i:s'));

        $message->answerMessage();

        echo '<pre>';
        var_dump($message);
        echo '</pre>';


        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->view->phpMailer['emailHost'];//Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->view->phpMailer['emailSiteAdmin'];                     //SMTP username
            $mail->Password   = $this->view->phpMailer['password'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    
        
            //Recipients
            $mail->setFrom($_POST['email'], 'Resposta da mensagem do protocolo : '. $message->__get('protocol'));
            // $mail->addReplyTo($_POST['txtEmail']);
            $mail->addAddress($this->view->phpMailer['emailSiteAdmin'],"Resposta: ");
        
            $mail->isHTML(true);
            $mail->Subject = "Resposta enviada por ". $_SESSION['username']. " - ".$_SESSION['email'].  " - Data de resposta: ". $message->__get('responseDate');
            $mail->Body    = $message->__get('answer');
        
            $mail->send();

            $msg = Container::getModel('message');
            $msg->setMessage('Resposta enviada com sucesso', 'success','/adminConfig/messages');

            
        } catch (Exception $e) {
            $msg = Container::getModel('message');
            $msg->setMessage('Não foi possível enviar a mensagem por e-mail, mas ela foi salva no nosso sistema, e logo será enviada', 'success','/');
        }

    }

    

    
    
}
