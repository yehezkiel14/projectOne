<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "petfood";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$pdo = new PDO('mysql:host=localhost; dbname=petfood', 'root', '');
// if	(!$pdo) 
//     echo 'Connection	failed!';	
//     else	
//     echo  'Successfully	connected!';

?>
