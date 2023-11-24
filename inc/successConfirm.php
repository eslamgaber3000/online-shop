<?php

if (isset($_SESSION['successConfirm'])):?>

    <div class="alert alert-success" role="alert">
      <?= $_SESSION['successConfirm'] ?>
      </div>
      <?php
  unset($_SESSION['successConfirm']);
endif
?>


