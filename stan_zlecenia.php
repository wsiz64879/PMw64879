<?php
session_start();

$host = "localhost";
$dbname = "w64879_projekt";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idZlecenia = $_POST["id_zlecenia"];
    $ilosc = $_POST["ilosc"];

    $stmtCheck = $db->prepare("SELECT * FROM stan_zlecenia WHERE Id_zlecenia = :idZlecenia");
    $stmtCheck->execute(array(':idZlecenia' => $idZlecenia));
    $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $stmtUpdate = $db->prepare("UPDATE stan_zlecenia SET ilosc = :ilosc, ostatnia_zmiana = :username WHERE Id_zlecenia = :idZlecenia");
        $stmtUpdate->execute(array(':ilosc' => $ilosc, ':idZlecenia' => $idZlecenia, ':username' => $_SESSION['username']));
    } else {
        $stmtInsert = $db->prepare("INSERT INTO stan_zlecenia (Id_zlecenia, ilosc, ostatnia_zmiana) VALUES (:idZlecenia, :ilosc, :username)");
        $stmtInsert->execute(array(':idZlecenia' => $idZlecenia, ':ilosc' => $ilosc, ':username' => $_SESSION['username']));
    }

    header("Location: stan_zlecenia.php");
    exit();
}

if (isset($_GET['id'])) {
    $idZlecenia = $_GET['id'];

    $stmtZlecenie = $db->prepare("SELECT * FROM zlecenia WHERE Id_zlecenia = :idZlecenia");
    $stmtZlecenie->execute(array(':idZlecenia' => $idZlecenia));
    $zlecenie = $stmtZlecenie->fetch(PDO::FETCH_ASSOC);

    $stmtStan = $db->prepare("SELECT * FROM stan_zlecenia WHERE Id_zlecenia = :idZlecenia");
    $stmtStan->execute(array(':idZlecenia' => $idZlecenia));
    $stan = $stmtStan->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: zarzadzaj-zleceniami.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css\zarzadzaj-zleceniami.css">
    <title>Stan zlecenia</title>
		    <?php include 'header.php'; ?>
			<style>
			p{
				color: black !important;
			}
			</style>
</head>
<body><div id="cont">
<center>
    <h2>Stan zlecenia</h2>
	<h3>Informacje o zleceniu:</h3>
<p>ID zlecenia: <?php echo $zlecenie['Id_zlecenia']; ?></p>
<p>Nazwa zlecenia: <?php echo $zlecenie['nazwa_zlecenia']; ?></p>
<p>Ilość: <?php echo $zlecenie['ilosc']; ?></p>
<p>Zleceniodawca: <?php echo $zlecenie['zleceniodawca']; ?></p>
<p>Data dodania zlecenia: <?php echo $zlecenie['data_dodania_zlecenia']; ?></p>
<p>Data zrealizowania zlecenia: <?php echo $zlecenie['data_zrealizowania_zlecenia']; ?></p>

<h3>Aktualny stan wykonania:</h3>
<?php if ($stan): ?>
    <p>Ilość wykonanych: <?php echo $stan['ilosc']; ?></p>
<?php else: ?>
    <p>Brak informacji o stanie wykonania.</p>
<?php endif; ?>

<h3>Edytuj stan wykonania:</h3>
<div id="zaap"> 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="hidden" name="id_zlecenia" value="<?php echo $idZlecenia; ?>">
   
	<label for="ilosc">Ilość wykonanych:</label>
    <input type="number" name="ilosc" min="0" value="<?php echo ($stan ? $stan['ilosc'] : ''); ?>">
    <input type="submit" value="Zapisz" class="bzaloguj">
</div>
</form>

<!-- Dodaj przycisk "Wydaj 100" -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <input type="hidden" name="id_zlecenia" value="<?php echo $idZlecenia; ?>">
    <input type="hidden" name="ilosc" value="<?php echo ($stan ? $stan['ilosc'] + 100 : 100); ?>"><br>
    <input type="submit" value="Wydaj 100" class="bzaloguj"><br>

</form>
<a href="zarzadzaj-zleceniami.php"><input type="submit" value="Wróć" class="bzaloguj"></a>
</center></div>
 <?php include 'footer.html'; ?>
</body>
</html>