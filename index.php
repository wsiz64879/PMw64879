<?php
session_start();

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    header("Location: login.php");
    exit();
}

if (isset($_POST["logout"])) {

    unset($_SESSION["username"]);

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css\index.css">
    <title>Strona główna</title>
		    <?php include 'header.php'; ?>
</head>
<body>
<div id="tlo2">
	<div class="kontenery">
	<div class="kontener1">
	
	<h1> Witaj <?php echo $username; ?></h1>
	<h3>Wybierz jeden z poniższych przycisków w celu zarządzania produkcją w Twojej firmie </h3>
	<br><br>
	
  <div class="hip">
	<div class="b1">

   <a href="zarzadzaj-zleceniami.php" class="button"><p class="napis">Zarządzaj zleceniami</p></a>
   </div>
   <div class="b2">
   <a href="zarzadzaj-stanem-magazynowym.php" class="button"><p class="napis">Zarządzaj magazynem</p></a>
   </div>
   <div class="b3">
   <a href="zarzadzaj-pracownikami.php?session=<?php echo session_id(); ?>" class="button"><p class="napis">Zarządzaj pracownikami</p></a>
   </div>
   <div class="b4">
   <a href="raporty.php" class="button"><p class="napis">Generuj raporty</p></a>   
	</div>
	
	</div>  
	</div>
	</div>

</div>
	 <?php include 'footer.html'; ?>
</body>
</html>
