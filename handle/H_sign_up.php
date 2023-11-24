<?php
require_once('../inc/connectionDB.php');



if (isset($_POST['submit'])) {




  $name = trim(htmlspecialchars($_POST['name']));
  $email = trim(htmlspecialchars($_POST['email']));
  $password = trim(htmlspecialchars($_POST['password']));
  $phone = trim(htmlspecialchars($_POST['phone']));
  $address = trim(htmlspecialchars($_POST['address']));
  // $role = trim(htmlspecialchars($_POST['role']));
  $errors = [];
  $roles = ['user', 'admin'];
  // validation on name required | string | length is more than 2 an less than 20


  if (empty($name)) {
    $errors[] = 'name is required ';
  } elseif (strlen($name) < 2 or strlen($name) > 20) {
    $errors[] = 'name length must be more than 2 and less than 20 ';
  } elseif (is_numeric($name)) {
    $errors[] = 'name must be string ';
  }

  // echo strlen($name);
  // exit('now we end');


  // validation on emil required | emil | unique 


  if (empty($email)) {
    $errors[] = 'email  is required ';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email  is not valid ';
  }




  //select operation
  $query = "select * from `users` where email='$email'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $errors[] = 'email is already exists ';



  }

  // validation on password required | is string |  is more than 6 an less than 100

  if (empty($password)) {
    $errors[] = 'password  is required ';
  } elseif (!is_string($password)) {
    $errors[] = 'password  is must be string ';
  } elseif (strlen($password) < 6 or strlen($password) > 100) {
    $errors[] = 'password  must be grater than 6 and less than 100 ';
  }

  // validation on phone required | phone | unique is more than 10


  if (empty($phone)) {
    $errors[] = 'phone  is required ';
  } elseif (!is_string($phone)) {
    $errors[] = 'phone  must be string ';
  } elseif (strlen($phone) < 10) {
    $errors[] = 'phone  must be grater than 10';
  }


  if (empty($address)) {
    $errors[] = 'address  is required ';
  } elseif (!is_string($address)) {
    $errors[] = 'address  must be string ';
  } elseif (strlen($address) < 5) {
    $errors[] = 'address  must be grater than 5';
  }

 #validate role  require | user or admin | string 
  // if (empty($role)) {
  //   $errors[] = 'role  is required ';
  // } elseif (!in_array($role, $roles)) {
  //   $errors[] = 'incorrect role';
  // } elseif (is_numeric($role)) {
  //   $errors[] = 'role  must be string ';
  // }


  // check on errors 

  if (empty($errors)) {

    #hashing password
    $hashing_password = password_hash($password, PASSWORD_BCRYPT);

    // insert query | run query
    $query = "INSERT INTO `users`(`name`,`email`,`password`,`phone`,`address`)VALUES('$name','$email','$hashing_password','$phone','$address')";

    $result = mysqli_query($conn, $query);
    if ($result) {
      $_SESSION['success'] = ' New record created successfully';
      header('location:../login.php');
    }

  } else {
    #check on the session or error if it closed reopen it

    if (!isset($_SESSION['errors'])) {
      $_SESSION['errors'] = [];
    }
    $_SESSION['errors'] = $errors;

    #return the values of error inputs to user to edit it not to rewrite it from scratch
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $address;
    $_SESSION['role'] = $role;

    header("location:../signup.php");
  }

} else {
  header('Location:../signup.php');
}













/*

  $validName="/^[a-zA-Z]{2,20}$/";
elseif (!preg_match($validName,$name)) {
        $errors[]='length of name should grater than 2 and less than 20';
    }
*/
?>