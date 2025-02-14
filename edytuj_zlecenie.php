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
    $id = $_POST["id"];
    $nazwa = $_POST["nazwa"];
    $ilosc = $_POST["ilosc"];
    $zleceniodawca = $_POST["zleceniodawca"];
    $data = $_POST["date"];

    $stmt = $db->prepare("UPDATE zlecenia SET nazwa_zlecenia = :nazwa, ilosc = :ilosc, zleceniodawca = :zleceniodawca, data_zrealizowania_zlecenia = :data WHERE Id_zlecenia = :id");
    $stmt->execute(array(':nazwa' => $nazwa, ':ilosc' => $ilosc, ':zleceniodawca' => $zleceniodawca, ':data' => $data, ':id' => $id));

    header("Location: zarzadzaj-zleceniami.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare("SELECT * FROM zlecenia WHERE Id_zlecenia = :id");
    $stmt->execute(array(':id' => $id));
    $zlecenie = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: zarzadzanie_zleceniami.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css\zarzadzaj-zleceniami.css">
 
    <title>Edytuj zlecenie</title>
		    <?php include 'header.php'; ?>
</head>
<body><div id="cont"><center>
		    
	
    <table style="width: 400px;">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="date" value="<?php echo $zlecenie['data_zrealizowania_zlecenia']; ?>">
      
        <tr>
            <th>Edytuj zlecenie</th>
            <th></th>
        </tr>
        <tr>
            <td><label for="nazwa">Nazwa zlecenia:</label></td>
            <td><input type="text" name="nazwa" value="<?php echo $zlecenie['nazwa_zlecenia']; ?>" required><br>
        </td>
        </tr>
        <tr>
            <td><label for="ilosc">Ilość:</label></td>
            <td><input type="text" name="ilosc" value="<?php echo $zlecenie['ilosc']; ?>" required><br></td>
        </tr>
        <tr>
            <td> <label for="zleceniodawca">Zleceniodawca:</label></td>
            <td> <input type="text" name="zleceniodawca" value="<?php echo $zlecenie['zleceniodawca']; ?>" required><br></td>
        </tr>
    </table><br>
			<input type="submit" value="Zapisz zmiany" class="bzaloguj">
		</form></div>
	 <?php include 'footer.html'; ?>
</body></center>
</html>

