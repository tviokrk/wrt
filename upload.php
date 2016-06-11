<?php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use Aws\S3\S3Client;

// Instantiate an Amazon S3 client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
$file = "./upload/".$_COOKIE['cookie_id']; //utworzenie pliku o nazwie hash-usera, każdy ma swój album

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif');  //dozwolone rozszerzenia
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo 'ERROR';
		echo '{"status":"error"}';
		exit;
	}
        //przenoszenie pliku z mastera do bucketa
	if(move_uploaded_file($_FILES['upl']['tmp_name'], './upload/'.$_COOKIE['cookie_id'].'_'.$_FILES['upl']['name'])){
		echo 'SUKCES';
		echo '{"status":"success"}';
		
			try {  //tworzenie pliku w buckecie, o nazwie  hash ip-usera_hashMD5pliku.rozszerzenie
				   $result = $s3->putObject([
				        'Bucket' => '160689-michalo',
				        'Key'    => $_COOKIE['cookie_id'].'_'.hash('md5', $_FILES['upl']['name']).".".$extension,
				        'Body'   => fopen('./upload/'.$_COOKIE['cookie_id'].'_'.$_FILES['upl']['name'], 'r'),
				        'ACL'    => 'public-read',  //nadalnei uprawnień do czytania dla everyone
				    ]);
				    $dane = $result['ObjectURL'];  //zwrócenie linku i zapis go do pliku poniżej o nazwie hash-ip usera
				    
				
				
					$fp = fopen($file, "a"); // uchwyt pliku, otwarcie do dopisania na początku pliku
					flock($fp, 2); // blokada pliku do zapisu 
					fwrite($fp, $dane."\r\n");  // zapisanie danych do pliku 
					flock($fp, 3); // odblokowanie pliku 
					fclose($fp);  // zamknięcie pliku 
					} catch (Aws\Exception\S3Exception $e) {
					    echo "Pojawił się błąd w trakcie wysyłania pliku.\n";
					}
		exit;
	}
}

echo '{"status":"error"}';
exit;
