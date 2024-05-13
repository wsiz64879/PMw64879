<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=login.php");
    echo "Brak uprawnień do wyświetlenia tej strony. Zostaniesz przekierowany na stronę logowania.";
    exit();
} else {
    header("refresh:5;url=index.php");
    echo "Brak uprawnień do wyświetlenia tej strony. Zostaniesz przekierowany na stronsę główną.";
    exit();
}
?>
