<!DOCTYPE html>
<html>
    <head>
        <title>Upload plików w PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
		<center><br><h5>Plik o nazwie <u>"ceneo"</u> z rozszerzeniem .txt , każda linia powinna zawierać jeden kod towaru.<br>Kod towaru musi mieć min. 1 opinię !</h5>
        <form action="ustawienia.php" method="post">
    		Nazwa albumu:<input type="text" name="plik_z_albumem" /><br />
    	<input type="submit" name="submit" value="Usuń!" />
	</form>
<br>

<?php
$file = "./upload/.$_POST['plik_z_albumem'].txt"; 
unlink($file);

print("Plik usunięty !");
?>
</center>
    </body>
</html>
