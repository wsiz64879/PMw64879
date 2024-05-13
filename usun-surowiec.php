<?php
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

if (isset($_POST['usun-potwierdz'])) {
    $id = $_POST['id'];

    $stmt = $db->prepare("DELETE FROM stan_magazynowy WHERE id_stanu = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: zarzadzaj-stanem-magazynowym.php");
    exit();
} elseif (isset($_POST['usun-anuluj'])) {
    header("Location: zarzadzaj-stanem-magazynowym.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare("SELECT * FROM stan_magazynowy WHERE id_stanu = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $surowiec = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($surowiec) {
		echo '<html><head><link rel="stylesheet" type="text/css" href="css\zarzadzaj-zleceniami.css"> <style>p{color:black;}</style><body><div id="cont"';
        echo '</head><center><h2>Potwierdzenie usunięcia surowca</h2>';
        echo '<p>Czy na pewno chcesz usunąć surowiec: ' . $surowiec['nazwa'] . '?</p>';
        echo '<form action="" method="POST">';
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<input type="submit" name="usun-potwierdz" value="Tak" class="bzaloguj">';
        echo '<input type="submit" name="usun-anuluj" value="Nie" class="bzaloguj">';
        echo '</form></body></div><center></html>';
    } else {
        echo 'Nie znaleziono surowca o podanym identyfikatorze.';
    }
} else {
    echo 'Nie podano identyfikatora surowca do usunięcia.';
}
?>
