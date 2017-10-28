<?php
//Include Error Handler
require_once '../../utility/error_handler.php';
//Include products by category controller
require_once "../../controller/products/products_by_category_controller.php";
//Include main Headers
require_once "../elements/headers.php";
?>

    <!-- Define Page Name -->
    <title>MagBuy | <?= $categoryName ?></title>
    <script type="text/javascript">
        function filterProducts() {
            var xhttp = new XMLHttpRequest();
            var productsWindow = document.getElementById("productsWindow");
            var mostSold = document.getElementById("mostSoldFilter").checked;
            var mostReviewed = document.getElementById("mostReviewedFilter").checked;
            var newest = document.getElementById("newestFilter").checked;
            var highestRated = document.getElementById("highestRatedFilter").checked;

            var msf = 0;
            if (mostSold === true) {
                msf = 1;
            }

            var mrf = 0;
            if (mostReviewed === true) {
                mrf = 1;
            }

            var newf = 0;
            if (newest === true) {
                newf = 1;
            }

            var hrf = 0;
            if (highestRated === true) {
                hrf = 1;
            }

            xhttp.onreadystatechange = function () {
                productsWindow.innerHTML = "<img src='../../web/assets/images/ajax-loader.gif' align='center'>";
                if (this.status == 200 && this.readyState == 4) {

                }
            };
            xhttp.open("GET", "../../controller/products/products_by_category_filters_controller.php?msf="
                + msf + "&mrf=" + mrf + "&newf=" + newf + "&hrf=" + hrf + "&scid=" + <?= $_GET['subcid'] ?>, true);
            xhttp.send();
        }
    </script>
<?php
//Include Header
require_once "../elements/header.php";
//Include Navigation
require_once "../elements/navigation.php";
?>

    <!-- Products by category -->
    <div class="products">
        <div class="container">
            <div class="products-grids">
                <div class="col-md-8 products-grid-left" id="productsWindow">
                    <div class="products-grid-lft">
                        <?php
                        $counter = 0;
                        foreach ($products as $product) {
                            if ($product['percent'] != null && $product['start_date'] < date("Y-m-d H:i:s")
                                && $product['end_date'] > date("Y-m-d H:i:s")
                            ) {
                                $promotedPrice = round($product['price'] - (($product['price'] *
                                            $product['percent']) / 100), 2);
                            } else {
                                unset($promotedPrice);
                            }
                            $counter++;
                            if ($counter > 3) {
                                echo '<div class="clearfix"></div>
                </div>';
                                echo '<div class="products-grid-lft">';
                                $counter = 0;
                            }
                            ?>
                            <div class="products-grd">
                                <div class="p-one simpleCart_shelfItem prd">
                                    <a href="single.php?pid=<?= $product['id']; ?>">
                                        <img src="<?= $product['image_url'] ?>"
                                             alt="Product Image" class="img-responsive"/>
                                    </a>
                                    <h4><?= $product['title']; ?></h4>
                                    <p><a class="btn btn-default btn-sm"
                                          onclick="addToCart(<?= $product['id'] . "," .
                                          (isset($promotedPrice) ? $promotedPrice : $product['price']) ?>)">
                                            <i class="glyphicon glyphicon-shopping-cart"></i>&nbspAdd
                                        </a>&nbsp&nbsp
                                        <?php
                                        if (isset($promotedPrice)) {
                                            ?>
                                            <span class="item_price valsa"
                                                  style="color: red;">$<?= $promotedPrice; ?></span>
                                            <span class="item_price promoValsa">$<?= $product['price']; ?></span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="item_price valsa">$<?= $product['price']; ?></span>
                                            <?php
                                        }
                                        ?></p>
                                    <div class="pro-grd">
                                        <a href="single.php?pid=<?= $product['id']; ?>">View</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4 products-grid-right">
                    <div class="w_sidebar">
                        <div class="w_nav1">
                            <h4>Filters</h4>
                            <ul>
                                <li>
                                    Most sold
                                    <input id="mostSoldFilter" type="checkbox" onclick="filterProducts()">
                                </li>
                                <li>
                                    Most reviewed
                                    <input id="mostReviewedFilter" type="checkbox" onclick="filterProducts()">
                                </li>
                                <li>
                                    Newest
                                    <input id="newestFilter" type="checkbox" onclick="filterProducts()">
                                </li>
                                <li>
                                    Highest rated
                                    <input id="highestRatedFilter" type="checkbox" onclick="filterProducts()">
                                </li>
                            </ul>
                        </div>
                        <section class="sky-form">
                            <h4>Price filter</h4>
                            <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                            <div id="slider-range"></div>
                        </section>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

<?php
//Include Footer
require_once "../elements/footer.php";
?>