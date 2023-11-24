<?php
// require_once('connectionDB.php');
if (isset($_SESSION['confirmErrors'])):

  foreach ($_SESSION['confirmErrors'] as $error) : ?>
    <div class="alert alert-danger" role="alert">
      <?= $error ?>
    </div>
    <?php
  endforeach;
  unset($_SESSION['confirmErrors']);
endif
?>


