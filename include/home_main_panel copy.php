<div class="main-panel">
    <div class="content-wrapper pb-0">
        <div class="page-header">
            <h3 class="page-title">Product Table</h3>
            <?php include "../include/user_breadcrumb.php"; ?>
            <div class="page-header flex-wrap">
                <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
                </h3>
                <div class="d-flex">
                    <a href="../admin/home.php">
                        <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                            <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
                        </button>
                    </a>
                </div>
            </div>

            <!-- Category buttons and search box -->
            <div class="d-flex justify-content-between align-items-center m-5">
                <div class="category-buttons">
                    <button class="btn btn-sm btn-info category-filter" data-category="all">All</button>

                    <?php
                    $category_list_query = "SELECT  p.pr_id as pr_id, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, 
    i.in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
    FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30 AND i.remarks = 'ACTIVE'  GROUP BY p.category ORDER BY  p.pr_id DESC";
                    $category_list_result = mysqli_query($conn, $category_list_query);

                    if (mysqli_num_rows($category_list_result) > 0) {
                        while ($category = mysqli_fetch_array($category_list_result)) { ?>

                            <button class="btn btn-sm btn-info category-filter" data-category="<?php echo strtolower($category['category']) ?>"><?= $category['category'] ?></button>

                    <?php
                        }
                    }
                    ?>

                </div>
                <div class="search-box">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Product">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive" style="overflow-x: scroll; max-height: 500px; ">
                        <div class="card-container">
                            <?php
                            include '../config/connect.php';

                            $product_list_query = "SELECT  p.pr_id as pr_id, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, 
    i.in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
    FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30 AND i.remarks = 'ACTIVE'  ORDER BY  i.date_created_at DESC";
                            $product_list_result = mysqli_query($conn, $product_list_query);

                            if (mysqli_num_rows($product_list_result) > 0) {
                                while ($product = mysqli_fetch_array($product_list_result)) {
                                    $inventory_list_query = "SELECT * FROM `inventory` WHERE `pr_id` = " . $product['pr_id'] . "  ORDER BY `pr_id` DESC";
                                    $inventory_list_result = mysqli_query($conn, $inventory_list_query);

                                    $row = mysqli_fetch_array($inventory_list_result);
                            ?>
                                    <div class="card-items <?= strtolower($product['category']) ?>" id="colorButton<?php echo $product["pr_id"]; ?>" data-name="<?= strtolower($product['item_code']) ?>" style="position: relative;">
                                        <?php
                                        $image = $product["image"];

                                        if (is_array($product)) { ?>
                                            <?php if (empty($product['image'])) { ?>
                                                <img src="../assets/images/default_images/product.jpg" title="Product Image" alt="Product Image" class="card-img">
                                            <?php } else { ?>
                                                <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $image; ?>" alt="Product Image" class="card-img mb-4">
                                        <?php }
                                        } ?>

                                        <div class="product-name mt-5 mb-3 ml-2 mr-2" style="position: absolute; top: 185px; left: 0; float: left; width: 100%; font-size: 12px; text-align: left; "><?= $item_code = substr_replace($product['item_code'], "", 9, 0) ?></div>

                                        <div class="item-code" style="position: relative; margin-top: 60px; font-size: 12px; "><?= $product['item_code'] ?></div>

                                        <div class="description mt-4 mb-3 ml-2 mr-2">
                                            <?= $product['description'] ?>
                                        </div>

                                        <div class="round1" style="margin: 0 !important; padding: 0 !important; ">
                                            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal<?php echo $product["pr_id"] ?>" style="margin: 0 !important; background: transparent;"><i class="mdi mdi-arrow-expand" style="position: absolute; text-align: right; float: right; color: #000; font-size: 12px; background: transparent;  top: 340px; right: 10px;"></i></button>
                                        </div>

                                        <div class="price-quantity" style="position: relative; margin-top: 60px; font-size: 12px; ">
                                            <div class="mt-1">Price: <b><?= $product['sell_price'] ?></b></div>

                                            <input type="hidden" id="pr_id_<?= $product['pr_id'] ?>" value="<?= $product['pr_id'] ?>">
                                            <input type="hidden" id="item_code_<?= $product['pr_id'] ?>" value="<?= $product['item_code'] ?>">
                                            <input type="hidden" id="price_<?= $product['pr_id'] ?>" value="<?= $product['sell_price'] ?>" onchange="updateFields(<?= $product['pr_id'] ?>)">

                                            <div>QTY: <input type="text" value="1" class="quantity" id="quantity_<?= $product['pr_id'] ?>" onchange="updateFields(<?= $product['pr_id'] ?>)"></div>
                                        </div>

                                        <button class="btn-bottom mt-3 card-button" onclick="createRow(<?= $product['pr_id'] ?>)"></button>

                                    </div>



                                    <!-- Modal -->
                                    <div class="modal fade pb-5" id="exampleModal<?php echo $product["pr_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">View Product Image</h5>
                                                    <button type="button" class="close mr-1" style="padding-top: 22px;" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-5">
                                                        <?php
                                                        if (is_array($product)) { ?>
                                                            <?php if (empty($product['image'])) { ?>
                                                                <img src="../assets/images/default_images/product.jpg" title="product">
                                                            <?php } else { ?>
                                                                <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $product["item_code"]; ?>" style="  width: 100%;height: auto; display: block; margin: 0 auto; max-height: 80vh; width: 540px !important; height: 450px;">
                                                        <?php }
                                                        } ?>
                                                    </div>
                                                    <div class="product-name mt-3 mb-2 ml-2 mr-2"><?= $product['item_code'] ?></div>
                                                    <div class="item-code mt-3 mb-2 ml-2 mr-2"><?= $product["manufacturing_date"] ? $product["manufacturing_date"] : '0000-00-00' ?></div>

                                                    <div class="mt-4 mb-2 ml-2 mr-2">
                                                        <?= $product['description'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        document.getElementById("image<?php echo $product["pr_id"] ?>").onchange = function() {
                                            document.getElementById("form<?php echo $product["pr_id"] ?>").submit();
                                        };
                                    </script>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var button = document.getElementById('colorButton<?php echo $product["pr_id"] ?>');



                                            button.addEventListener('click', function() {
                                                if (!button.classList.contains('blue')) {
                                                    button.classList.add('blue');
                                                }
                                            });


                                        });
                                    </script>

                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-container">
                        <h2 class="form-title">A D D &nbsp;&nbsp;&nbsp; I T E M</h2>
                        <form id="addSale">

                            <div class="input-row">
                                <input type="text" class="form-control green" value="Item Code" readonly="true">
                                <input type="text" class="form-control" value="Price" readonly="true">
                                <input type="text" class="form-control" value="Quantity" readonly="true">
                                <input type="text" class="form-control" value="TOTAL" readonly="true">
                                <button type="button" class="btn btn-remove">ACTION</button>
                            </div>
                            <div id="container">
                            </div>
                            <button type="submit" class="btn btn-primary card-proceed"> Proceed</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    <div class="form-container">
                        <div class="total-sum">
                            <label class="form-title-sum">Total Sum: </label>
                            <input type="text" id="totalSum" readonly>
                            <button class="btn btn-info" id="insertButton" onclick="resetForm()">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php include "../include/user_footer.php"; ?>
    </div>
</div>


<script>
    // JavaScript for filtering products by category
    document.addEventListener('DOMContentLoaded', function() {
        const categoryButtons = document.querySelectorAll('.category-filter');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = button.getAttribute('data-category');

                // Hide all products
                const products = document.querySelectorAll('.card-items');
                products.forEach(product => {
                    product.style.display = 'none';
                });

                // Show products of selected category or show all if 'all' is selected
                if (category === 'all') {
                    products.forEach(product => {
                        product.style.display = 'block';
                    });
                } else {
                    const selectedProducts = document.querySelectorAll(`.card-items.${category}`);
                    selectedProducts.forEach(product => {
                        product.style.display = 'block';
                    });
                }
            });
        });

        // JavaScript for filtering products by search input
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();
            const products = document.querySelectorAll('.card-items');

            products.forEach(product => {
                const productName = product.getAttribute('data-name');
                if (productName.includes(searchValue)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
</script>