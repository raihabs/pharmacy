<table class="table" id="table">
    <thead>
        <tr>
            <th>Images</th>
            <th>Item Code</th>
            <th>Description</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Material Cost</th>
            <th>Sell Price</th>
            <th>Manufacturing Date</th>
            <th>Expiration Date</th>
            <th>Date Created</th>
            <th>Time Updated</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../config/connect.php';

        $product_list_query = "SELECT * FROM `product` WHERE `expiration_date` > NOW() ORDER BY pr_id DESC";
        $product_list_result = mysqli_query($conn, $product_list_query);


        if (mysqli_num_rows($product_list_result) > 0) {
            while ($row = mysqli_fetch_array($product_list_result)) {


                $today = new DateTime();

                $thirty_days_later = new DateTime('+30 days');

                // Convert expiration date string to a DateTime object        
                $date_to_check = new DateTime($row['expiration_date']);


                $quantity = $row['p_quantity'];
                if ($quantity >= 0 && $quantity <= 10  && $date_to_check > $thirty_days_later) {
                    $color = 'red';
                } else if ($quantity > 10 && $quantity <= 30  && $date_to_check > $thirty_days_later) {
                    $color = 'gray';
                } else {
                    $color = 'none';
                }
               
                
                
        ?>


                <tr style="background: <?php echo $color; ?> !important;">
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
                    <td><?= $row["p_quantity"] ? $row["p_quantity"] : '0' ?></td>
                    <td><?php echo "₱" . $row["material_cost"] ?></td>
                    <td><?php echo "₱" . $row["sell_price"] ?></td>
                    <td><?= $row["manufacturing_date"] ? $row["manufacturing_date"] : '0000-00-00' ?></td>
                    <td><?= $row["expiration_date"] ? $row["expiration_date"] : '0000-00-00' ?></td>

                    <td><?= date("Y-m-d", strtotime($row["date_created_at"])) ? date("Y-m-d", strtotime($row["date_created_at"])) : '0000-00-00 00:00:00' ?></td>
                    <td><?= date("g:i:s", strtotime($row["date_created_at"])) ? date("g:i:s", strtotime($row["date_created_at"])) : '0000-00-00 00:00:00' ?></td>
                    <!-- <td><?= $row["date_updated_at"] ? $row["date_updated_at"] : '0000-00-00 00:00:00' ?></td> -->
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