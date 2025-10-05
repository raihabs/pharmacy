<table class="table" id="table">
    <thead>
        <tr>
            <th>Item Code</th>
            <!-- <th>Quantity</th> -->
            <th>OVERALL TOTAL</th>
            <th>STATUS</th>
            <th>Date Created</th>
            <th>Time Created</th>
            <th>Name</th>
            <th>ID Number</th>
            <th>Address</th>
            <th>Discount Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


        <?php
        include '../config/connect.php';


        $product_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.item_code as item_code, p.category,  p.image, s.sales_code,s.pr_id, s.sell_price, s.quantity, SUM(s.quantity) AS total_quantity,  s.total as total, SUM(s.total) AS total_orders, s.full_name , s.id_number , s.address , s.discount , s.status , s.created_by, s.updated_by, s.date_created_at, s.date_updated_at
    FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE sa_id != '' GROUP BY s.sales_code ORDER BY s.sa_id DESC;";
        $product_list_result = mysqli_query($conn, $product_list_query);

        if (mysqli_num_rows($product_list_result) > 0) {
            while ($product = mysqli_fetch_array($product_list_result)) {

        ?>



                <tr>
                    <!-- <td><?= $product["pr_id"] ? $product["pr_id"] : '' ?></td> -->

                    <td>
                        <?php
                        $item_code_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.item_code as item_code, 
                         p.category,  p.image, s.pr_id, s.sell_price, s.status, s.total as total, 
                        s.created_by, s.updated_by, s.date_created_at, s.date_updated_at
                        FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE s.sales_code = '" . $product["sales_code"] . "' ORDER BY s.sales_code DESC";
                        $item_code_list_result = mysqli_query($conn, $item_code_list_query);

                        if (mysqli_num_rows($item_code_list_result) > 0) {
                            while ($item = mysqli_fetch_array($item_code_list_result)) { 
                              ?>
                                <?php echo $item["item_code"] ?>
                        <?php   }
                        }
                        ?>
                    </td>
                    <!-- <td>₱<?= "₱" . $product["sell_price"] ? $product["sell_price"] : '' ?> </td> -->
                    <!-- <td><?= $product["total_quantity"] ? $product["total_quantity"] : '' ?> PCS </td> -->

                    <td><?= "₱" .  $product['total_orders'] ? "₱" .  $product['total_orders']  : ''  ?></td>

                    <!-- 
                    <?php if ($product["full_name"] == '' && $product["id_number"] == '' && $product["address"] == '') { ?>
                        <td><?= "₱" . $product["sell_price"] * $product["total_quantity"]  ?></td>
                    <?php } else { ?> 
                        <td><?= "₱" . ($product["sell_price"] * $product["total_quantity"]) * 0.93 ?></td>
                    <?php } ?> -->


                    <td><?= $product["status"] ? $product["status"] : $product["status"]  ?></td>

                    <td><?= date("Y-m-d", strtotime($product["date_created_at"])) ? date("Y-m-d", strtotime($product["date_created_at"])) : '0000-00-00 00:00:00' ?></td>
                    <td><?= date("g:i:s", strtotime($product["date_created_at"])) ? date("g:i:s", strtotime($product["date_created_at"])) : '0000-00-00 00:00:00' ?></td>

                    <td><?= $product["full_name"] ? $product["full_name"] : $product["full_name"]  ?></td>
                    <td><?= $product["id_number"] ? $product["id_number"] : $product["id_number"]  ?></td>
                    <td><?= $product["address"] ? $product["address"] : $product["address"]  ?></td>
                    <td>

                        <?php if ($product["discount"] == 'Senior') {
                            echo "Senior";
                        } else if ($product["discount"] == 'PWD') {
                            echo "PWD";
                        } else {
                            echo "NO DISCOUNT";
                        }
                        ?>
                    </td>

                    <td>
                        <div class="action">
                            <form id="updSales">
                                <?php
                                $item_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.item_code as item_code, 
                        p.category,  p.image, s.pr_id, s.sell_price, s.quantity, s.status, 
                        s.date_created_at, s.date_updated_at
                        FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE s.sales_code = '" . $product["sales_code"] . "' ORDER BY s.date_created_at DESC";
                                $item_list_result = mysqli_query($conn, $item_list_query);

                                if (mysqli_num_rows($item_list_result) > 0) {
                                    while ($list = mysqli_fetch_array($item_list_result)) { ?>
                                        <input type="hidden" name="pr_id[]" value="<?= $list["pr_id"] ? $list["pr_id"] : '' ?>">
                                        <input type="hidden" name="quantity[]" value="<?= $list["quantity"] ? $list["quantity"] : '1' ?>">
                                        <input type="hidden" name="date_created_at[]" value="<?= $list["date_created_at"] ? $list["date_created_at"] : '' ?>">

                                        <?php
                                        if ($list['status'] == "RELEASED") { ?>
                                            <input type="hidden" name="status[]" value="REFUND">
                                        <?php } else { ?>
                                            <!-- <input type="hidden" name="status[]" value="RELEASED"> -->
                                        <?php }
                                        ?>
                                        <input type="hidden" name="user_id[]" value="<?= $sessionId ?>">

                                <?php
                                    }
                                }
                                ?>


                                <!-- <div class="row"> -->
                                    <!-- <div class="col-6"> -->
                                    <!-- <?php
                                    if ($product['status'] == 'RELEASED') { ?>
                                        <button type="submit" class="btn btn-primary"> REFUND </button>
                                    <?php } else { ?>
                                        <button class="btn btn-info"> RELEASE </button>
                                    <?php }
                                    ?> -->
                                    <!-- </div> -->
                                    <!-- <div class="col-12">
                                    </div> -->
                                <!-- </div> -->
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal<?php echo $product["pr_id"]; ?>">VIEW</button>

                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal<?php echo $product["pr_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">View Product Image</h5>
                                <button type="button" class="close mr-1" style="padding-top: 22px;" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <div class="card-container">
                                        <?php
                                        include '../config/connect.php';

                                        $show_list_query = "SELECT s.sa_id, p.pr_id as pr_id, 
                                        p.item_code as item_code, 
                                        p.category, p.description,  p.image, s.sales_code, 
                                        s.pr_id, s.sell_price, 
                                        s.quantity, s.total , s.status, s.created_by, s.updated_by, s.date_created_at, s.date_updated_at
                                        FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE sa_id != '' 
                                        AND  s.sales_code = '" . $product["sales_code"] . "' 
                                        ORDER BY s.sales_code DESC";

                                        $show_list_result = mysqli_query($conn, $show_list_query);

                                        if (mysqli_num_rows($show_list_result) > 0) {
                                            while ($show = mysqli_fetch_array($show_list_result)) { ?>
                                                <div class="card-items <?= strtolower($show['category']) ?>" data-name="<?= strtolower($show['item_code']) ?>">
                                                    <?php
                                                    $image = $show["image"];

                                                    if (is_array($show)) { ?>
                                                        <?php if (empty($show['image'])) { ?>
                                                            <img src="../assets/images/default_images/product.jpg" title="Product Image" alt="Product Image" class="card-img">
                                                        <?php } else { ?>
                                                            <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $image; ?>" alt="Product Image" class="card-img">
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                    <div class="product-name ml-2 mr-2"><?= $item_code = substr_replace($show['item_code'], "", 9, 0) ?></div>
                                                    <div class="item-code mt-2 ml-2 mr-2"><?= $show['item_code'] ?></div>
                                                    <div class="description mt-3 ml-2 mr-2">
                                                        <?= $show['description'] ?>
                                                    </div>
                                                    <div class="price-quantity mt-4 ml-2 mr-2">
                                                        <div class="mt-1">Price: <b><?= $show['sell_price'] ?></b></div>

                                                        <div>QTY: <input type="text" value="<?= $show['quantity'] ?>" class="quantity" style="border: none;"></div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </tbody>
</table>