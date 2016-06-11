<!DOCTYPE html>
<html>
    <head>
        <title>Upload plików w PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
    	<form action="generate_PDF_from_SQS.php" method="post">
    	<input type="submit" name="submit" value="Rozpocznij proces generowania PDF" />
	</form>
		<center><br><h5>Wprowadź nazwę albumu, który chcesz usunąć<br><?php
echo " ".$_COOKIE['cookie_id'];
?></h5>
        <form action="usun_plik.php" method="post">
    		Nazwa albumu:<input type="text" name="plik_z_albumem" /><br />
    	<input type="submit" name="submit" value="Usuń!" />
	</form>

	
<br>
</center>
    </body>
</html>
