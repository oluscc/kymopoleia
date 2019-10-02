<?php
$servername = "localhost";
$username = "root";
$serverPassword = "root";
$dbName = "kymopoleia";
try{
    
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $serverPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e){
    echo $e->getMessage();
}
?>