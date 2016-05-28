<!DOCTYPE html>
<html>
    <head>
        <title>Upload plików w PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
		<center><br><h5>Załącz zdjęcia z rozszerzeniem .jpg</h5>

<form method="post" action="upload.php" enctype="multipart/form-data">
  <input name="filesToUpload[]" id="filesToUpload" type="file" multiple="" />
  <input type="submit" value="Send files" />
</form>
<br>
<?php
/* utworzenie zmiennych */
$folder_upload="/home/ec2-user/upload";
$plik_nazwa=$_FILES['plik']['name'];
$plik_lokalizacja=$_FILES['plik']['tmp_name']; //tymczasowa lokalizacja pliku
$plik_mime=$_FILES['plik']['type']; //typ MIME pliku wysłany przez przeglądarkę
$plik_rozmiar=$_FILES['plik']['size'];
$plik_blad=$_FILES['plik']['error']; //kod błędu
 
/* sprawdzenie, czy plik został wysłany */
if (!$plik_lokalizacja) {
    exit("<p>Nie wysłano żadnego pliku</p>");
}
 
/* sprawdzenie błędów */
switch ($plik_blad) {
    case UPLOAD_ERR_OK:
        break;
    case UPLOAD_ERR_NO_FILE:
        exit("Brak pliku.");
        break;
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        exit("Przekroczony maksymalny rozmiar pliku.");
        break;
    default:
        exit("Nieznany błąd.");
        break;
}
 
/* sprawdzenie rozszerzenia pliku - dzięki temu mamy pewność, że ktoś nie zapisze na serwerze pliku .php */
$dozwolone_rozszerzenia=array("png");

$plik_rozszerzenie=pathinfo(strtolower($plik_nazwa), PATHINFO_EXTENSION);
$plik_nazwa2=strtolower($plik_nazwa);
if (!in_array($plik_rozszerzenie, $dozwolone_rozszerzenia, true)) {
    exit("Niedozwolone rozszerzenie pliku.");
}

 
/* przeniesienie pliku z folderu tymczasowego do właściwej lokalizacji */
if (!move_uploaded_file($plik_lokalizacja, $folder_upload."/".$plik_nazwa)) {
    exit("Nie udało się przenieść pliku.");
}

 
/* nie było błędów */
print("\t<br><br>");

print("Dane zostały wysłane na serwer. Teraz skorzystaj z aplikacji ETL !");
?>
</center>
    </body>
</html>
