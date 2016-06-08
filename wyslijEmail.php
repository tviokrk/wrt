<!DOCTYPE html>
<form method="post" action="wyslijEmail.php">
  Email na który mam wysłać link do albumu: <input name="email" id="email" type="text" /><br />

  <input type="submit" value="Submit" />
</form>

<?php

  $email = $_REQUEST['email'] ;

  $publicip =exec('curl ip.appspot.com');
  
  $message = "Link do albumu: ".$publicip."/upload/test.pdf";
  
  require_once('phpmailer/class.phpmailer.php');    //dodanie klasy phpmailer
    require_once('phpmailer/class.smtp.php');    //dodanie klasy smtp
    
    
    $mail = new PHPMailer();    //utworzenie nowej klasy phpmailer
    $mail->isSMTP(); 
    $mail->From = "tviokrk@wp.pl";    //adres e-mail użyty do wysyłania wiadomości
    $mail->FromName = "Jan Nowak";    //imię i nazwisko lub nazwa użyta do wysyłania wiadomości
    //$mail->AddReplyTo('nadawca@domena.pl', 'mailing'); //adres e-mail nadawcy oraz jego nazwa
                                                 //w polu "Odpowiedz do"  
    $mail->Host = "smtp.wp.pl";    //adres serwera SMTP wysyłającego e-mail
    $mail->Mailer = "smtp";    //do wysłania zostanie użyty serwer SMTP
    $mail->SMTPAuth = true;    //włączenie autoryzacji do serwera SMTP
    $mail->Username = "tviokrk@wp.pl";    //nazwa użytkownika do skrzynki e-mail
    $mail->Password = "zaq!@wsx";    //hasło użytkownika do skrzynki e-mail
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465; //port serwera SMTP zależny od konfiguracji dostawcy usługi poczty
    $mail->Subject = "temat";    //Temat wiadomości, można stosować zmienne i znaczniki HTML
    $mail->Body = $message;    //Treść wiadomości, można stosować zmienne i znaczniki HTML     
    $mail->AddAddress ( $email);    //adres skrzynki e-mail oraz nazwa
                                                    //adresata, do którego trafi wiadomość
    //$mail->addAttachment('./upload/test.pdf');
    //mail( "bradm@inmotiontesting.com", "Feedback Form Results",$message, "From: $email" );
    if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
  
?>
