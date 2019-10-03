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
    

    <title>Kymo Budget | Dashboard </title>
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
            <br> <?php include "message.php" ?> <br>
                <div class="welcome__text">
                    <div class="budget__info">
                        <div>
                                <p>Total funds budgeted</p>
                                <p id="total_amount_budgeted"></p>
    
                        </div>

                    </div>


                    <!-- This was the way i implemented on django (JUST A GUIDE!) -->
                    <!-- <table
                    id="table"
                    data-toggle="table"
                    data-height="600"
                    data-width="600"
                    data-pagination="true"
                    data-filter-control="true"
                    data-show-search-clear-button="true">
                <thead>
                  <tr>
                    <th data-field="id" data-sortable="true">Budgets</th>
                    <th data-field="hotel_name" data-sortable="true" data-filter-control="input">Date added</th>
                    <th data-field="state" data-sortable="true" data-filter-control="select">Time due</th>
                    <th data-field="state" data-sortable="true" data-filter-control="select">Number of items</th>
                  </tr>
                </thead>
                <tbody class="budgets">
                  {% for key in data %}
                  <tr class="single_budget" data-name="{{key.budget}}">
                      <td>{{data.index(key) + 1}}</td>
                      <td> {{ key.budgets }} </td>
                      <td> {{ key.date_added }} </td>
                      <td> {{ key.time_due }} </td>
                      <td> {{ key.number_of_items }} </td>
                  </tr>
                  {% endfor %}
              </tbody>
              </table> -->
              <a href="addBudget.php" type="button" class="btn btn-success" id="add-row"><i class="fa fa-plus"></i> Create Budget Item</a>
               
              <table
              id="table"
            data-toggle="table"
            data-search="true"
            data-show-columns="true"
            data-pagination="true"
            data-pagination-pre-text="Previous"
            data-pagination-next-text="Next"
            data-mobile-responsive="true"
            data-check-on-init="true"
            >
    
            <thead>
                <tr>
                <th>Budgets</th>
                <th>Date added</th>
                <th>Time due</th>
                <th>Number of items</th>
                <th>Amount Budgeted</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php do{?>
                <tr id="tr-id-1" onclick="return deleteRow('<?php echo($Budgets['Budget_id']); ?>')"class="tr-class-1" data-title="bootstrap table" data-object='{"key": "value"}'>
                <td>
                    <a onclick="return deleteRow('<?php echo($Budgets['Budget_id']); ?>')"><?php  echo($Budgets['Budget_id']);?></a>
                </td>
                <td data-value="526"><?php echo($Budgets['startTime']);?></td>
                <td data-value=""><?php echo($Budgets['endTime']);?></td>
                <td><?php   $sq = "SELECT * FROM BudgetDetails WHERE Budget_id = '{$Budgets['Budget_id']}' ";
                    $res = $conn->query($sq);
                    $Budg =   $res->rowCount();
                
                        echo($Budg);?></td>
                <td class="amount__budgeted" data-value="<?php echo($Budgets['Amount']);?>">₦<?php echo($Budgets['Amount']);?></td>
                <td><button type="button" onclick="return deleteRow('<?php echo($Budgets['Budget_id']); ?>')" class="btn btn-primary">View budget</button></td>
                </tr>
                <?php }while($Budgets =$result->fetch(PDO::FETCH_ASSOC))?>
                
            </tbody>
            </table>
            <input type="hidden" name="hidden" id="hidden" class="form-control" >
            </div>

        </section>

    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="./js/dashboardNew.js"></script>
    <script src="./js/sidebar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.4/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script>
  function deleteRow(r) {
        console.log(r);
        var v = r;
            document.getElementById('hidden').val = v;
           console.log(document.getElementById('hidden').val);
       window.location="view-budget.php?value=" +document.getElementById('hidden').val;
    }
 </script> 
 
</body>
</html>
