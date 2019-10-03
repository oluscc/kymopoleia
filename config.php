<?php
    session_start();
    require_once "GoogleAPI/vendor/autoload.php";
    $gClient = new Google_Client();
    $gClient->setClientId("601415963031-vuf44hg09st7g5dgtfpa92ilh3v4lfo7.apps.googleusercontent.com");
    $gClient->setClientSecret("ME_EnW0JaWiDG15Tud8_6g4v");
    $gClient->setApplicationName("KYmobudget");
    $gClient->setRedirectUri("http://localhost/kymopoleia/g-callback.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>