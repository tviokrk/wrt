<!DOCTYPE html>
<form method="post" action="email.php">
  Email: <input name="email" id="email" type="text" /><br />

  Message:<br />
  <textarea name="message" id="message" rows="15" cols="40"></textarea><br />

  <input type="submit" value="Submit" />
</form>

<?php

  $email = $_REQUEST['email'] ;
  $message = $_REQUEST['message'] ;

  // here we use the php mail function
  // to send an email to:
  // you@example.com
  require_once('class.phpmailer.php');    //dodanie klasy phpmailer
    require_once('class.smtp.php');    //dodanie klasy smtp
    $mail = new PHPMailer();    //utworzenie nowej klasy phpmailer
    $mail->From = "j.nowak@webio.pl";    //adres e-mail użyty do wysyłania wiadomości
    $mail->FromName = "Jan Nowak";    //imię i nazwisko lub nazwa użyta do wysyłania wiadomości
    $mail->AddReplyTo('nadawca@domena.pl', 'mailing'); //adres e-mail nadawcy oraz jego nazwa
                                                 //w polu "Odpowiedz do"  
    $mail->Host = "smtp.webio.pl";    //adres serwera SMTP wysyłającego e-mail
    $mail->Mailer = "smtp";    //do wysłania zostanie użyty serwer SMTP
    $mail->SMTPAuth = true;    //włączenie autoryzacji do serwera SMTP
    $mail->Username = "j.nowak@webio.pl";    //nazwa użytkownika do skrzynki e-mail
    $mail->Password = "hasło";    //hasło użytkownika do skrzynki e-mail
    $mail->Port = 587; //port serwera SMTP zależny od konfiguracji dostawcy usługi poczty
    $mail->Subject = "temat";    //Temat wiadomości, można stosować zmienne i znaczniki HTML
    $mail->Body = 'treść';    //Treść wiadomości, można stosować zmienne i znaczniki HTML     
    $mail->AddAddress ("biuro@webio.pl","Biuro Webio");    //adres skrzynki e-mail oraz nazwa
                                                    //adresata, do którego trafi wiadomość
     if($mail->Send())    //sprawdzenie wysłania, jeśli wiadomość została pomyślnie wysłana
        {                      
        echo 'E-mail został wysłany'; //wyświetl ten komunikat
        }            
    else    //w przeciwnym wypadku
        {           
        echo 'E-mail nie mógł zostać wysłany';    //wyświetl następujący
        }
 // mail( "bradm@inmotiontesting.com", "Feedback Form Results",$message, "From: $email" );
?>
