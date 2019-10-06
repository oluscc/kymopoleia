<?php
//Database Constants
const DB_SERVER = "localhost";
const DB_USER = "root";
const DB_NAME = "DBNAME";

$connection;

$dsn = "mysql:host=".DB_SERVER.";
dbname=".DB_NAME;
    try{
        $connection = new PDO($dsn,DB_USER,DB_PASS);
    }
    catch(Exception $e){
        die($e->getMessage());
    }

    $email = $_GET['email']??;
    $email = trim($email);

    if(!empty($email)){
        $sql = "INSERT INTO subscribers(email) VALUES(?)";
        $smt = $connection->prepare($sql);
        $smt->blindValue(1,$email);
        $smt->execute();
    }

    //Redirect the user to about.php
    header('Location: about.php');

    ?>