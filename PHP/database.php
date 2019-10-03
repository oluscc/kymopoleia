<?php
$servername = "remotemysql.com";
$username = "1psWQYLHzD";
$serverPassword = "84gI6EpsxV";
$dbName = "1psWQYLHzD";
try{
    
    $conn = new PDO("mysql:host=$servername; dbname=$dbName", $username, $serverPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e){
    echo $e->getMessage();
}
?>