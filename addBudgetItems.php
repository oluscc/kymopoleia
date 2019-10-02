<?php
	ob_start();
    session_start();
    
    require_once "./PHP/database.php";
    if(!isset($_SESSION['email'])){
         header("Location: login.php");
    // }
    // else if (!isset($_SESSION['Budget_id'])){
    //     header("Location: budgetdashboard.php");
    }else{
       
        $sql = "SELECT * FROM Priority ";
        $result = $conn->query($sql);
        $res = $conn->query($sql);
        $priorities= $result->fetch(PDO::FETCH_ASSOC);
        $sql2 = "SELECT * FROM ItemCategories ";
        $result2 = $conn->query($sql2);
        $res2 = $conn->query($sql2);
        $categories= $result2->fetch(PDO::FETCH_ASSOC);
        $sql3 = "SELECT * FROM BudgetDetails WHERE Budget_id = '{$_SESSION['Budget_id']}' ";
        $result3 = $conn->query($sql3);
        $Item= $result3->fetch(PDO::FETCH_ASSOC);
    }  
?>
<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
        $insert = "DELETE  FROM BudgetDetails WHERE Budget_id = '{$_SESSION['Budget_id']}'";
        $exe = $conn->exec($insert);
                $item = $_POST['item'];
                // echo($item);
                $budget_name = $_SESSION['Budget_id'];
                $description = $_POST['description'];
                // echo($description);
                $priority = $_POST['priorities'];
                $amount = $_SESSION['Amount'];
                $itemAmount = 0;
                $percent=0;;
                $m=0;
                foreach($priority as $p){
                $percent=$percent+$p;
                }
                foreach($item as $it){
                $itemAmount = round(($priority[$m]/$percent)* $amount);
                echo($itemAmount);
                $insert = "INSERT INTO BudgetDetails (id,item,description,Priority,Amount,Budget_id)
                            VALUES( null, '$it',  '$description[$m]','$priority[$m]','$itemAmount','{$_SESSION['Budget_id']}')";
                $exe = $conn->exec($insert);
                $m++;
                }
             header("location: view-budget.php");
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
            <p class="welcome_user">Hi, <span class="blueText"><?php echo $_SESSION['firstname']	;  echo $_SESSION['lastname']	; ?></span></p>
            <img class='user-avatar' src="images/user.png" alt="">
            <div class="dropdown">
                <div class="dropdown-toggler" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="./images/drop.png" alt="">
                </div>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="dashboard.php"><?php  echo($_SESSION['usernames']); ?></a>
                    <a class="dropdown-item" href="logout.php">Sign out</a>
                </div>
            </div>

        </nav>

    </header>

    <main>


    
        
        <?php include "./PHP/sidebar.php"; ?>
      
        <section class="buget__dashboard">
            <div class="container">
                <br><br>
                <div>
                    <div class="budget__headline">
                        <div>
                            <h5>Budget Title:</h5>
                        </div>
                        <div>
                            <p><?php echo $_SESSION['Budget_id']; ?></p>
                        </div>
                    </div>
                    <br>
                    <div class="budget__headline">
                        <div>
                            <h5>Amount Allocated:</h5>
                        </div>
                        <div>
                            <p>&#8358; <?php echo $_SESSION['Amount']; ?></p>
                        </div>
                    </div>
                    <br><br>
                </div>
                <div class="welcome__text">
                    <div>
                        <h4>Add Budget Item</h4>
                        <p id="total_amount_budgeted"></p>
                    </div>
                    <div class="budget__form">
                        <form id= "set" action="" >
                            <select id= "item1" name="item1">
                            <option id="cat" name="cat" value=" " data-value="">..Select category...</option>
                                <?php do{ ?>
                                    <option id="cat" name="cat" value="<?php echo ($categories['ItemCategory']); ?>" data-value="<?php echo ($categories['description']); ?>"><?php echo ($categories['ItemCategory']); ?></option>
                                 <?php }while($categories= $result2->fetch(PDO::FETCH_ASSOC))?>
                                 <option id="cat" name="cat" value="others" data-value="">others</option>
                            </select>

                            <input type="text" placeholder="<?php echo $_SESSION['Budget_id']; ?>" disabled>

                            <br>
                            <select id="priority1" name="priorities1">
                            <option id="cat" name="cat" value=" " data-value="">..Set priority...</option>
                                <?php do{ ?>
                                    <option value="<?php echo ($priorities['percent']); ?>" data-value="<?php echo ($priorities['priority']); ?>"><?php echo ($priorities['priority']); ?></option>
                                 <?php }while($priorities= $result->fetch(PDO::FETCH_ASSOC))?>
                            </select>
                            <input type="text" id="description1" name="description1" placeholder="Description" value="">
                            <br>
                        </form>
                        <button  name ="add-row" id="add-row" class="btn budget-save text-center bgBlue">Add item</button>
                    </div>
                </div>   
                    <div>
                        <div>
                            <h3><?php echo $_SESSION['Budget_id']; ?> Budget Items</h3>
                        </div>
                    </div>
                <div class="budget__form">
                    <form  action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
                    
                            <table class="table table-stripped table-bordered" id="invoice">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>Priority</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody> 
                                        <?php $i=0; if(($result3->rowCount())>0){ do{?>
                                    <tr class='itemRows'>
                                        <td ><?php echo $i?></td>
                                        <td  value="<?php  echo($Item['Item']);?>"><?php  echo($Item['Item']);?><input type="hidden" name="item[]" id="item" value="<?php  echo($Item['Item']);?>"></td>
                                        <td value="<?php  echo($Item['description']);?>" ><?php  echo($Item['description']);?><input type="hidden" id="description" name="description[]"  value="<?php  echo($Item['description']);?>"></td>
                                        <td  value="<?php  echo($Item['Priority']);?>" > <?php $sql4 = "SELECT * FROM Priority WHERE percent = '{$Item['Priority']}' ";
                                        $result4 = $conn->query($sql4);
                                        $itemp= $result4->fetch(PDO::FETCH_ASSOC); echo($itemp['priority']) ?><input type="hidden" id="prioriy_id" name="priorities[]"  value="<?php  echo($Item['Priority']);?>" ></td>
                                        <td><button type="button" href="#" type="text" onclick= "return deleteRow(this)"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                        <?php $i=$i+1;}while($Item =$result3->fetch(PDO::FETCH_ASSOC));}?>
                                </tbody>
                            </table>
                            <button type="submit" id="save" name="save" class="btn budget-save text-center bgBlue">Save</button><br><br><a  href="view-budget.php?value=" +<?php echo($_SESSION['Budget_id']);?> class="btn budget-save text-center bgBlue">Cancel</a>
                    
                    </form>  
                </div>

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
    <script >
    var i = <?php echo $i;?>;
    function deleteRow(r) {
    i=i-1;
    let l = r.parentNode.parentNode.rowIndex;
    document.getElementById("invoice").deleteRow(l);
}
    $(document).ready(function(){
        var it,pr,prio;
        
        $("#item1").change(function(){
           
            var v = this.options[ this.selectedIndex].getAttribute('data-value');
            it = this.options[this.selectedIndex].value;

            console.log(it);
            if (it ==='others'){
                 it = prompt('Your own item','');
                if (it) {
                    this.options[this.options.length-1].text = it;
                    this.options[this.options.length-1].value = it;
                    this.options[this.options.length] = new Option('others','others');
                }
            }
            document.getElementById('description1').value = v;
            document.getElementById('description1').placeholder = v;
          console.log(it);
          
        });
        $("#priority1").change(function(){
            prio = this.options[ this.selectedIndex].getAttribute('data-value');
            console.log(pr);
            pr = this.options[ this.selectedIndex].value;
        });

        $("#add-row").click(function(){
           i=i+1;
        let des = document.getElementById('description1').value;
        let rows = +($('table tbody tr.itemRows').length) + Math.floor(1000 + Math.random() * 9000);
        let markup ="<tr  class='itemRows' row='"+rows+"'> <td >"+i+"</td><td  row='"+rows+"' value='"+it+"'>"+it+"<input name='item[]' id='item' type='hidden' value='"+it+"'></td><td value='"+des+"'>"+des+"<input id='description' name='description[]' type='hidden' value='"+des+"'></td><td  value='"+pr+"' placeholder='"+prio+"' >"+prio+"<input id='prioriy_id' name='priorities[]' type='hidden' value='"+pr+"'></td><td><button type='button' onclick= 'return deleteRow(this)'><i class='fa fa-trash'></i></button></td></tr>";
         $("table tbody").append(markup);
        document.getElementById('set').reset();
        });

       

    // $('input[name=checkbox]').change(function(){
    //     if($(this).is(':checked')) {
    //         let rows = +($('table tbody tr.itemRows').length) + Math.floor(1000 + Math.random() * 9000);
    //         let v =$(this)[0].value;
           
    //         let markup ="<tr class='itemRows' row='"+ rows +"'><td><input name='item[]' id='item' type='text' row='"+rows+"' class='form-control' value='"+v+"' required></td><td><input name='description[]' id='description' type='text' row='"+ rows +"' class='form-control' value='' ></td><td><div class='input-group'><select name='priorities[]' class='form-control' id='priority_id' row='"+rows+"' '> <?php while($priorities= $res->fetch(PDO::FETCH_ASSOC)){?><option value='<?php echo ($priorities['percent']); ?>' percentage='<?php echo ($priorities['percent']); ?>''> <?php echo $priorities['priority']; ?></option> <?php } ?></select></td><td><button type='button' onclick=' return deleteRow(this)' class='btn btn-danger' style='width:100%;'><i class='fa fa-trash'></i>Delete Item</button></td></tr>";
    //         $("table tbody").append(markup);
    //     } else {
    //        //
    //     }
        
    // });

});    
</script>
</body>

</html>