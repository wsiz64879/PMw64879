<?php


if(isset($_POST['logout'])) {
    session_destroy();

    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="CSS\login_form.css">
    <style>
        /* Dodaj stylizację paska nawigacyjnego z poprzednich przykładów */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
			color: white !important;
        }

        header {
            background-color: #333;
            color: #fff !important;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
			height: 100px;
			margin-top: 0px;
        }

        #logo {
            font-size: 1.5em;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
        }

        nav {
            display: flex;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #fff;
        }

        #hamburger-btn {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        #hamburger-btn div {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
        }

        #user-info {
            margin-left: 50px;
			float:left;
        }

        @media screen and (max-width: 768px) {
            nav {
                display: none;
                flex-direction: column;
                text-align: center;
                background-color: #333;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
            }

            nav a {
                padding: 10px;
                margin: 0;
                display: block;
            }

            #hamburger-btn {
                display: flex;
            }
        }

.bwyloguj{
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);
	background-color:#f9f9f9;
	border-radius:6px;
	border:1px solid #dcdcdc;
	display:inline-block;
	cursor:pointer;
	color:#666666;
	font-family:Arial;
	font-size:12px;
	font-weight:bold;
	padding:6px 6px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffffff;
	float:right;
	width: 100px;
	margin-left: 45px;
}

.bwyloguj:hover{	background:linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%);
	background-color:#e9e9e9;}
.bwyloguj:active{	position:relative;
	top:1px;}
	nav a:hover{ color: lightgreen;}
    </style>
</head>
<body>
    <header>
        <a href="index.php" id="logo">Production Manager</a>

        <div id="hamburger-btn">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <nav>
            <a href="zarzadzaj-zleceniami.php">Zarządzaj zleceniami</a>
            <a href="zarzadzaj-stanem-magazynowym.php">Zarządzaj stanem magazynowym</a>
            <a href="zarzadzaj-pracownikami.php">Zarządzaj pracownikami</a>
            <a href="raporty.php">Rapoty</a>
        </nav>
	<div>
        <div id="user-info">
            <?php 
                if(isset($_SESSION['username'])) {
                    echo 'Witaj ' . $_SESSION['username'];
                } else {
                    echo ''; 
                }
            ?>

        </div>
		<div>
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<input class="bwyloguj" type="submit" name="logout" value="Wyloguj się">
					</form>
		</div>
	</div>
    </header>

</body>
</html>
