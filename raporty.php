<?php
session_start();



if (isset($_SESSION['username'])) {
    echo '';
}

?>

<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css\zarzadzaj-zleceniami.css">
 
    <title>Generowanie raportów</title>
		    <?php include 'header.php'; ?>
</head>
<body><div id="cont">

    <center><h1>Generowanie raportów</h1></center>

<center>
<form action="" method="POST">
    <label for="data_pocz">Data początkowa:</label>
    <input type="date" name="data_pocz" required><br>
    <label for="data_kon">Data końcowa:</label>
    <input type="date" name="data_kon" required><br>
    <input type="submit" name="generuj_raport" value="Generuj raport" class="bzaloguj">
</form>



<a href="index.php"><input type="submit" value="Wróć" class="bzaloguj"></a>

<?php
if (isset($_POST['generuj_raport'])) {
    $data_pocz = $_POST['data_pocz'];
    $data_kon = $_POST['data_kon'];

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

    $stmt = $db->prepare("SELECT nazwa_zlecenia, SUM(ilosc) AS suma_ilosci FROM zlecenia WHERE data_dodania_zlecenia >= :data_pocz AND data_dodania_zlecenia <= :data_kon GROUP BY nazwa_zlecenia");
    $stmt->bindParam(':data_pocz', $data_pocz);
    $stmt->bindParam(':data_kon', $data_kon);
    $stmt->execute();
    $sumy_zlecen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h3>Raport zlecenia:</h3>';
    echo '<table>';
    echo '<tr>';
    echo '<th>Nazwa zlecenia</th>';
    echo '<th>Suma ilości</th>';
    echo '</tr>';
    foreach ($sumy_zlecen as $sum_zlecenie) {
        echo '<tr>';
        echo '<td>' . $sum_zlecenie['nazwa_zlecenia'] . '</td>';
        echo '<td>' . $sum_zlecenie['suma_ilosci'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    $stmt = $db->prepare("SELECT * FROM zlecenia WHERE data_dodania_zlecenia >= :data_pocz AND data_dodania_zlecenia <= :data_kon");
    $stmt->bindParam(':data_pocz', $data_pocz);
    $stmt->bindParam(':data_kon', $data_kon);
    $stmt->execute();
    $zlecenia = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h3>Raport szczegółowy:</h3>';
    echo '<table>';
    echo '<tr>';
    echo '<th>Id zlecenia</th>';
    echo '<th>Nazwa zlecenia</th>';
    echo '<th>Ilość</th>';
    echo '<th>Zleceniodawca</th>';
    echo '<th>Data dodania</th>';
    echo '<th>Data zrealizowania</th>';
    echo '</tr>';
    foreach ($zlecenia as $zlecenie) {
        echo '<tr>';
        echo '<td>' . $zlecenie['Id_zlecenia'] . '</td>';
        echo '<td>' . $zlecenie['nazwa_zlecenia'] . '</td>';
        echo '<td>' . $zlecenie['ilosc'] . '</td>';
        echo '<td>' . $zlecenie['zleceniodawca'] . '</td>';
        echo '<td>' . $zlecenie['data_dodania_zlecenia'] . '</td>';
        echo '<td>' . $zlecenie['data_zrealizowania_zlecenia'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>

</body></div>
 <?php include 'footer.html'; ?></center>
</html>
