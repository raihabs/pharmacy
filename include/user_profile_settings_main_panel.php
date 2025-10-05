<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Profile Settings</h3>
      <?php include "../include/user_breadcrumb.php"; ?>

      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-5 ">My Profile</h4>
              <div class="profile-info">
                <div class="d-flex align-items-center mb-50">
                  <div class="profile-image">
                    <form class="form" id="form" action="" enctype="multipart/form-data" method="post">
                      <div class="profile_upload">
                        <?php
                        $id = $user["user_id"];
                        $name = $user["firstname"];
                        $image = $user["image"];

                        if (is_array($user)) { ?>
                          <?php if (empty($user['image'])) { ?>
                            <img src="../assets/images/default_images/profile.jpg" width=160 height=160 title="profile">
                          <?php } else { ?>
                            <img src="../assets/images/user_images/<?php echo $image; ?>" width=160 height=160 title="<?php echo $image; ?>">
                        <?php }
                        } ?>
                        <div class="round mt-5 ">
                          <input type="hidden" name="id" value="<?php echo $id; ?>">
                          <input type="hidden" name="name" value="<?php echo $name; ?>">
                          <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                          <i class="fa fa-camera" style="color: #fff;"></i>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="profile-meta p-5 mt-5 ml-5">
                    <h5 class="text-bold text-dark mb-10"><?php echo $user['firstname'] . " " . $user['lastname']; ?></h5>
                    <p class="text-sm text-gray"><?php echo $user['username']; ?></p>
                  </div>
                </div>
              </div>

              <form class="forms-sample mt-5 " id="changePassword">
                <div class="form-group">
                  <input type="hidden" name="id" id="id" value="<?php echo $user['user_id'] ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Enter Current Password</label>
                  <input type="text" class="form-control" name="password" id="password" placeholder="Enter Current Password" />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Enter New Password</label>
                  <input type="text" class="form-control" name="newpassword1" id="newpassword1" placeholder="Enter New Password" style="border-top-left-radius: 50px; border-bottom-left-radius: 50px; border: 1px solid #ebedf2; font-family: 'Rubik', sans-serif; font-weight: 400;  font-size: 0.8125rem; height: auto; padding: 9px 11px; border-radius: 0px;" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm New Password</label>
                  <input type="text" class="form-control"   placeholder="Enter New Password" style="border-top-left-radius: 50px; border-bottom-left-radius: 50px; border: 1px solid #ebedf2; font-family: 'Rubik', sans-serif; font-weight: 400;  font-size: 0.8125rem; height: auto; padding: 9px 11px; border-radius: 0px;" />
                </div>
                <button type="submit" class="btn btn-primary mr-2"> Change Password </button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">My Other Information</h4>
              <form class="forms-sample" id="editInfo">
                <div class="form-group">
                  <input type="hidden" name="id" id="id" value="<?php echo $user['user_id'] ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername2">Username</label>
                  <input type="text" readonly class="form-control" name="username" id="username" placeholder="Enter New Username" value="<?php echo $user['firstname']; ?>" />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail2">First Name</label>
                  <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter New First Name" value="<?php echo $user['firstname']; ?>" />
                </div>
                <div class="form-group">
                  <label for="exampleInputMobile">Last Name</label>
                  <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter New Last Name" value="<?php echo $user['lastname']; ?>" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword2">Email</label>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Enter New Email" value="<?php echo $user['email']; ?>" />
                </div>
                <div class="form-group row">
                  <div class="col-3">
                    <label for="exampleInputConfirmPassword2">Phone Number</label>
                    <input type="text" class="form-control" readonly name="phone1" id="phone" placeholder="Use +63XXX.." value="+63" />
                  </div>
                  <div class="col-9">
                    <label for="exampleInputConfirmPassword2"> +63..</label>
                    <input type="text" class="form-control" name="phone2" id="phone" placeholder="XXXXXXXXXX" value="<?php echo $user['phone'] = substr_replace($user['phone'], "", 0, 3); ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputConfirmPassword2">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Enter New Address" value="<?php echo $user['address']; ?>" />
                </div>
                <div class="form-group">
                  <label for="exampleInputConfirmPassword2">Birthday</label>
                  <input type="text" class="form-control" name="birthday" id="birthday" placeholder="Enter New Birthday" value="<?php echo $user['birthday']; ?>" />
                </div>
                <button type="submit" class="btn btn-primary mr-2"> Submit Information </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">

        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">My signature</h4>
              <form class="signature" id="signature" action="" enctype="multipart/form-data" method="POST">
                <div class="upload_signature">
                  <?php
                  $id_signature = $user["user_id"];
                  $name_signature = $user["firstname"] . " " . $user["lastname"];
                  $image_signature = $user["signature"];

                  if (is_array($user)) { ?>
                    <?php if (empty($user['signature'])) { ?>
                      <img src="../assets/images/default_images/signature.png" width=160 height=160 title="profile" style="width: 400px; height: 250px; border-radius: 0; /* Remove border radius */">
                    <?php } else { ?>
                      <img src="../assets/images/signature_images/<?php echo $image_signature; ?>" width=160 height=160 title="<?php echo $image_signature; ?>"   style="width: 400px; height: 250px; border-radius: 0; /* Remove border radius */">
                  <?php }
                  } ?>
                  <div class="round_signature" style="position: absolute; bottom: 0; right: 0;  width: 400px; height: 250px; line-height: 250px; text-align: center;  overflow: hidden !important; ">
                    <input type="hidden" name="id_signature" value="<?php echo $id_signature; ?>">
                    <input type="hidden" name="name_signature" value="<?php echo $name_signature; ?>">
                    <input type="file" name="image_signature" id="image_signature" accept=".jpg, .jpeg, .png" style="position: absolute; transform: scale(2); opacity: 0; height: 68px; width: 78px; height: 76px; line-height: 43px; text-align: center; border-radius: 50%; overflow: hidden; left: 42px; top: 42px;">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
        document.getElementById("image_signature").onchange = function() {
            document.getElementById("signature").submit();
        };
    </script>


    <?php include "../include/user_footer.php"; ?>

  </div>

</div>
<!-- page-body-wrapper ends -->