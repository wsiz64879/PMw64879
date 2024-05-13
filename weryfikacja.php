<?php
session_start();

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    $host = "localhost";
    $dbname = "w64879_projekt";
    $db_username = "root";
    $db_password = "";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("SELECT Typ_uprawnienia FROM uprawnienia WHERE user_id = (SELECT user_id FROM users WHERE username = :username)");
        $stmt->execute(array(':username' => $username));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['Typ_uprawnienia'])) {
            $_SESSION["typ_uprawnienia"] = $user['Typ_uprawnienia'];
        } else {
            $_SESSION["typ_uprawnienia"] = "Brak uprawnień";
        }

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        die("Błąd połączenia z bazą danych: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit();
}
?>
