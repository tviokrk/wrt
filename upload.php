<?php

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');
echo "jest PHP";
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo 'ERROR';
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], './uploads'.$_FILES['upl']['name'])){
		echo 'SUKCES';
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;