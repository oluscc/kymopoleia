<?php

// Start session
if(!session_id()){
    session_start();
}

// Include Github client library 
require_once 'Github_OAuth_Client.php';


/*
 * Configuration and setup GitHub API
 */
$clientID         = '3eea348eaa04542c858c';
$clientSecret     = '5eb5f61235d2fff824a37b8140afc720236366fd';
$redirectURL     = 'https://kymobudget.herokuapp.com/gitlogin.php';

$gitClient = new Github_OAuth_Client(array(
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectURL,
));


// Try to get the access token
if(isset($_SESSION['access_token'])){
    $accessToken = $_SESSION['access_token'];
}

/*$config = array(
    'client_id' => '9f4b39eaad1c6ce235dc',
    'client_secret' => '31e43e912cddcaf214a2861741ff7452231e29c2',
    'redirect_url' => 'http://localhost:8080/kymopoleia/gitlogin.php', 
    'app_name' => 'Kymo budget App'
    ); */
    ?>