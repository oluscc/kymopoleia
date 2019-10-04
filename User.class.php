<?php
 
class User {
    
   
    private $servername = "remotemysql.com";
    private $username = "1psWQYLHzD";
    private $serverPassword = "84gI6EpsxV";
    private $dbName = "1psWQYLHzD";
    private $userTbl    = 'githubusers';
    
    function __construct(){
        try{
            if(!isset($this->db)){
            $conn = new PDO("mysql:host=$this->servername; dbname=$this->dbName", $this->username, $this->serverPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $conn;
            } 

        } 
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    function checkUser($userData = array()){
        if(!empty($userData)){
            // Check whether user data already exists in database
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);
            if($prevResult->rowCount() > 0){
                // Update user data if already exists
                $query = "UPDATE ".$this->userTbl." SET name = '".$userData['name']."', usernames = '".$userData['usernames']."', email = '".$userData['email']."', location = '".$userData['location']."', picture = '".$userData['picture']."', link = '".$userData['link']."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
            }else{
                // Insert user data
                $query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', name = '".$userData['name']."', usernames = '".$userData['usernames']."', email = '".$userData['email']."', location = '".$userData['location']."', picture = '".$userData['picture']."', link = '".$userData['link']."'";
                $insert = $this->db->query($query);
            }
            
            // Get the user data from the database
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch(PDO::FETCH_ASSOC);
        }
        
        // Return the user data
        return $userData;
    }
}