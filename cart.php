<?php require_once('inc/connectionDB.php');

include 'navbar.php';
include 'header.php' 
?>



<?php


if (isset($_POST['addToCart'])) {

    extract($_POST);
    //delete data from session 



    // validation on quantity
    if (empty($quantity)) {
        $quantity = 1;
    }

    if ($quantity > $product_quantity) {

        echo 'quantity is not suitable';
    }

    // store data in session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }


    $cart = [

        'quantity' => $quantity,
        'image' => $image,
        'description' => $description,
        'price' => $price,
        'name' => $product_title,
        'product_id' => $product_id,
        
    ];
    if (!in_array($cart, $_SESSION['cart'])) {



        $_SESSION['cart'][]= $cart;
    }


}


?>

<section id="page-header" class="about-header">
    <h2>#Cart</h2>
    <p>Let's see what you have.</p>
</section>
<section id="cart" class="section-p1">
    <table width="25%">
        <thead>
            <tr>
                <td>Image</td>
                <td>Name</td>
                <td>Desc</td>
                <td>Quantity</td>
                <td>price</td>
                <td>Subtotal</td>
                <td>Remove</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalPrice = 0;
            $number_of_row=-1;
        
            foreach ($_SESSION['cart'] as $cart):
                $number_of_row++;

                $subtotal = $cart['price'] * $cart['quantity'];
                ?>

                <tr>
                    <td><img src="<?= 'admin/upload/' . $cart['image'] ?>" alt="product1"></td>
                    <td>
                        <?= $cart['name'] ?>
                    </td>
                    <td>
                        <?= $cart['description'] ?>
                    </td>
                    <td>
                        <?= $cart['quantity'] ?>
                    </td>
                    <td>
                        <?= $cart['price'] ?>
                    </td>
                    <td>
                        <?= $subtotal ?>
                    </td>
                    <td>
                        <form action="handle/handel_remove_cart.php"method='post'>
                      
                        <input type="hidden" name="number_of_row" value="<?=$number_of_row?>">
                        <button type="submit"name='delete' class="btn btn-danger">Remove</button>
                        </form>
                    </td>

                </tr>

                <?php
                $totalPrice += $subtotal;
                $_SESSION['total']= $totalPrice;
            endforeach;


            ?>



            <!-- Remove any cart item  -->



            </tr>
        </tbody>
        <!-- confirm order  -->

        <form action="confirmOrder.php"  method="post" >
        <td><button type="submit" name="" class="btn btn-success">Confirm</button></td>
        </form>
    </table>
</section>

<section id="cart-add" class="section-p1">
    <div id="coupon">
        <h3>Coupon</h3>
        <input type="text" placeholder="Enter coupon code">
        <button class="normal">Apply</button>
    </div>
    <div id="subTotal">
        <h3>Cart totals</h3>
        <table>
            <tr>
                <td>Subtotal</td>
                <td>
                    <?= $totalPrice ?>
                </td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>$118.25</strong></td>
            </tr>
        </table>
        <button class="normal">proceed to checkout</button>
    </div>
</section>

<?php include "footer.php" ?>