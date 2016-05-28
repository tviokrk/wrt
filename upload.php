<?php
//include the S3 class              
if (!class_exists('S3'))require_once('S3.php');
 
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIXPGZAUCI7HCXYFA');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
 
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);
////////////////////////////////////////////
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo 'ERROR';
		echo '{"status":"error"}';
		exit;
	}

	if($s3->putObjectFile($_FILES['upl']['tmp_name'], "160689-michalo", $_FILES['upl']['name'], , S3::ACL_PUBLIC_READ)){
		echo 'SUKCES';
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;
