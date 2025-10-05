<table class="table" id="table">
    <thead>
        <tr>
            <th>Images</th>
            <th>Item Code</th>
            <th>Category</th>
            <th>Material Cost</th>
            <th>Sell Price</th>
            <th>manufacturing Date</th>
            <th>Quantity</th>
            <th>Expiration Date</th>
            <th>REMARKS</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Date Created At</th>
            <th>Date Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $product_list_query = "SELECT  p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
    i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
    FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30  AND i.remarks = 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
        $product_list_result = mysqli_query($conn, $product_list_query);

        if (mysqli_num_rows($product_list_result) > 0) {
            while ($product = mysqli_fetch_array($product_list_result)) {

        ?>
                <tr>
                    <!-- <td><?= $product["in_id"] ? $product["in_id"] : '' ?></td> -->
                    <td>
                        <div class="profile-image">
                            <form class="form" id="form<?php echo $product["in_id"] ?>">
                                <div class="upload">
                                    <?php
                                    $image = $product["image"];

                                    if (is_array($product)) { ?>
                                        <?php if (empty($product['image'])) { ?>
                                            <img src="../assets/images/default_images/product.jpg" width=200 height=200 title="profile">
                                        <?php } else { ?>
                                            <img src="../assets/images/product_images/<?php echo $image; ?>" width=200 height=200 title="<?php echo $image; ?>">
                                    <?php }
                                    } ?>
                                    <div class="round1">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal<?php echo $product["in_id"] ?>" style="margin-right: 15px; background: transparent;"><i class="mdi mdi-arrow-expand" style="color: #000; font-size: 20px; right: 15px; background: transparent;"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </td>
                    <td><?php echo $product["item_code"] ?></td>
                    <td><?= $product["category"] ?></td>
                    <td><?= "₱" . $product["material_cost"] ?></td>
                    <td><?= "₱" . $product["sell_price"] ?></td>
                    <td><?= $product["manufacturing_date"] ? $product["manufacturing_date"] : '0000-00-00' ?></td>
                    <td><?= $product["quantity"] ? $product["quantity"] : '0' ?></td>
                    <td><?= $product["expiration_date"] ? $product["expiration_date"] : '0000-00-00' ?></td>
                    <?php
                    // Determine remarks
                    if ($product["remarks"] == 'NO QUANTITY') {
                        $remarks = 'NO QUANTITY';
                        $color = 'red';
                    } else if ($product["remarks"] == 'LOW QUANTITY') {
                        $remarks = 'LOW QUANTITY';
                        $color = 'orange';
                    } else if ($product["remarks"] == 'EXPIRED') {
                        $remarks = 'EXPIRED';
                        $color = 'gray';
                    } else if ($product["remarks"] == 'EXPIRE SOON') {
                        $remarks = 'EXPIRE SOON';
                        $color = 'yellow green';
                    } else {
                        $remarks = 'ACTIVE';
                        $color = 'green';
                    }
                    ?>

                    <td>
                        <div style='display: flex; justify-content: center; margin: 0 auto; align-items: center; width: 150px; font-size: 12px; padding: 10px; color: white; background-color: <?php echo $color ?>; border-radius: 15px; text-align: center;'><?php echo $remarks; ?></div>
                    </td>
                    <?php
                    $user_creator_list_query = "SELECT * FROM `user` WHERE `user_id` = '" . $product["created_by"] . "' ORDER BY `user_id` DESC";
                    $user_creator_list_result = mysqli_query($conn, $user_creator_list_query);
                    $user_creator = mysqli_fetch_array($user_creator_list_result);

                    $user_modifier_list_query = "SELECT * FROM `user` WHERE `user_id` = '" . $product["updated_by"] . "' ORDER BY `user_id` DESC";
                    $user_modifier_list_result = mysqli_query($conn, $user_modifier_list_query);
                    $user_modifier = mysqli_fetch_array($user_modifier_list_result);
                    ?>

                    <td><?php echo $user_creator["firstname"] . " " . $user_creator["lastname"] ?></td>
                    <td><?php echo $user_modifier["firstname"] . " " . $user_modifier["lastname"] ?></td>


                    <td><?= $product["date_created_at"] ? $product["date_created_at"] : '0000-00-00 00:00:00' ?></td>
                    <td><?= $product["date_updated_at"] ? $product["date_updated_at"] : '0000-00-00 00:00:00' ?></td>
                    <td>
                        <div class="action">
                            <button class="btn btn-info btn-sm m-b-10 inventory_edit button1" data-bs-toggle="modal" data-bs-target="#updateUserInventory" value="<?= $product['in_id']; ?>" data-role="update" id="<?php echo $product['in_id']; ?>" style="background-color: #DAA520; border-style: solid; border-color: #000;  border-color: #6c8cc4;"><i class='mdi mdi-pencil' style="color: #fff; font-size: 20px;"></i></button>&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade pb-5" id="exampleModal<?php echo $product["in_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
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
                                            <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $product["item_code"]; ?>" style="  width: 100%;height: auto;display: block;margin: 0 auto;max-height: 80vh; width: 540px !important; height: 450px;">
                                    <?php }
                                    } ?>
                                </div>
                                <div class="product-name mt-3 mb-2 ml-2 mr-2"><?= $product['item_code'] ?></div>
                                <div class="item-code mt-3 mb-2 ml-2 mr-2"><?= $product["manufacturing_date"] ? $product["manufacturing_date"] : '0000-00-00'  ?></div>

                                <div class="mt-4 ml-2 mr-2">
                                    <?= $product['description'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    document.getElementById("image<?php echo $product["in_id"] ?>").onchange = function() {
                        document.getElementById("form<?php echo $product["in_id"] ?>").submit();
                    };
                </script>

        <?php
            }
        }
        ?>
    </tbody>
</table>