<?php
require_once('inc/connectionDB.php')

    ?>

<section id="header">
    <a href="index.html">
        <img src="img/logo.png" alt="homeLogo">
    </a>

    <div>
        <ul id="navbar">
            <li class="link">
                <a class="active " href="index.html"></a>
            </li>
            <li class="link">
                <a href="shop.php?page=1">shop</a>
            </li>
            <li class="link">
                <a href="blog.php">Blog</a>
            </li>
            <li class="link">
                <a href="about.php">About</a>
            </li>
            <li class="link">
                <a href="contact.php">Contact</a>
            </li>
            <li class="link">
                <a href="signup.php">Signup</a>
            </li>
            <li class="link">
                <a href="lang.php?lang=en">English</a>
            </li>
            <li class="link">
                <a href="lang.php?lang=ar">Arabic</a>
            </li>
            <?php
            if (isset($_SESSION['user_login']) and $_SESSION['user_login'] == true) { ?>

                <li class="link">
                    <a href="logout.php">logout</a>
                </li>
                <li class="link">

                    <a href="#">
                        <?= $_SESSION['user_name'] ?>
                    </a>
                </li>


                <?php
            } else { ?>
                <li class="link">
                    <a href="login.php">login</a>
                </li>
                <?php
            }
            ?>



            <li class="link">
                <a id="lg-cart" href="cart.php">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </li>
            <a href="#" id="close"><i class="fas fa-times"></i> </a>
        </ul>

    </div>

    <div id="mobile">
        <a href="cart.html">
            <i class="fas fa-shopping-cart"></i>
        </a>
        <a href="#" id="bar"> <i class="fas fa-outdent"></i> </a>
    </div>
</section>