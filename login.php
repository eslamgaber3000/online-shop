<?php
require_once('inc/connectionDB.php');
include "header.php";
include "navbar.php";

?>
<?php  

#check on the session that came from handel of login page

require_once('inc/error.php');
#check on session which came from signup page
if (isset($_SESSION['success'])) :
?>
<div class="alert alert-success">
  <?= $_SESSION['success']  ?>
</div>
<?php
unset($_SESSION['success']);
endif



?>

            
              <div class="card-body px-5 py-5" style="background-color:darkgray;">
                <h3 class="card-title text-left mb-3">Login</h3>
                <form method="post" action="handle/H_login.php">
                  <div class="form-group">
                    <label>email *</label>
                    <input type="email" value="<?php echo (isset($_SESSION['email']))? $_SESSION['email']:'';unset($_SESSION['email']); ?>"  name="email" class="form-control p_input" >
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" value="<?php echo (isset($_SESSION['password']))? $_SESSION['password']:'';unset($_SESSION['password']); ?>" name="password" class="form-control p_input" >
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="forgetPassword.php" class="forgot-pass">Forgot password</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <div class="d-flex">
                    <button class="btn btn-facebook me-2 col">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div>
                  <p class="sign-up">Don't have an Account?<a href="signup.php"> Sign Up</a></p>
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

    <?php include "footer.php" ?>


    //table user, product, cart , review comment , rating  = session