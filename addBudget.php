<?php
    ob_start();
    session_start();
    if(!isset($_SESSION['email'])){
         header("Location: login.php");
    }
    
    
?>

<?php
require_once "./PHP/database.php";
// echo($_SESSION['usernames']);
function protect_value($value){
 $secured_value = trim(stripslashes(htmlentities($value)));     
 return $secured_value;     
}
$data = array();
$error = array();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //===CREATE BUDGET AND TOTAL AMOUNT
    $total_amount = protect_value($_POST['amount']);
    $budget_name = protect_value($_POST['budget_name']);
    $startTime = protect_value($_POST['startTime']);
    $endTime = protect_value($_POST['endTime']);
    if (empty($total_amount)) {
        $error['total_amount'] = "total_amount is required";
    }
    if (empty($budget_name)) {
        $error['budget_name'] = "Budget name is required";
    }
    if (!filter_var($_POST['amount'], FILTER_VALIDATE_INT)) {
        $error['total_amount'] = "Only in integers is accepted";
    }
    $sql = "SELECT * FROM budget WHERE Budget_id = '$budget_name' AND username = '{$_SESSION['usernames']}'";
        $result = $conn->query($sql);
    if ($result->fetch(PDO::FETCH_ASSOC)) {
            $error['budget_name'] = "Budget exists with this name";
    }
    if (empty($error)) {
        $insert = "INSERT INTO budget (id,Budget_id,Amount,startTime,endTime,username)
                    VALUES( null, '$budget_name',  '$total_amount','$startTime','$endTime','{$_SESSION['usernames']}')";
        $exe = $conn->exec($insert);
        $_SESSION['Budget_id'] = $budget_name;
        $_SESSION['Amount'] = $total_amount;
        $data['message'] = "Budget created.";
            
    }
    if ( !empty($error)) {
        $data['success'] = false;
        $data['errors']  = $error;
    } else {
        $data['success'] = true;
        
    }
    // return to ajax
    header("Location: addBudgetItems.php");
    echo json_encode($data);
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/addBudget.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <script src="https://kit.fontawesome.com/833e0cadb7.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.css" rel="stylesheet">


    <title>Kymo Budget | Add Budget </title>
</head>

<body class="">
    <header>

    <nav>
            <div class="brandname">
                <h2 class="header-brandname"><a href="..index.php"><img src="images/kymo.png" alt=""> </a></h2>
            </div>
            <p class="welcome_user">Hi, <span class="blueText"><?php echo $_SESSION['firstname']; echo "&nbsp;" ;echo $_SESSION['lastname']   ; ?></span></p>
            <img class='user-avatar' src="images/user.png" alt="">
            <div class="dropdown">
                    <div class="dropdown-toggler" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="./images/drop.png" alt="">
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="dashboard.php"><?php  echo($_SESSION['usernames']); ?></a>
						<a class="dropdown-item" href="change_password.php">Change Password</a>
                        <a class="dropdown-item" href="logout.php">Sign out</a>
                    </div>
                  </div>

        </nav>

    </header>

    <main>


    <?php include "./PHP/sidebar.php"; ?>

        <section class="add-budget">
        <div style="height: 100px"></div>
            <div class="container">
                <form class="add-budget-form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
                    <h2 class="bgBlue">Add Budget</h2>
                    <div class="form-row margin-height">
                        <div class="form-group col-md-6 mTop">
                            <input type="text" name="budget_name" id="budget_name" class="form-control" placeholder="Enter budget title">
                        </div>
                        <div class="form-group col-md-6 mTop">
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter amount">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="date"  id="startTime" name="startTime" class="form-control" placeholder="Enter start time(dd/m/yy)" value=<?php
                            $month = date('m');
                            $day = date('d');
                            $year = date('Y');
                            $today = $year . '-' . $month . '-' . $day; echo $today;?>>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="date" name="endTime" id="endTime" class="form-control" placeholder="Enter end time(dd/m/yy)">
                        </div>
                    </div>
                    <button type="submit" class="btn budget-save text-center bgBlue">Create</button>
                </form>
            </div>    
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="./js/dashboardNew.js"></script>
    <script src="./js/sidebar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/extensions/mobile/bootstrap-table-mobile.min.js">
    </script>

</body>

</html>