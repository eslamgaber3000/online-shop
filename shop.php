<?php
 require_once('inc/connectionDB.php') ;
 require_once('navbar.php') ;
 include 'header.php';
?>





<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modren Desgin</p>
    <div class="pro-container">
        <?php



        /*
        #### pagination=(limit and offset )
        1-limit =3 || offset =imit *(number of pages-1) | page->query string;
                                                number of pages->total/limit | and translate to 

        */
        $limit = 3;
        $query = "SELECT count(id) as totalProducts  from products";
        $value = mysqlI_query($conn, $query);
        $assProduct = mysqli_fetch_assoc($value);

        $totalPages = $assProduct['totalProducts'];

        // number of pages / limit | and use function to avoid fractions
        
        $numOfPages = ceil($totalPages / $limit);
        if (isset($_GET['page'])) {


            $page = $_GET['page'];


            if ($page < 1) {

                $offset = 0;


            } elseif ($page > $numOfPages) {
                $offset = $numOfPages;
            } else {
                $offset = ($page - 1) * $limit;
            }


        } else {
            $offset = 1;
        }


        /*
        shop.php  select data from db | show it in the div
        if there where data in table sho section of product1 else echo there where no products now 

        */
        $query = "SELECT products.title, categories.name as category_name,products.image,products.id as product_id ,products.description,products.quantity,products.price FROM products JOIN categories ON products.category_id = categories.id  limit $limit   OFFSET $offset;";
        $result = mysqlI_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($products as $product) {
                ?>
                <div class="pro">
                    <form  action="cart.php" method="post" >
                        
                        
                        <img src="<?= 'admin/upload/'.$product['image'] ?>" alt="p1" />
                        
                    <div class="des">
                        <h2>
                            <?= $product['title'] ?>
                        </h2>
                        <h5>
                            <?= $product['description'] ?>
                        </h5>
                        <div class="star ">
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star "></i>
                            <i class="fas fa-star "></i>
                        </div>
                        <h5>
                            <?= $product['category_name'] ?>
                        </h5>
                        <input type="number" name="quantity">
                        <input type="hidden" name="image" value="<?= $product['image'] ?>"  >
                        <input type="hidden" name="description" value="<?= $product['description'] ?>"  >
                        <input type="hidden" name="price" value="<?= $product['price'] ?>" >
                        <input type="hidden" name="product_quantity" value="<?= $product['quantity'] ?>" >
                        <input type="hidden" name="product_title" value="<?= $product['title'] ?>" >
                        <input type="hidden" name="category_name" value="  <?= $product['category_name'] ?>">
                        <input type="hidden" name="product_id" value="  <?= $product['product_id'] ?>">
                        <button type="submit"  name="addToCart" ><a href="cart.php" class="cart"><i class="fas fa-shopping-cart"></i></a></button>
                        </form>
                    </div>
                </div>

                <?php
            }

        } else {
            ?>


            <h3 class="text-center">there are no products to be shown now</h3>

            <?php
        }

        ?>


    </div>
</section>




<section id="pagenation" class="section-p1">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="shop.php?page=<?= $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">
                    <?= $page . " of  " . $totalPages ?>
                </a></li>

            <li class="page-item">
                <a class="page-link" href="shop.php?page=<?= $page +1 ?>"
                   
                 aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>

</section>

<section id="newsletter" class="section-p1 section-m1">
    <div class="newstext ">
        <h4>Sign Up For Newletters</h4>
        <p>Get E-mail Updates about our latest shop and <span class="text-warning ">Special Offers.</span></p>
    </div>
    <div class="form ">
        <input type="text " placeholder="Enter Your E-mail... ">
        <button class="normal ">Sign Up</button>
    </div>
</section>


<?php include 'footer.php' ?>