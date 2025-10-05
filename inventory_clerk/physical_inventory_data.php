        <form id="updPhysicalInventory">

            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Images</th>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Stock On Hand</th>
                        <th>Expiration Date</th>
                        <th>Comments</th>
                        <th>REMARKS</th>
                    </tr>
                </thead>
                <tbody>


                    <?php

                    $product_list_query = "SELECT  p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
                    i.in_id as in_id, i.item_code as item_code, i.quantity, i.pi_quantity, i.expiration_date, i.comment, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
                    FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC ";
                    $product_list_result = mysqli_query($conn, $product_list_query);

                    if (mysqli_num_rows($product_list_result) > 0) {
                        while ($product = mysqli_fetch_array($product_list_result)) {

                    ?>
                            <tr>
                                <input type="hidden" name="pr_id[]" placeholder="ID" value="<?= $product["pr_id"] ? $product["pr_id"] : '' ?>" class="input-field">
                                <input type="hidden" name="item_code[]" placeholder="Item Code" value="<?= $product["item_code"] ? $product["item_code"] : '' ?>" class="input-field">
                                <td>
                                    <div class="profile-image">
                                        <form class="form" id="form<?php echo $product["pr_id"] ?>">
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
                                                    <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal<?php echo $product["pr_id"] ?>" style="margin-right: 15px; background: transparent;"><i class="mdi mdi-arrow-expand" style="color: #000; font-size: 20px; right: 15px; background: transparent;"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </td>
                                <td><?php echo $product["item_code"] ?></td>
                                <td><?= $product["description"] ?></td>
                                
                                <input type="hidden" id="quantity<?php echo $product["pr_id"] ?>" name="quantity[]" placeholder="Quantity" value="<?= $product["quantity"] ? $product["quantity"] : '0' ?>" class="input-field">
                                <td><input type="text" id="phquantity<?php echo $product["pr_id"] ?>" name="phquantity[]" placeholder="Quantity" value="<?= $product["pi_quantity"] ? $product["pi_quantity"] : '0' ?>" class="input-field"></td>
                                <td><input type="date" id="phexpiration_date<?php echo $product["pr_id"] ?>" name="phexpiration_date[]" placeholder="Expiraiton Date" value="<?= $product["expiration_date"] ? $product["expiration_date"] : '0' ?>" class="input-field"></td>
                                <td><input type="text" id="phcomments<?php echo $product["pr_id"] ?>" name="phcomments[]" placeholder="comments" value="<?php echo $product["comment"] ? $product["comment"] : '' ?>" class="input-field" ></td>
                                <td><input type="text" id="phremarks<?php echo $product["pr_id"] ?>" name="phremarks[]" placeholder="remarks" value="<?php echo $product["remarks"] ? $product["remarks"] : '' ?>" class="input-field badge-info" style="text-align: center; color: white;"></td>

                            </tr>

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
                                document.getElementById("image<?php echo $product["pr_id"] ?>").onchange = function() {
                                    document.getElementById("form<?php echo $product["pr_id"] ?>").submit();
                                };
                            </script>

                    <?php
                        }
                    }
                    ?>


                </tbody>
            </table>

            <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                Submit
            </button>
        </form>