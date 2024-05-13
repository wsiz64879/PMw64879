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

    session_start();

   
    if (!isset($_SESSION['username'])) {
       
        header("Location: login.php");
        exit();
    }

     
    function getZlecenia($date)
    {
        global $db;
        $stmt = $db->prepare("SELECT zlecenia.*, stan_zlecenia.ilosc AS wykonane, stan_zlecenia.ostatnia_zmiana FROM zlecenia LEFT JOIN stan_zlecenia ON zlecenia.Id_zlecenia = stan_zlecenia.Id_zlecenia WHERE zlecenia.data_zrealizowania_zlecenia = :date");
        $stmt->execute(array(':date' => $date));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function formatDate($date)
    {
        return date("Y-m-d", strtotime($date));
    }

    if (isset($_GET['date'])) {
        $selectedDate = $_GET['date'];
    } else {
        $selectedDate = formatDate(date('Y-m-d')); 
    }

    $zlecenia = getZlecenia($selectedDate);
    ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css\zarzadzaj-zleceniami.css">
    <title>Zarządzanie zleceniami</title>
	    <?php include 'header.php'; ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .selected {
            background-color: #e6e6e6;
        }
		footer{
			margin-left: -345px;
		}
    </style>
</head>
<body>
    

    <div id="cont">
    
	
	
    <center><h1 style="margin-top: -20px;">Zarządzanie zleceniami</h1></center>
	
    <br>
   
	<div class="kalendarz"><center>
	<table>
		<tr>
			<td>
				<h3 id="spd">Zlecenia na <?php echo formatDate($selectedDate); ?>:</h3>
			</td>
			<td>
				<div class="fun1">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
						<input id="kal" type="date" name="date" value="<?php echo $selectedDate; ?>" required>
						<input id="wyb" type="submit" value="Wybierz" class="bzaloguj">
					</form>
				</div>
			</td>

		</tr>
	</table>
	</center>
</div>

<table id="zleccenia">
	<tr>
		<th>Id zlecenia</th>
		<th>Nazwa zlecenia</th>
		<th>Zleceniodawca</th>
		<th>Data dodania zlecenia</th>
		<th>Ilość</th>
		<th>Aktualnie wykonane</th>
		<th>Różnica</th>
		<th><img src="img/v.png" width="20" height="20"> / <img src="img/x.jpg" width="20" height="20"></th>
		<th>Ostatnio</th>
		<th>Akcje</th>
	</tr>
	<?php foreach ($zlecenia as $zlecenie) { ?>
		<tr>
			<td><?php echo $zlecenie['Id_zlecenia']; ?></td>
			<td><?php echo $zlecenie['nazwa_zlecenia']; ?></td>
			<td><?php echo $zlecenie['zleceniodawca']; ?></td>
			<td><?php echo $zlecenie['data_dodania_zlecenia']; ?></td>
			<td><?php echo $zlecenie['ilosc']; ?></td>
			<td><?php echo $zlecenie['wykonane'] ?? '0'; ?></td>
			<td><?php echo $zlecenie['wykonane'] - ($zlecenie['ilosc'] ?? 0); ?></td>
			<td><?php echo ($zlecenie['ilosc'] <= ($zlecenie['wykonane'] ?? 0)) ? '<img src="img/v.png" width="20" height="20">' : '<img src="img/x.jpg" width="20" height="20">'; ?></td>
			<td><?php echo $zlecenie['ostatnia_zmiana']; ?></td>
			<td>
				<a href="edytuj_zlecenie.php?id=<?php echo $zlecenie['Id_zlecenia']; ?>">Edytuj</a>
				<a href="usun_zlecenie.php?id=<?php echo $zlecenie['Id_zlecenia']; ?>">Usuń</a>
				<a href="stan_zlecenia.php?id=<?php echo $zlecenie['Id_zlecenia']; ?>">Sprawdź stan</a>
			</td>
			
		</tr>
	<?php } ?>
</table><br>
			<div id="navig">
			
				<div class="fun2">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
						<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($selectedDate . ' -1 day')); ?>">
						<input type="submit" value="Poprzedni dzień" class="bzaloguj">
					</form>
				</div>

				<div class="fun3">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
						<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($selectedDate . ' +1 day')); ?>">
						<input type="submit" value="Następny dzień" class="bzaloguj">
					</form>
			</div>
<br><br>

<center><br><br><br>
<div id="czyszczenie"></div>
<div id="dd">
	<table style="width: 390px;">
		<form action="dodaj_zlecenie.php" method="POST">
			<input type="hidden" name="date" value="<?php echo $selectedDate; ?>">

			<tr>
				<th>Dodaj nowe zlecenie</th>
				<th></th>
			</tr>
			<tr>
				<td> <label for="nazwa">Nazwa zlecenia:</label></td>
				<td><input type="text" name="nazwa" required></td>
			</tr>
			<tr>
				<td><label for="ilosc">Ilość:</label></td>
				<td><input type="text" name="ilosc" required></td>
			</tr>
			<tr>
				<td><label for="zleceniodawca">Zleceniodawca:</label></td>
				<td><input type="text" name="zleceniodawca" required></td>
			</tr>
	</table><br>
	<input type="submit" value="Dodaj zlecenie" class="bzaloguj"><br><br>

	</form>
		<a href="index.php"><input type="submit" value="Wróć" class="bzaloguj"></a>
</div>

	
</center>
<br><br>
</div>
 <?php include 'footer.html'; ?>
</body>
</html>