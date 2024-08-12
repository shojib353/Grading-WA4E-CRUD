<?php
$servername = "localhost";
$username = "username";
$password = "password";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=misc", $username, $password);
}catch(Exception $e){
echo $e->getMessage();

}

?>