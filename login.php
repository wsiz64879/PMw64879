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
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(array(':username' => $username));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['block_time'] > time()) {
        echo "Twoje konto jest zablokowane. Spróbuj ponownie po 15 minutach.";
    } else {
        $stmt = $db->prepare("SELECT * FROM users u LEFT JOIN uprawnienia p ON u.user_id = p.user_id WHERE u.username = :username AND u.password = :password");
        $stmt->execute(array(':username' => $username, ':password' => $password));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && ($user['Typ_uprawnienia'] == "Administrator" || $user['Typ_uprawnienia'] == "Pracownik")) {
            $_SESSION["username"] = $username;

            if (isset($_POST["remember"])) {
                setcookie("remember_username", $username, time() + (86400 * 30), "/");
                setcookie("remember_password", $password, time() + (86400 * 30), "/");
            } else {
                setcookie("remember_username", "", time() - 3600, "/");
                setcookie("remember_password", "", time() - 3600, "/");
            }

            header("Location: weryfikacja.php");
            exit();
        } else {

            if ($user && $user['block_time'] === null) {
                $blockTime = time() + (15 * 60); 

                $stmt = $db->prepare("UPDATE users SET block_time = :block_time WHERE username = :username");
                $stmt->execute(array(':block_time' => $blockTime, ':username' => $username));
            }

            echo "Nieprawidłowy login lub hasło lub brak uprawnień.";
        }
    }
} else {
    if (isset($_COOKIE["remember_username"]) && isset($_COOKIE["remember_password"])) {
        $username = $_COOKIE["remember_username"];
        $password = $_COOKIE["remember_password"];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="CSS\login_form.css">
    <title>Panel logowania</title>
		 <?php include 'header.php'; ?>
   
	<style>
	.bwyloguj{
		display: none;
	}
	nav{
		display: none;
	}
	</style>

</head>
<body>
<div id="tlo">
    <div id="tresc">
        <div id="logo">
            <img src="img/logo.png" width="20%">
			
			<h1 style="margin-top: -60px;">Production Manager</h1>
        </div>
        <center><br><br><br>
            <div id="Panel">
                <form action="login.php" method="POST">
                    <div id="tresc">
					<h2 style="margin-top: -20px;">Panel Logowania</h2>
                        <label class="left" for="username">Nazwa użytkownika:</label><br>
                        <input type="text" id="username" name="username" required value="<?php echo isset($username) ? $username : ''; ?>"><br><br>

                        <label class="left" for="password">Hasło:</label><br>
                        <input type="password" id="password" name="password" required value="<?php echo isset($password) ? $password : ''; ?>"><br><br>
                        <input type="checkbox" name="remember" <?php echo isset($username) ? 'checked' : ''; ?>> Zapamiętaj mnie
                        <input type="submit" value="Zaloguj się" class="bzaloguj"><br><br><br><br>


                        <a href="niepamietasz.php"> Nie pamiętasz hasła? </a>
                    </div>
                </form>
            </div>
        </center>
    </div>
</div>
	 <?php include 'footer.html'; ?>
</body>
</html>
