<?php
include "header.php";
include "navbar.php";
require_once('inc/connectionDB.php');

?>

<?php

#coupon handel catch coupon || handel validation if exists in db or not
$totalPrice = $_SESSION['total'];
// echo $totalPrice;
$discount = 0;

if (isset($_POST['Apply'])) {

    $couponEntered = trim(htmlspecialchars($_POST['coupon']));
    $couponValue = 0;

    $selectCoupon = "SELECT * FROM `voucher` where `code`='$couponEntered'";

    $runQuery = mysqli_query($conn, $selectCoupon);
    if (mysqli_num_rows($runQuery) == 1) {


        $coupon = mysqli_fetch_assoc($runQuery);

        $couponValue = $coupon['value'];
        $couponUses = $coupon['uses'];
        $couponMax_max_uses = $coupon['max_uses'];


        if ($couponUses >= $couponMax_max_uses) {

            $_SESSION["errors"] = ['code is expired'];

        } else {


            if ($coupon['type'] == "fixed") {

                $discount = $totalPrice - $couponValue;
                $_SESSION['discount'] = $discount;


            } else {


                $percentage = $couponValue / 100;

                $discount = $totalPrice - ($totalPrice * $percentage);
                $_SESSION['discount'] = $discount;
                //    echo($_SESSION['discount']);




            }






            #update to uses value
            $updateCoupon = "UPDATE `voucher` SET `uses`=  $couponUses+1  WHERE `code`='$couponEntered' ";
            $runUpdate = mysqli_query($conn, $updateCoupon);


            if ($runUpdate) {

                $_SESSION['success'] = 'code added successfully';

            } else {

                $_SESSION["errors"] = ['error while updating'];
            }
        }





        // $_SESSION['discount']=$discount;
        // print_r($totalPrice);
    } else {
        $_SESSION["errors"] = ['code is incorrect'];

    }
}



// handel confirm order form start
if (isset($_POST['submit'])) {
    // echo "<h6><h6>";
    extract($_POST);
    // echo $postalCode;

    $user_id = $_SESSION['user_id'];
    $errors = [];

    //catch data from inputs and validation if it is valid store it in order table
    // inputs name ,email , address, city ,postal code ,phone ,paymentType


    if (empty($name)) {
        $errors[] = 'name is required';
    } elseif (is_numeric($name)) {
        $errors[] = 'name must be string';

    }

    if (empty($email)) {
        $errors[] = 'email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'email is incorrect';

    }

    if (empty($address)) {
        $errors[] = 'address is required';
    } elseif (is_numeric($address)) {
        $errors[] = 'address is incorrect';

    }
    if (empty($city)) {
        $errors[] = 'city is required';
    } elseif (is_numeric($city)) {
        $errors[] = 'city is incorrect';

    }
    if (empty($paymentType)) {
        $errors[] = 'paymentType is required';
    } elseif (is_numeric($paymentType)) {
        $errors[] = 'paymentType is incorrect';

    }
    if (empty($postalCode)) {
        $errors[] = 'postalCode is required';
    } elseif (!is_numeric($postalCode)) {
        $errors[] = 'postalCode is incorrect';

    }

    #if empty errors add in database else add in session of errors



    if (empty($errors)) {


        if (!isset($_SESSION['discount'])) {
            $_SESSION['discount'] = 0;
        }

        $query = "INSERT INTO `orders` (`postalcode`,`name`,  `email`, `address`, `city`, `phone`,`user_id`,`totalPrice`,`total_after_discount`,`payment_type`)
        values( $postalCode,'$name','$email','$address','$city','$phone',$user_id,$totalPrice,{$_SESSION['discount']},'$paymentType')";
        $row = mysqli_query($conn, $query);
        $_SESSION['successConfirm'] = 'data inserted successfully';





        #insert order_id and product_id into order_product


        #order_product start
        $order_productSelect = "SELECT id FROM `orders` where user_id =$user_id ORDER by id DESC ";
        $run_Order_productSelect = mysqli_query($conn, $order_productSelect);
        if (mysqli_num_rows($run_Order_productSelect) > 1) {

            $order_id = mysqli_fetch_assoc($run_Order_productSelect)['id'];
            foreach ($_SESSION['cart'] as $cart) {


                $order_productInsert = " INSERT INTO `order_product` values($order_id,{$cart['product_id']})";
                $run_Order_productInsert = mysqli_query($conn, $order_productInsert);
            }

            // empty to cart session after confirming the order


            //   $cart['product_id'];

        //    unset($_SESSION['cart']);
        //    print_r($_SESSION['cart']);

        } else {
            $errors[] = 'error happening ';
        }


        #order_product end


    } else {
        $_SESSION['confirmErrors'] = $errors;
    }


    // handel confirm order form end

}




?>
<section id="cart-add" class="section-p1">
    <div id="coupon">
        <h3>Coupon</h3>
        <h3>total price is :
            <?php if ($discount > 0) {

                # code...
                echo $discount;


            } else {
                echo $totalPrice;
            }
            ?>
        </h3>

        <!-- start form for coupon -->
        <?php
        require_once('inc/success.php');
        require_once('inc/error.php');
        ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="text" name="coupon" placeholder="Enter coupon code">
            <button class="normal" name="Apply" type="submit">Apply</button>
        </form>
        <!-- end form for coupon -->

    </div>



    <div id="subTotal">
        <h3>Cart totals</h3>
        <?php
        require_once('inc/confimError.php');
        require_once('inc/successConfirm.php');
        ?>
        <form action="confirmOrder.php" method="post" class="col-4">
                name<input type="text"name="name"  placeholder="name" class="form-control">
                <!-- <input type="text" name="name" placeholder="name"> -->
                email <input type="text"  placeholder="email" name="email" class="form-control">
                <!-- <input type="text"  class="form_control"> -->
                address <input type="text" name="address" placeholder="address"class="form-control">
                city<input type="text" name="city" placeholder="city"class="form-control">
                postalCode<input type="number" name="postalCode" placeholder="postalCode" class="form-control">
                phone<input type="text" name="phone" placeholder="phone" class="form-control">
                paymentType<select class="" name="paymentType" class="form_control"class="form-control">
                    <option value="Cash_on_Delivery">Cash on Delivery</option>
                    <option value="Credit_Card">Credit Card</option>
                    <option value="Fawry">Fawry</option>
                </select>
            <button class="normal" name="submit" type="submit">submit</button>
        </form>
    </div>



</section>




<?php include "footer.php" ?>


>