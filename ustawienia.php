<!DOCTYPE html>
<html>
    <head>
        <title>Upload plików w PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
    	<form action="create_pdf.php" method="post">
    	<input type="submit" name="submit" value="Rozpocnznij proces generowania PDF" />
	</form>
		<center><br><h5>Wprowadź nazwę albumu, który chcesz usunąć</h5>
        <form action="usun_plik.php" method="post">
    		Nazwa albumu:<input type="text" name="plik_z_albumem" /><br />
    	<input type="submit" name="submit" value="Usuń!" />
	</form>

	
<br>
</center>
    </body>
</html>
