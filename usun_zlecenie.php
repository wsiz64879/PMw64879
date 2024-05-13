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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare("DELETE FROM zlecenia WHERE Id_zlecenia = :id");
    $stmt->execute(array(':id' => $id));

    header("Location: zarzadzaj-zleceniami.php");
    exit();
} else {
    header("Location: zarzadzaj-zleceniami.php");
    exit();
}
?>
