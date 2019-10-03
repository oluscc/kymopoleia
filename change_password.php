<?php
    ob_start();
    session_start();
    require_once "./PHP/database.php";
    if(!isset($_SESSION['email'])){
         header("Location: login.php");
    }else{
        $sql = "SELECT * FROM budget WHERE username = '{$_SESSION['usernames']}' ";
        $result = $conn->query($sql);
        $Budgets= $result->fetch(PDO::FETCH_ASSOC);
        $percent = 0;
    }
$usernames=$_SESSION["usernames"];
$conn = mysqli_connect("remotemysql.com", "1psWQYLHzD", "84gI6EpsxV", "1psWQYLHzD") or die("Connection Error: " . mysqli_error($conn));

if (count($_POST) > 0) {
    $result = mysqli_query($conn, "SELECT *from users WHERE usernames='" . $_SESSION["usernames"] . "'");
    $row = mysqli_fetch_array($result);
	$currentPassword=$_POST["currentPassword"];
	//$CpassHash = password_hash($currentPassword, PASSWORD_DEFAULT);
	$CpassHash = password_verify($currentPassword,$row["password"]);
    if ($CpassHash) {
		$password=$_POST["newPassword"];
		$username=$_SESSION["usernames"];
		 $passHash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users set password='$passHash' WHERE usernames='$username'");
        $message = "Password Changed";
		header("Location: login.php");
    } else
        $message = "Current Password is not correct";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Rosarivo&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="./css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <script src="https://kit.fontawesome.com/833e0cadb7.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.css" rel="stylesheet">
    

    <title>Kymo Budget | Change Password </title>
</head>
<body class="">
    <header>

        <nav>
            <div class="brandname">
                <h2 class="header-brandname"><a href="..index.php"><img src="images/kymo.png" alt=""> </a></h2>
            </div>
            <p class="welcome_user">Hi, <span class="blueText"><?php echo $_SESSION['firstname']    ;  echo $_SESSION['lastname']   ; ?></span></p>
            <img class='user-avatar' src="images/user.png" alt="">
            <div class="dropdown">
                    <div class="dropdown-toggler" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="./images/drop.png" alt="">
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#"><?php  echo($_SESSION['usernames']); ?></a>
						<a class="dropdown-item" href="change_password.php">Change Password</a>
                        <a class="dropdown-item" href="logout.php">Sign out</a>
                    </div>
                  </div>

        </nav>

    </header>

    <main>

       

        <?php include "./PHP/sidebar.php"; ?>
       

		<section class="buget__dashboard">
            <div class="container">

                <div class="welcome__text">
                    <div class="budget__info">
                        <div>
                                <p>CHANGE PASSWORD </p>
                                <p id="total_amount_budgeted"></p>
    
                        </div>

                    </div>

<script>
function validatePassword() {
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.currentPassword;
newPassword = document.frmChange.newPassword;
confirmPassword = document.frmChange.confirmPassword;

if(!currentPassword.value) {
	currentPassword.focus();
	document.getElementById("currentPassword").innerHTML = "required";
	output = false;
}
else if(!newPassword.value) {
	newPassword.focus();
	document.getElementById("newPassword").innerHTML = "required";
	output = false;
}
else if(!confirmPassword.value) {
	confirmPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "required";
	output = false;
}
if(newPassword.value != confirmPassword.value) {
	newPassword.value="";
	confirmPassword.value="";
	newPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "Password/Confirm Password not match";
	output = false;
} 	
return output;
}
</script>
<style type="text/css">
body {
font-family:Arial;
}
input {
font-family:Arial;
font-size:14px;
}
label{
font-family:Arial;
font-size:14px;
color:black;
}
.tblSaveForm {
border-top:2px #999999 solid;
background-color: #f8f8f8;
}
.tableheader {
background-color: gray;
}
.btnSubmit {
background-color:blue;
padding:5px;
border-color:blue;
border-radius:4px;
color:white;
}
.message {
color: #FF0000;
text-align: center;
width: 100%;
}
.txtField {
padding: 5px;
border:blue 1px solid;
border-radius:4px;
}
.required {
color: #FF0000;
font-size:11px;
font-weight:italic;
padding-left:10px;
}
</style>
</head>
<body>
    <form name="frmChange" method="post" action=""
        onSubmit="return validatePassword()">
        <div style="width: 700px;">
            <div class="message"><?php if(isset($message)) { echo $message; } ?></div>
            <table border="0" cellpadding="10" cellspacing="0"
                width="700" align="center" class="tblSaveForm">
                <tr class="tableheader">
                    <td colspan="2"><center>Enter your Current Password and New Password</td>
                </tr>
                <tr>
                    <td width="30%"><label>Current Password</label></td>
                    <td width="70%"><input type="password"
                        name="currentPassword" class="txtField" /><span
                        id="currentPassword" class="required"></span></td>
                </tr>
                <tr>
                    <td><label>New Password</label></td>
                    <td><input type="password" name="newPassword"
                        class="txtField" /><span id="newPassword"
                        class="required"></span></td>
                </tr>
                <td><label>Confirm Password</label></td>
                <td><input type="password" name="confirmPassword"
                    class="txtField" /><span id="confirmPassword"
                    class="required"></span></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit"
                        value="Submit" class="btnSubmit"></td>
                </tr>
            </table>
        </div>
    </form>
</body>
</html>