<?php
require_once('../../inc/connectionDB.php');
include "../view/header.php";
include "../view/sidebar.php";
include "../view/navbar.php";



//check from where he came ? || catch data || validation || check if this code is exists or not || finally insert into database




?>

<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="row w-100 m-0">
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
      <div class="card col-lg-4 mx-auto">

        <div class="card-body px-5 py-5">
          <h3 class="card-title text-left mb-3">Add Voucher</h3>
          <!--inputs validation  -->

          <!-- "form-control p_input" -->
          <?php


          if (isset($_POST['addCoupon'])) {

            $errors = [];

            extract($_POST);


            if (empty($code)) {
              $errors[] = 'code is required';
            }
            if (empty($type)) {
              $errors[] = 'type is required';
            }
            if (empty($value)) {
              $errors[] = 'value is required';
            }
            if (empty($max_uses)) {
              $errors[] = 'max_uses is required';
            }

            $select = "SELECT  `code` from `voucher` where code='$code' ";
            $SelectRow = mysqli_query($conn, $select);

            $result = mysqli_num_rows($SelectRow);
            if ($result == 1) {
              $errors[] = 'code is already exists';
            }



            if (empty($errors)) {
  
              $insert = "INSERT INTO `voucher`(`code`, `type`, `value`, `max_uses`) VALUES ('$code','$type','$value','$max_uses' )  ";
              $result = mysqli_query($conn, $insert);
  
              if ($result) {
                $_SESSION['success'] = 'data inserted successfully';
              } else {
  
                $errors[] = 'an error happen while data inserted';
              }
  
            } else {
              if (!isset($_SESSION['errors'])) {
  
                $_SESSION['errors'] = [];
              }
              $_SESSION['errors'] = $errors;
  
            }
          }


          


 require_once('../../inc/error.php');
require_once('../../inc/success.php');



        
          ?>


          <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

            <!-- check on  category to get it to product table -->
        </div>
        <label for=""></label>

        <div class="form-group">
          <label for="code">Code</label>
          <input id="code" type="text" name="code" class="form-control p_input">
        </div>
        <div class="form-group">
          <label for="type">Type</label>
          <select name="type" id="type" class="form-control p_input">
            <option value="percentage">percentage</option>
            <option value="fixed">fixed</option>
          </select>
        </div>
        <div class="form-group">
          <label for="max_uses">Max_use</label>
          <input id="max_uses" type="number" name="max_uses" class="form-control p_input">
        </div>
        <div class="form-group">
          <label for="value">Value</label>
          <input id="value" type="number" name="value" class="form-control p_input">
        </div>
        <div class="text-center">
          <button type="submit" name="addCoupon" class="btn btn-primary btn-block enter-btn">Add</button>
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