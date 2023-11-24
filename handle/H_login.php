<?php 
if (isset($_POST['submit'])) {

 require_once('../inc/connectionDB.php');


  $email=trim(htmlspecialchars($_POST['email']));

  $password=trim(htmlspecialchars($_POST['password']));
  // echo $email." ",$password;
 

  
  $errors=[];

  if (empty($email)) {
    $errors[]='email is required ';
  }
  if (empty($password)) {
    $errors[]='password is required ';
  }

  #admin check;
  
  // if ($email=="admin@gmail.com" and $password=="admin") {
  //   header('location:../admin/view/layout.php');
  //   exit();
  // }


//check in errors if it empty or not 


if(empty($errors)){

  $query="select * from `users` where email='$email'";
  $result=mysqli_query($conn,$query);

  if (mysqli_num_rows($result) ==1) {
      $user= mysqli_fetch_assoc($result);
      
    
      $hashed_password=$user['password'];
      
      if(password_verify($password,$hashed_password)){
        if($email !='eslamgm@gmail.com'){

          $_SESSION['user_name']=$user['name'];
          $_SESSION['user_id']=$user['id'];
          $_SESSION['user_login']=true;
          header('location:../shop.php?page=1');
        }else{
          $_SESSION['admin_name']=$user['name'];
          $_SESSION['user_id']=$user['id'];
          $_SESSION['admin_logged']=true;
          header('location:../admin/view/layout.php');
        }
        // session
      }else {
        $_SESSION['errors']=['email or password is not correct'];
        header('location:../login.php');
      }
    
  
  }else {
    
    $_SESSION['errors']=['email or password is not correct'];
    header('location:../login.php');
  }



}else {
$_SESSION['errors']=$errors;
$_SESSION['email']=$email;
$_SESSION['password']=$password;
 header('location:../login.php');
 
}
 
 
 




  
}else {
  header('location:../signup.php');
}













?>