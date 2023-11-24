<?php

if (isset($_SESSION['success'])):?>

    <div class="alert alert-success" role="alert">
      <?= $_SESSION['success'] ?>
      </div>
      <?php
  unset($_SESSION['success']);
endif
?>


