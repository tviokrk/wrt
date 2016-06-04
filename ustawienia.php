<!DOCTYPE html>
<html>
    <head>
        <title>Upload plików w PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
		<center><br><h5>Plik o nazwie <u>"ceneo"</u> z rozszerzeniem .txt , każda linia powinna zawierać jeden kod towaru.<br>Kod towaru musi mieć min. 1 opinię !</h5>
        <form enctype="multipart/form-data" action="ustawienia.php" method="post">
            <input type="file" name="plik">
            <input type="submit" value="Wyślij">
        </form>
<br>

<?php
/* utworzenie zmiennych */
$folder_upload="./pliki/tmp_2";
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
$dozwolone_rozszerzenia=array("txt");
$dozwolona_nazwa=array("ceneo.txt");

$plik_rozszerzenie=pathinfo(strtolower($plik_nazwa), PATHINFO_EXTENSION);
$plik_nazwa2=strtolower($plik_nazwa);
if (!in_array($plik_rozszerzenie, $dozwolone_rozszerzenia, true)) {
    exit("Niedozwolone rozszerzenie pliku.");
}

/* sprawdzenie nazwy pliku */
if (!in_array($plik_nazwa2, $dozwolona_nazwa, true)) {
    exit("Niedozwolona nazwa.");
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
