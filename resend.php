<?php
session_start();
require_once "./PHP/database.php";
if (isset($_GET['id'])) {
	$user_id = $_GET['id'];
	$sql = "SELECT * FROM users WHERE user_id= $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if ($user) {
    	$firstname= $user['firstname'];
    	$token = $user['token'];
    	$email = $user['email'];
    	require_once'account-verification-mail.php';
    	$_SESSION['success'] = "Link has been sent to your mail.";
    	unset($_SESSION['loginError']);
            header("location: login.php");
        die;
    }
}

?>