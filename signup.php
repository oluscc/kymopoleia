<?php
session_start();
require_once('./PHP/database.php');
// require "database.php";
$firstname = $username=$lastname = $email =  "";
$errors = $firstError = $nameError = $lastError =$emailError =$passError ="";
unset($_SESSION['success']);
if($_SERVER["REQUEST_METHOD"] == "POST"){
//user clicked submit button, implement logic
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['emailAddress'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
if(empty($firstname) && empty($lastname) && empty($email) && empty($username) && empty($password) && empty($confirmPassword)){
    $errors  = "Fill in all fields". "</br>";
}else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
	$nameError = "Username should contain only alphanumeric characters". "</br>";
}
else if(empty($lastname)){
	$lastError = "Please Enter your last name". "</br>";
}
else if(empty($firstname)){
	$firstError = "Please Enter your first name". "</br>";
}
else if(empty($username)){
	$nameError = "Username is a required field". "</br>";
}
else if(empty($password)){
    $passError = "Password is a required field". "</br>";
}
else if(empty($confirmPassword)){
    $passError = "Password is a required field". "</br>";
}
elseif (strlen($_POST['password']) < 8 ) {
    $passError = "Password should be minimum of eight (8) characters";     
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $emailError = "Email is not in a valid format". "<br>";
}
else if ($password !== $confirmPassword){
    $passError = "Passwords do not match". "<br>";
}
else{
    
    $checkUser = "SELECT * FROM users WHERE usernames = '$username'";
    $result = $conn->query($checkUser);
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if($user){
        $nameError = "Username already exists. Please choose a different username";
    }
    else{
        $checkUser2 = "SELECT * FROM users WHERE  email='$email'";
        $result2 = $conn->query($checkUser2);
        $emailChecker = $result2->fetch(PDO::FETCH_ASSOC);
        if($emailChecker){
            $emailError = "Email already exists. Please choose a different Email";
        }
        else{
            $token = md5(rand(0,1000) );
            $status = 0;
            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`firstname`, `lastname`, `usernames`, `email`, `password`, `token`, `status`, `user_id`) VALUES ('$firstname', '$lastname', '$username', '$email', '$passHash', '$token', '$status', NULL)";
            $done = $conn->query($sql);
            
            $_SESSION['success'] = "Sign up was successful. Please kindly verify your account using link sent to your email account registered.";
            require_once'account-verification-mail.php';
            header("location: login.php");
        } 
    }

    
    
}
}

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/account.css">
        <script src="https://kit.fontawesome.com/833e0cadb7.js" crossorigin="anonymous"></script>
         <link rel="manifest" href="manifest.json">
        <title>KymoBudget | Register</title>
    </head>



    <body class="">

        <!-- Just an image -->
        <a href="index.php"><img src="images/kymo.png" class="img-fluid" alt="logo"></a>
        <img src="images/Ellipse.png" class="img-fluid top-ellipse" alt="">

        <section class="container login-section ">
            <!-- <div class="spacing">
                <a href="index.php"><img src="images/kymo.png" class="img-fluid" alt=""></a> -->
            <!-- </div> --> 
            <h3 class="text-center signUP">Signup</h3>
            <form class="form-align" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
                <div class="form-group col-md-4 ">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" pattern="[a-zA-Z]{1,}" data-toggle="tooltip" data-placement="bottom" title="Enter Your First name" 
                    value="<?php echo $firstname; ?>" required><span class="error"><?php echo $firstError; ?></span>
                </div>
                <div class="form-group col-md-4 ">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname"  data-toggle="tooltip" data-placement="bottom" title="Enter Your Last name"
                     value="<?php echo $lastname; ?>" required><span class="error"><?php echo $lastError; ?></span>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" aria-describedby="usernameHelp" placeholder="Your username" id="username" name="username" pattern="[0-9a-zA-Z]{3,}" data-toggle="tooltip" data-placement="bottom" 
                    title="Enter username (must be more than 3 character)" value="<?php echo $username; ?>" required><span class="error">
                        <?php echo $nameError; ?></span>
                </div>
                <div class="form-group col-md-4 ">
                    <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Your email address" id="emailAddress" name="emailAddress"  data-toggle="tooltip" data-placement="bottom" title="Please enter a valid Email Address" value="<?php echo $email; ?>" 
                    required><span class="error"><?php echo $emailError; ?></span>
                </div>

                <div class="form-group col-md-4">
                    <input class="form-control" type="password" name="password" id="password" class="form-control" placeholder="Your password" data-toggle="tooltip" data-placement="bottom"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                     title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>     
                     <small id="passwordHelpBlock" class="form-text text-muted">
                     Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters
                    </small>  <span class=""><?php echo $passError; ?></span>
                </div>
                <div class="form-group col-md-4">
                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm password" data-toggle="tooltip" data-placement="bottom" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><span class="error"><?php echo $passError; ?></span>
                </div>
                <button id="submitData" type="submit" class="btn btn-primary login-btn">Create Account</button>

               

                <p class="Already-acc">Already have an account?&nbsp;&nbsp; <a href="login.php"><span>Sign in</span></a></p>
            </form>
            <span class="error"><?php echo $errors; ?></span>
        </section>


        <img src="images/Ellipse.png" class="img-fluid bottom-ellipse " alt="">


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="./js/account.js" ></script>
         <script src="js/app.js"></script>
    </body>

    </html>