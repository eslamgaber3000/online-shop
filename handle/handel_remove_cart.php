<?php 
if(isset($_POST['delete'])){
    session_start();
     $row= $_POST['number_of_row'];


    unset($_SESSION['cart'][$row]);
    //  array_values($_SESSION['cart']);
    print_r($row);
    // echo count($_SESSION['cart']);
    header('location:../cart.php');
    
}else {
    header('location:../cart.php');
}


?>