<?php
$file = './upload/'.$_POST['plik_z_albumem']; 
unlink($file);

print("Plik usunięty !");
?>
