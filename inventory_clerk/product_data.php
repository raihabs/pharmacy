<table class="table" id="table">
    <thead>
        <tr>
            <th>Images</th>
            <th>Item Code</th>
            <th>Description</th>
            <th>Category</th>
            <th>Material Cost</th>
            <th>Sell Price</th>
            <th>Manufacturing Date</th>
            <th>Quantity</th>
            <th>Expiration Date</th>
            <th>Created By</th>
            <th>Updated By</th>
            <th>Date Created At</th>
            <th>Date Updated At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../config/connect.php';

        $product_list_query = "SELECT * FROM `product` ORDER BY pr_id DESC";
        $product_list_result = mysqli_query($conn, $product_list_query);


        if (mysqli_num_rows($product_list_result) > 0) {
            while ($row = mysqli_fetch_array($product_list_result)) { ?>
                <tr>
                    <td>
                        <div class="profile-image">
                            <form class="form" id="form<?php echo $row["pr_id"] ?>" action="" enctype="multipart/form-data" method="post">
                                <div class="upload">
                                    <?php
                                    $id = $row["pr_id"];
                                    $name = $row["item_code"];
                                    $image = $row["image"];

                                    if (is_array($row)) { ?>
                                        <?php if (empty($row['image'])) { ?>
                                            <img src="../assets/images/default_images/product.jpg" width=200 height=200 title="profile">
                                        <?php } else { ?>
                                            <img src="../assets/images/product_images/<?php echo $image; ?>" width=200 height=200 title="<?php echo $image; ?>">
                                    <?php }
                                    }
                                    ?>
                                    <div class="round">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="name" value="<?php echo $name; ?>">
                                        <input type="file" name="image" id="image<?php echo $row["pr_id"] ?>" accept=".jpg, .jpeg, .png">
                                    </div>
                                    <div class="round1">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal<?php echo $row["pr_id"] ?>" style="margin-right: 15px; background: transparent;"><i class="mdi mdi-arrow-expand" style="color: #000; font-size: 20px; right: 15px; background: transparent;"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </td>
                    <td><?php echo $row["item_code"] ?></td>
                    <td><?php echo $row["description"] ?></td>
                    <td><?php echo $row["category"] ?></td>
                    <td><?php echo "₱" . $row["material_cost"] ?></td>
                    <td><?php echo "₱" . $row["sell_price"] ?></td>
                    <td><?= $row["manufacturing_date"] ? $row["manufacturing_date"] : '0000-00-00' ?></td>
                    <td><?= $row["p_quantity"] ? $row["p_quantity"] : '0' ?></td>
                    <td><?= $row["expiration_date"] ? $row["expiration_date"] : '0000-00-00' ?></td>

                    <?php
                    $user_creator_list_query = "SELECT * FROM `user` WHERE `user_id` = '" . $row["created_by"] . "' ORDER BY `user_id` DESC";
                    $user_creator_list_result = mysqli_query($conn, $user_creator_list_query);
                    $user_creator = mysqli_fetch_array($user_creator_list_result);

                    $user_modifier_list_query = "SELECT * FROM `user` WHERE `user_id` = '" . $row["updated_by"] . "' ORDER BY `user_id` DESC";
                    $user_modifier_list_result = mysqli_query($conn, $user_modifier_list_query);
                    $user_modifier = mysqli_fetch_array($user_modifier_list_result);
                    ?>

                    <td><?php echo $user_creator["firstname"] . " " . $user_creator["lastname"] ?></td>
                    <td><?php echo $user_modifier["firstname"] . " " . $user_modifier["lastname"] ?></td>


                    <td><?= $row["date_created_at"] ? $row["date_created_at"] : '0000-00-00 00:00:00' ?></td>
                    <td><?= $row["date_updated_at"] ? $row["date_updated_at"] : '0000-00-00 00:00:00' ?></td>
                    <td>
                        <div class="action">
                            <button class="btn btn-info btn-sm m-b-10 product_edit button1" data-bs-toggle="modal" data-bs-target="#updateUserProduct" value="<?= $row['pr_id']; ?>" data-role="update" id="<?php echo $row['pr_id']; ?>" style="background-color: #DAA520; border-style: solid; border-color: #000;  border-color: #6c8cc4;"><i class='mdi mdi-pencil' style="color: #fff; font-size: 20px;"></i></button>&nbsp;&nbsp;&nbsp;
                        </div>
                    </td>
                </tr>



                <!-- Modal -->
                <div class="modal fade pb-5" id="exampleModal<?php echo $row["pr_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
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
                                    if (is_array($row)) { ?>
                                        <?php if (empty($row['image'])) { ?>
                                            <img src="../assets/images/default_images/product.jpg" title="product">
                                        <?php } else { ?>
                                            <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $row["item_code"]; ?>" style="  width: 100%;height: auto;display: block;margin: 0 auto;max-height: 80vh; width: 540px !important; height: 450px;">
                                    <?php }
                                    } ?>
                                </div>
                                <div class="product-name mt-3 mb-2 ml-2 mr-2"><?= $row['item_code'] ?></div>
                                <div class="item-code mt-3 mb-2 ml-2 mr-2"><?= $row["manufacturing_date"] ? $row["manufacturing_date"] : '0000-00-00' ?></div>

                                <div class="mt-4 ml-2 mr-2">
                                    <?= $row['description'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    document.getElementById("image<?php echo $row["pr_id"] ?>").onchange = function() {
                        document.getElementById("form<?php echo $row["pr_id"] ?>").submit();
                    };
                </script>
        <?php
            }
        }
        ?>
    </tbody>
</table>