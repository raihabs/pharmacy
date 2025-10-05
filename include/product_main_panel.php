<div class="main-panel">
  <div class="content-wrapper pb-0">

    <div class="page-header">
      <h3 class="page-title">Product Table</h3>
      <?php include "../include/user_breadcrumb.php"; ?>
      <div class="page-header flex-wrap">
        <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
        </h3>
        <div class="d-flex">
          <a href="../admin/product.php">
            <button type="button" class="btn btn-sm bg-white btn-icon-text border">
              <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
            </button>
          </a>
          <!-- <a href="../user_process/product_export.php">
            <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">
              <i class="mdi mdi-export btn-icon-prepend"></i>Export
            </button>
          </a> -->
          <button type="button" class="btn btn-sm bg-white btn-icon-text ml-3" onclick="printUserTable()">
            <i class="mdi mdi-print btn-icon-prepend"></i>Print
          </button>

          <!-- Hidden iframe that loads user_print.php -->
          <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe>

          <button type="button" class="btn btn-sm btn-info border ml-3" data-toggle="modal" data-target="#addUserProduct">
            Add Product
          </button>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>
              <p class="card-description"> </p>
              <div class="table-responsive">
                <?php include "../admin/product_data.php"; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <?php include "../include/user_footer.php"; ?>
  </div>

  <!-- Add Modal -->
  <div class="modal fade" id="addUserProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
          <h5 class="modal-title text-uppercase font-weight-bold ml-3" id="exampleModalLabel" style="color: #fff;">Add Product</h5>
          <button type="button" class="close mr-1" style="padding-top: 22px;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addProduct">
          <div class="modal-body ml-5 mr-5 mt-4">

          <div class="mb-4">
              <label for="content" style="margin: 0 16.8rem 0 0;">Item Code <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 15.5rem 0 0;">Brand Name <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content">Description <span style="color:red; font-size: 18px;">*</span></label>


              <div class="row">

                <div class="col-md-4">
                  <input type="text" id="item_code"  name="item_code" placeholder="Item Code" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="brand" name="brand" placeholder="Brand Name" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="description" name="description" placeholder="Description" class="form-control  form-control-lg" />
                </div>
              </div>

            </div>


            <div class="mb-5 mt-5">
              <label for="content" style="margin: 0 16.8rem 0 0;">Batch No. <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 15.5rem 0 0;">Lot No. <span style="color:red; font-size: 18px;">*</span></label>


              <div class="row">

                <div class="col-md-4">
                  <input type="text" id="batch_no"  name="batch_no" placeholder="Batch No" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="lot_no" name="lot_no" placeholder="Lot No" class="form-control  form-control-lg" />
                </div>
              </div>

            </div>

            <div class="mb-5 mt-5">
              <label for="content" style="margin: 0 17rem 0 0;">Category <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 17.5rem 0 0;">Quantity <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content">Material Cost <span style="color:red; font-size: 18px;">*</span></label>
              <div class="row">
                <div class="col-md-4">
                  <select id="category" name="category" class="form-control  form-control-lg">
                    <option value="Select Category Option">Select Category Option</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Capsule">Capsule</option>
                    <option value="Syrup">Syrup</option>
                    <option value="Drops">Drops</option>
                    <option value="Granule">Granule</option>
                    <option value="Suspension">Suspension</option>
                    <option value="Solution">Solution</option>
                    <option value="Cream">Cream</option>
                    <option value="Tube">Tube</option>
                    <option value="Gel">Gel</option>
                    <option value="Remedy">Remedy</option>
                  </select>
                  <!-- <input type="text" name="category" placeholder="Category" class="form-control form-control-lg" /> -->
                </div>
                <div class="col-md-4">
                  <input type="text" id="quantity"  name="quantity" placeholder="Quantity" class="form-control form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="material_cost"  name="material_cost" placeholder="Material Cost" class="form-control form-control-lg" />
                </div>
              </div>
            </div>

            <div class="mb-5">

              <label for="content" style="margin: 0 17.1rem 0 0;">Sell Price <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 11.9rem 0 0;">Manufacturing Date <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content">Expiration Date <span style="color:red; font-size: 18px;">*</span></label>

              <div class="row">
                <div class="col-md-4">
                  <input type="text" id="sell_price" name="sell_price" placeholder="Sell Price" class="form-control form-control-lg" />
                </div>

                <div class="col-md-4">
                  <input type="date" id="manufacturing_date" name="manufacturing_date" placeholder="Manufacturing Date" class="form-control form-control-lg" />
                </div>

                <div class="col-md-4">
                  <input type="date" id="expiration_date" name="expiration_date" placeholder="Expiration Date" class="form-control form-control-lg" />
                </div>
              </div>
            </div>



          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            <button class="btn btn-primary">Add</button>

          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- Update Modal -->
  <div class="modal fade" id="updateUserProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
          <h5 class="modal-title text-uppercase font-weight-bold ml-3" id="exampleModalLabel" style="color: #fff;">Update Product</h5>
          <button type="button" class="close mr-1" style="padding-top: 22px;" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="updProduct">
          <div class="modal-body ml-5 mr-5 mt-4">
            <input type="hidden" name="pr_id" id="updpr_id">

            <input type="hidden" id="upduser_id" name="user_id" value="<?= $sessionId ?>">

            <div class="mb-4">
              <label for="content" style="margin: 0 16.8rem 0 0;">Item Code <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 15.5rem 0 0;">Brand Name <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content">Description <span style="color:red; font-size: 18px;">*</span></label>

              <input type="hidden" name="upduser_id" value="<?= $sessionId ?>">

              <div class="row">

                <div class="col-md-4">
                  <input type="text" id="upditem_code" name="item_code" placeholder="Item Code" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="updbrand" name="brand" placeholder="Brand Name" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="upddescription" name="description" placeholder="Description" class="form-control  form-control-lg" />
                </div>
              </div>

            </div>

            <div class="mb-5 mt-5">
              <label for="content" style="margin: 0 16.8rem 0 0;">Batch No. <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 15.5rem 0 0;">Lot No. <span style="color:red; font-size: 18px;">*</span></label>


              <div class="row">

                <div class="col-md-4">
                  <input type="text" id="updbatch_no"  name="batch_no" placeholder="Batch No" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="updlot_no" name="lot_no" placeholder="Lot No" class="form-control  form-control-lg" />
                </div>
              </div>

            </div>
            <!-- <div class="mb-4">
              <label for="content">Product Information <span style="color:red; font-size: 18px;">*</span></label>

              <div class="row">
                <div class="col-md-4">
                  <input type="text" name="item_code" id="item_code" placeholder="Item Code" class="form-control  form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" name="description" id="description" placeholder="Description" class="form-control  form-control-lg" />
                </div>
              </div>
            </div> -->

            <div class="mb-5 mt-5">
              <label for="content" style="margin: 0 17rem 0 0;">Category <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 17.5rem 0 0;">Quantity <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content">Material Cost <span style="color:red; font-size: 18px;">*</span></label>
              <div class="row">
                <div class="col-md-4">
                  <select id="rcategory" name="category" class="form-control  form-control-lg">
                    <option value="Select Category Option">Select Category Option</option>
                    <option value="Tablet">Tablet</option>
                    <option value="Capsule">Capsule</option>
                    <option value="Syrup">Syrup</option>
                    <option value="Drops">Drops</option>
                    <option value="Granule">Granule</option>
                    <option value="Suspension">Suspension</option>
                    <option value="Solution">Solution</option>
                    <option value="Cream">Cream</option>
                    <option value="Tube">Tube</option>
                    <option value="Gel">Gel</option>
                    <option value="Remedy">Remedy</option>
                  </select>
                  <!-- <input type="text" name="category" placeholder="Category" class="form-control form-control-lg" /> -->
                </div>
                <div class="col-md-4">
                  <input type="text" id="updquantity" name="quantity" placeholder="Quantity" class="form-control form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" id="updmaterial_cost" name="material_cost" placeholder="Material Cost" class="form-control form-control-lg" />
                </div>
              </div>
            </div>


            <!-- <div class="mb-4">
              <div class="row">
                <div class="col-md-4">
                  <input type="text" name="category" id="category" placeholder="Category" class="form-control form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" name="brand" id="brand" placeholder="Brand" class="form-control  form-control-lg" />
                </div>
              </div>
            </div> -->

            <!-- <div class="mb-5">
              <div class="row">
                <div class="col-md-4">
                  <input type="text" name="material_cost" id="material_cost" placeholder="Material Cost" class="form-control form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="text" name="sell_price" id="sell_price" placeholder="Sell Price" class="form-control form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="date" name="manufacturing_date" id="manufacturing_date" placeholder="Manufacturing Date" class="form-control form-control-lg" />
                </div>
              </div>
            </div> -->


            <div class="mb-5">

              <label for="content" style="margin: 0 17.1rem 0 0;">Sell Price <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content" style="margin: 0 11.9rem 0 0;">Manufacturing Date <span style="color:red; font-size: 18px;">*</span></label>
              <label for="content">Expiration Date <span style="color:red; font-size: 18px;">*</span></label>

              <div class="row">
                <div class="col-md-4">
                  <input type="text" id="updsell_price" name="sell_price" placeholder="Sell Price" class="form-control form-control-lg" />
                </div>

                <div class="col-md-4">
                  <input type="date" id="updmanufacturing_date" name="manufacturing_date" placeholder="Manufacturing Date" class="form-control form-control-lg" />
                </div>

                <div class="col-md-4">
                  <input type="date" id="updexpiration_date" name="expiration_date" placeholder="Expiration Date" class="form-control form-control-lg" />
                </div>
              </div>
            </div>



            <!-- <div class="mb-4">
              <label for="content">Stock Information</label>
              <div class="row">
                <div class="col-md-4">
                  <input type="text" name="quantity" id="quantity" placeholder="Quantity" class="form-control form-control-lg" />
                </div>
                <div class="col-md-4">
                  <input type="date" name="expiration_date" id="expiration_date" placeholder="Expiration Date" class="form-control form-control-lg" />
                </div>
              </div>
            </div> -->

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-info">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>


</div>