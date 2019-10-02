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
<?php
// Include GitHub API config file
require_once 'gitConfig.php';

// Include and initialize user class
require_once 'User.class.php';
$user = new User();

if(isset($accessToken)){
    // Get the user profile info from Github
    $gitUser = $gitClient->apiRequest($accessToken);
    
    if(!empty($gitUser)){
        // User profile data
        $gitUserData = array();
        $gitUserData['oauth_provider'] = 'github';
        $gitUserData['oauth_uid'] = !empty($gitUser->id)?$gitUser->id:'';
        $gitUserData['name'] = !empty($gitUser->name)?$gitUser->name:'';
        $gitUserData['username'] = !empty($gitUser->login)?$gitUser->login:'';
        $gitUserData['email'] = !empty($gitUser->email)?$gitUser->email:'';
        $gitUserData['location'] = !empty($gitUser->location)?$gitUser->location:'';
        $gitUserData['picture'] = !empty($gitUser->avatar_url)?$gitUser->avatar_url:'';
        $gitUserData['link'] = !empty($gitUser->html_url)?$gitUser->html_url:'';
        
        // Insert or update user data to the database
        $userData = $user->checkUser($gitUserData);
        
        // Put user data into the session
        $_SESSION['userData'] = $userData;
        
        // Render Github profile data
        $output  = '<h2>Github Profile Details</h2>';
        $output .= '<img src="'.$userData['picture'].'" />';
        $output .= '<p>ID: '.$userData['oauth_uid'].'</p>';
        $output .= '<p>Name: '.$userData['name'].'</p>';
        $output .= '<p>Login Username: '.$userData['username'].'</p>';
        $output .= '<p>Email: '.$userData['email'].'</p>';
        $output .= '<p>Location: '.$userData['location'].'</p>';
        $output .= '<p>Profile Link :  <a href="'.$userData['link'].'" target="_blank">Click to visit GitHub page</a></p>';
        $output .= '<p>Logout from <a href="logout.php">GitHub</a></p>'; 
        header('location: dashboard.php');
        exit;
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
        header("location: dashboard.php");
		exit;
    }
    
}elseif(isset($_GET['code'])){
    // Verify the state matches the stored state
    if(!$_GET['state'] || $_SESSION['state'] != $_GET['state']) {
        header("Location: ".$_SERVER['PHP_SELF']);
    }
    
    // Exchange the auth code for a token
    $accessToken = $gitClient->getAccessToken($_GET['state'], $_GET['code']);
  
    $_SESSION['access_token'] = $accessToken;
  
    header('Location: ./');
}else{
    // Generate a random hash and store in the session for security
    $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
    
    // Remove access token from the session
    unset($_SESSION['access_token']);
  
    // Get the URL to authorize
    $loginURL = $gitClient->getAuthorizeURL($_SESSION['state']);
    
    // Render Github login button
    //$loginbtn = '<a href="'.htmlspecialchars($loginURL).'"><img src="images/githubmark.png"></a>';
    $loginbtn = '<span><img src="images/githubmark.png"></span><a href="'.htmlspecialchars($loginURL).'">Login with Github</a>'
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

            <!---github login button-->
            <?php echo $loginbtn; ?>
            <p class="Already-acc">New to Kymo Budget?&nbsp;&nbsp;<span><a href="signup.php"> Sign Up</span></a></p>

        </form>

    </section>


    <img src="images/Ellipse.png" class="img-fluid bottom-ellipse d-none d-md-none d-lg-block" alt="">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>