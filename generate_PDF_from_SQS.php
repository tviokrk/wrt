<?php
date_default_timezone_set('Europe/Warsaw');   //ustawiam czas wymagany przez S3
require 'phpmailer/PHPMailerAutoload.php';  
require 'vendor/autoload.php'; 
require ("fpdf/fpdf.php");      

use Aws\S3\S3Client;    //AmazonSDK pobrane przy pomocy projekt.yml
use Aws\S3\Exception\S3Exception;   
use Aws\Sqs\SqsClient;      

$url = 'https://sqs.eu-central-1.amazonaws.com/881078108084/michalo-album';  //adres www do bucketu
$client = SqsClient::factory(array(     // Instantiate an Amazon SQS client
    'version' => 'latest',
    'region'  => 'eu-central-1'
));
//////////////////////////////Odbieranie adresów email z kolejki SQS////////////////////////
while(true) {
    $res = $client->receiveMessage(array(
        'QueueUrl'          => $url,
        'WaitTimeSeconds'   => 1
    ));
        if ($res->getPath('Messages')) {
            foreach ($res->getPath('Messages') as $msg) {  //dla każdego obebranego adresu email z kolejki...
                $bucket = '160689-michalo';
                $s3 = new S3Client([   // Instantiate an Amazon S3 client.
                     'version' => 'latest',
                     'region'  => 'us-west-2'
            ]);

            $pdf = new FPDF(); // nowy obiekt FPDF
            $pdf->SetFont('Helvetica','',12);   //ustawienie czcionki w PDFie (obowiązkowe)

            try {
                $objects = $s3->getIterator('ListObjects', array(       // Listowanie wszystkich obiektów (plików) w buckecie z prefixem hash-user IP
                    'Bucket' => $bucket,
                    'Prefix' => hash('ripemd160', $msg['Body'])  
                ));
            
                foreach ($objects as $object) {    //dla każdego obiektu stwórz:
                    $pdf->AddPage();                //nowa, biała strona
                    $pdf->Cell(1,1,$object['Key']);     //string w postaci nazwy pliku  hash-userIP_hashMD5.rozszerzenie
                    $pdf->Image('https://s3-us-west-2.amazonaws.com/160689-michalo/'.$object['Key'],30,20,160,110);   //dodanie zdjęcia z bucketa i resize do 160x120
                }
            
            } catch (S3Exception $e) {
                echo $e->getMessage() . "\n";
            }

unlink('/var/www/html/upload/album.pdf');  //kasownaie pliku z albumem
$filename="/var/www/html/upload/album.pdf";   //definicja nazwy pliku wyjściowego

$pdf->Output($filename,'F');   //tworzę PDF z obrazów z objects


    //////////////////WYSYŁAM EMAIL/////////////////
    //$publicip =exec('curl -s icanhazip.com');   //pobranie publicznego IP instancji
    $message = "Dziękujemy za skorzystanie z aplikacji! Album znajduje się w załączniku";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;    //Whether to use SMTP authentication
    $mail->Username = "michal.wrt123@gmail.com";   //Username to use for SMTP authentication - use full email address for gmail
    $mail->Password = "michal1234567";  //Password to use for SMTP authentication
    $mail->setFrom('michal.wrt123@gmail.com', 'Amazon Gallery');  //Set who the message is to be sent from
    $mail->addAddress($msg['Body'], 'Odbiorca');  //wysyłamy album na adres z kolejki
    $mail->Subject = 'Album Amazon S3';  //Set the subject line
    $mail->Body = $message;  
    $mail->addAttachment('upload/album.pdf');  //Attach an image file
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Wiadomość wysłana!";
    }
    ////////////////SKONCZYŁEM WYSYŁKĘ///////////////

////////////////////////////////////////////////
           

            $res = $client->deleteMessage(array(
                'QueueUrl'      => $url,
                'ReceiptHandle' => $msg['ReceiptHandle']
                
            ));
        }
        
    }
    
}
/////////////////////////////////

?>
