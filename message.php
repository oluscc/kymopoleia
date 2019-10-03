<?php
if(isset($_SESSION['error'])){
   $error = $_SESSION['error'];
   echo $error;
}
?>
 
    <div id='alert'><div class=' alert alert-block alert-info fade in center'><?php echo ($error);?></div>

