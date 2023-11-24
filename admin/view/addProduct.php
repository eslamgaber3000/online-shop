<?php
require_once('../../inc/connectionDB.php');
include "../view/header.php";
include "../view/sidebar.php";
include "../view/navbar.php";



#check on 1-came from submit 2-catch data  3- validation on data 4- if no errors insert into database else show errors
if (isset($_POST['addProduct'])) {

  $image = $_FILES['img'];
  $image_name = $_FILES['img']['name'];
  $image_temp= $_FILES['img']['tmp_name'];
  
  $extension = ['png', 'PNG', 'jpg', 'jpeg'];
  $file_ext = pathinfo($image['name'], PATHINFO_EXTENSION);
  $errors = [];

  $newFileName = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $file_ext;

  

  $title = trim(htmlspecialchars($_POST['title']));
  $description = trim(htmlspecialchars($_POST['desc']));
  $price = trim(htmlspecialchars($_POST['price']));
  ;
  $quantity = trim(htmlspecialchars($_POST['quantity']));
  $categories_selected = trim(htmlspecialchars($_POST['cat']));



  #validation on inputs

  #validation title
  if (empty($title)) {

    $errors[] = 'title is required';
  } elseif (strlen($title) > 30 or strlen($title) < 3) {
    $errors[] = 'tile length is incorrect it must be grater than 3 and less than 30';
  } elseif (is_numeric($title)) {
    $errors[] = 'title must be string';
  }

  #validation description
  if (empty($description)) {
    $errors[] = 'description is required';
  } elseif (strlen($description) > 30 or strlen($description) < 3) {
    $errors[] = 'description length is incorrect it must be grater than 3 and less than 30';
  } elseif (is_numeric($description)) {
    $errors[] = 'description must be string';
  }


  #validation quantity
  if (empty($quantity)) {
    $errors[] = 'quantity is required';
  } elseif (!is_numeric($quantity) and $quantity == 0) {
    $errors[] = 'must be a number, and it can not be = zero';
  } elseif (!ctype_digit($quantity)) {
    $errors[] = 'invalid quantity , it must be integer';
  }

  #validation price
  if (empty($price)) {
    $errors[] = 'price is required';
  } elseif (!is_numeric($price) and $price == 0) {
    $errors[] = 'must be a number, and it can not be = zero';
  } elseif (!filter_var($price,FILTER_VALIDATE_INT)) {
    $errors[] = 'invalid price , it must be integer';
  }

  #validation image 

  if (empty($image_name)) {
    $errors[] = "image is required ";
  } elseif (!in_array($file_ext, $extension)) {
    $errors[] = "image type is not allowed ";
  } elseif ( $image['size'] > (2*1024*1024)) {
    $errors[] = "image size should be  less than 10mb ";
  }


  #if no errors insert into data base else print errors


  if (empty($errors)) {

    $query = "INSERT INTO `products`( `image`,`title`, `description`, `price`, `quantity`,  `category_id`) values ('$newFileName','$title',' $description','$price','$quantity',' $categories_selected')";
    $result = mysqli_query($conn, $query);
    if ($result) {

      move_uploaded_file($image_temp,'../upload/'.$newFileName);

      $_SESSION['success'] = 'an categories is created successfully ';
    }

  } else {

    $_SESSION['errors'] = $errors;
    // require_once('../../inc/error.php');
  }








}

?>

<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="row w-100 m-0">
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
      <div class="card col-lg-4 mx-auto">

        <div class="card-body px-5 py-5">
          <h3 class="card-title text-left mb-3">Add Product</h3>
          <!--inputs validation  -->
          <?php
            
          ?>
          <!-- "form-control p_input" -->
          <?php
          require_once('../../inc/error.php');

          require_once('../../inc/success.php');
          ?>
          <form method="POST" action="addProduct.php" enctype="multipart/form-data">

          <!-- check on  category to get it to product table -->
            <?php
            $query = "SELECT * FROM `categories` ";
            $result = mysqli_query($conn, $query);
            ?>
            <?php
            if (mysqli_num_rows($result) > 1):
              $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
            endif
            ?>
        </div>

        <div class="form-group">
          <label>category</label>

          <?php if (!empty($categories)) { ?>

            <select name="cat" id="" class="form-control p_input">
              <?php

              foreach ($categories as $category): ?>

                <option value="<?= $category['id'] ?>" >
                  <?= $category['name'] ?>
                </option>


              <?php endforeach ?>
            </select>
          <?php
          } else {
            echo "no categories are found";
          }



          ?>





          <!-- <input type="text" name="cat" class="form-control p_input"> -->
        </div>
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" class="form-control p_input">
        </div>
        <div class="form-group">
          <label>Description</label>
          <input type="text" name="desc" class="form-control p_input">
        </div>
        <div class="form-group">
          <label>Price</label>
          <input type="number" name="price" class="form-control p_input">
        </div>
        <div class="form-group">
          <label>Quantity</label>
          <input type="number" name="quantity" class="form-control p_input">
        </div>
        <div class="form-group">
          <label>Image</label>
          <input type="file" name="img" class="form-control p_input">
        </div>
        <div class="text-center">
          <button type="submit" name="addProduct" class="btn btn-primary btn-block enter-btn">Add</button>
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