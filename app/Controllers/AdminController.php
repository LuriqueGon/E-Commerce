<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
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
            $msg->setMessage('Não foi possível enviar a mensagem'. $mail->ErrorInfo, 'success','/');
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
}
