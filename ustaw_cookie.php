<?php
// Ustawiam cookie żeby pliki były dla każdej osoby osobne
$id_value=hash('ripemd160', $_POST['email']);   //hash ip usera
setcookie('cookie_id', $id_value, time() + (86400 * 1));   //cookie na 1 dzień    //cookie jako nazwa dla plików tzw. PREFIX
setcookie('email', $_POST['email'], time() + (86400 * 1));   //cookie na 1 dzień   //cookie ustawiane na podstawie formularza logowania
setcookie('imie', $_POST['imie'], time() + (86400 * 1));   //cookie na 1 dzień   //cookie ustawiane na podstawie formularza logowania, imie do tresci maila 4Fun
header("Location: aplikacja.php");
?>
