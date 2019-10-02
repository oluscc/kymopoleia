<?php
require_once "./PHP/database.php";
session_start();
$_SESS['loginError'] =$_SESS['emailError'] =$_SESS['passError'] = "";
$password = $username="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //user clicked submit button, implement logic
$username = $_POST['username'];
$password = $_POST['password'];
if(empty($password) && empty($username)){
    $_SESS['loginError'] = "Fill in all fields". "</br>";
   
}
// else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
// 	$_SESS['emailError'] = "Username should contain only alphanumeric characters". "</br>";
    
// }
else if(empty($username)){
	$_SESS['emailError'] = "Username is a required field". "</br>";
    
}
else if(empty($password)){
    $_SESS['passError'] = "Password is a required field". "</br>";
    
}
else{
        
    $sql = "SELECT * FROM users WHERE email='$username'";
    
    $result = $conn->query($sql);
    
    $user = $result->fetch(PDO::FETCH_ASSOC);
    $_SESSION = $user;
	if($username !== $user['email'] || !password_verify($password, $user['password'])){
        $_SESSION['loginError'] = "Invalid login credentials. Please crosscheck your login details or click on the Sign Up link to create an Account.";
		// echo($_SESSION['loginError']);
    }elseif($username === $user['email']||$username === $user['email'] && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $username;
        header("location: dashboard.php");
		exit;
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
    <title>KymoBudget | Login</title>
</head>

<body>

    <!-- Just an image -->


    <a href="index.php" id="top-logo"><img src="images/kymo.png" class="img-fluid" width="auto" height="30" alt="logo"></a>

    <img src="images/Ellipse.png" class="img-fluid top-ellipse" alt="">

    <section class="container login-section ">
        <div class="text-center spacing">

        </div>
        <h3 class=" welcome text-center spacing">Welcome Back!</h3>
        <form class="" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
            <div class="form-group col-md-4 ">
                <input type="email" name="username" id="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your email address" value="<?php echo $username; ?>" required><span class="error"><?php echo $_SESS['emailError']; ?></span>
            </div>

            <div class="form-group col-md-4">
                <input type="password" name="password" id="password" class="form-control" id="exampleInputPassword1" placeholder="Your password" required><span class="error"><?php echo $_SESS['passError']; ?></span>
            </div>

            <div class="forgot__pass__link">
                <a href="#">Forgot Password?</a>
                <?php echo $_SESS['loginError']; ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary login-btn">Login</button>

            <p class="Already-acc">New to Kymo Budget?&nbsp;&nbsp;<span><a href="signup.php"> Sign Up</span></a></p>

        </form>

    </section>


    <img src="images/Ellipse.png" class="img-fluid bottom-ellipse d-none d-md-none d-lg-block" alt="">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>