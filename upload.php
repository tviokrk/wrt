<?php
// On the page that sets it...
setcookie('cookie_id', gethostname(), time() + (86400 * 1));   //cookie na 1 dzień


// Require the Composer autoloader.
require 'vendor/autoload.php';

use Aws\S3\S3Client;

// Instantiate an Amazon S3 client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
$file = "./upload/".$_COOKIE['cookie_id'];
//unlink($file);
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif');
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo 'ERROR';
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], './upload/'.$_COOKIE['cookie_id'].$_FILES['upl']['name'])){
		echo 'SUKCES';
		echo '{"status":"success"}';
		
			try {
				   $result = $s3->putObject([
				        'Bucket' => '160689-michalo',
				        'Key'    => 'album_'.$_COOKIE['cookie_id'].$_FILES['upl']['name'],
				        'Body'   => fopen('./upload/'.$_COOKIE['cookie_id'].$_FILES['upl']['name'], 'r'),
				        'ACL'    => 'public-read',
				    ]);
				    $dane = $result['ObjectURL'];
				    
				// uchwyt pliku, otwarcie do dopisania na początku pliku
				
					$fp = fopen($file, "a"); 
					// blokada pliku do zapisu 
					flock($fp, 2); 
					// zapisanie danych do pliku 
					fwrite($fp, $dane."\r\n"); 
					// odblokowanie pliku 
					flock($fp, 3); 
					// zamknięcie pliku 
					fclose($fp); 
					} catch (Aws\Exception\S3Exception $e) {
					    echo "There was an error uploading the file.\n";
					}
		
		
		
		
		
		
		exit;
	}
}

echo '{"status":"error"}';
exit;
