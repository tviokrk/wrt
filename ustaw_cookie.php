<?php
// On the page that sets it...
$id_value=hash('ripemd160', $email);   //hash ip usera
setcookie('cookie_id', $id_value, time() + (86400 * 1));   //cookie na 1 dzień
setcookie('email', $email, time() + (86400 * 1));   //cookie na 1 dzień
header("Location: aplikacja.php");
?>
