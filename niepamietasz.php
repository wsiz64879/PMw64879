
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="CSS\niepamietasz.css">
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
                    <div id="tresc">
						<p style="width: 300px; margin-left: 50px;">Jeśli zapomniałeś swojego hasła do panelu ProductionManager skontaktuj się z administratorem w celu ustawienia nowego hasła dostępu. <br><br> Kontakt:<br> Email: kontakt@productionmanager.pl <br> Telefon: 763 893 999 </p>
                    
					</div>
					<a style="margin-left: -80px;" href="login.php"><input type="submit" value="Wróć" class="bzaloguj"></a>

            </div>
        </center>
    </div>
</div>
	 <?php include 'footer.html'; ?>
</body>
</html>
