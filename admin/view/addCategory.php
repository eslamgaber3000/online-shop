<?php
require_once('../../inc/connectionDB.php');
include "../view/header.php";
include "../view/sidebar.php";
include "../view/navbar.php";





?>


<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="row w-100 m-0">
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
      <div class="card col-lg-4 mx-auto">

        <div class="card-body px-5 py-5">
          <h3 class="card-title text-left mb-3">Add Category</h3>

          <?php

#check on 1-came from submit 2-catch data  3- validation on data 4- if no errors insert into database else show errors
#check on 1-came from submit 2-catch data  3- validation on data 4- if no errors insert into database else show errors



if (isset($_POST['addCategory'])) {

  require_once('../../inc/error.php');


  require_once('../../inc/success.php');

  $error = [];
            $title = trim((htmlspecialchars($_POST['name'])));
            
            $query = "SELECT * FROM `categories` where `name`='$title'";
            $result = mysqli_query($conn, $query);
            
            if (empty($title)) {
              $errors = ['title is required'];
            } elseif (mysqli_num_rows($result) == 1) {
             
              $errors = ['title is already exists'];
            }

            if (empty($errors)) {
              
              $query = "INSERT INTO `categories`( `name`) VALUES ('$title')";
              $result = mysqli_query($conn, $query);
              if ($result) {
                $_SESSION['success'] = 'an categories is created successfully ';
              } else {
                $errors = ['title is already exists'];
              }



            } else {
              $_SESSION['errors'] = $errors;
            }

            


          }
          ?>

          

          <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="name" class="form-control p_input">
            </div>
            <div class="text-center">
              <button type="submit" name="addCategory" class="btn btn-primary btn-block enter-btn">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- row ends -->
</div>
<!-- page-body-wrapper ends -->
</div>

<?php
include "../view/footer.php";
?>