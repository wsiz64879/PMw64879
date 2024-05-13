<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "w64879_projekt"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if(mysqli_connect_errno()){
	echo "Połączenie nie zostało nawiązane!";
	exit();
}
echo "Połączenie zostało nawiązane!";

?>