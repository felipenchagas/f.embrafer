<?php
 
// Inclui o arquivo class.phpmailer.php localizado na pasta class
require_once("novo/class.phpmailer.php");
 
// Inicia a classe PHPMailer
$mail = new PHPMailer(true);
 
// Define os dados do servidor e tipo de conex�o
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem ser� SMTP
 

 
try {
	
	
     $mail->Host = 'mail.embrafer.com'; // Endere�o do servidor SMTP (Autentica��o, utilize o host smtp.seudom�nio.com.br)
     $mail->SMTPAuth   = true;  // Usar autentica��o SMTP (obrigat�rio para smtp.seudom�nio.com.br)
     $mail->Port       = 587; //  Usar 587 porta SMTP
     $mail->Username = 'contato@embrafer.com'; // Usu�rio do servidor SMTP (endere�o de email)
     $mail->Password = 'eneastroca8081!'; // Senha do servidor SMTP (senha do email usado)

     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom('contato@embrafer.com', 'Site'); //Seu e-mail
     $mail->AddReplyTo('contato@embrafer.com', 'Nome'); //Seu e-mail
	
     $mail->Subject = 'CONTATO - SITE - EMBRAFER';//Assunto do e-mail
	 
	 
	 $nomeremetente = $_POST['nomeremetente'];
	 $emailremetente = $_POST['emailremetente'];
	 $ddd = $_POST['ddd'];
   $telefone = $_POST['telefone'];
	 $assunto = $_POST['assunto'];
   $mensagem = $_POST['mensagem'];
   
   
    
	
     //Define os destinat�rio(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress('contato@embrafer.com', 'Embrafer');
 
     //Campos abaixo s�o opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // C�pia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
 
 
     //Define o corpo do email
	
     $mail->MsgHTML("Mensagem do Cliente: <br /><br />
	 $nomeremetente <br /><br />
	 $emailremetente <br /><br />
      $ddd $telefone <br /><br />
	  $assunto <br /><br />
	 $mensagem "); 

	 
	 
	 	
	 
	 
 
     ////Caso queira colocar o conteudo de um arquivo utilize o m�todo abaixo ao inv�s da mensagem no corpo do e-mail.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
     $mail->Send();
     header("Location: sucesso.html");
 
    //caso apresente algum erro � apresentado abaixo com essa exce��o.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
?>