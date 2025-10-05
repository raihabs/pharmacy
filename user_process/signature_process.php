<?php
include '../config/connect.php';
session_start();


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     echo "Form Submitted";
//     print_r($_POST); // Debugging purpose
//     print_r($_FILES); // Debugging purpose
// }
// var_dump(isset($_FILES["image"]["name"]));
if (isset($_FILES["image_signature"]["name"])) {

    $id = $_POST["id_signature"];
    $name = $_POST["name_signature"];

    $imageName = $_FILES["image_signature"]["name"];
    $imageSize = $_FILES["image_signature"]["size"];
    $tmpName = $_FILES["image_signature"]["tmp_name"];
    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) { ?>

        <script>
            Swal.fire({
                    icon: 'warning',
                    title: 'Something Went Wrong.',
                    text: 'Invalid Extensions, Use: JPG, JPEG, PNG, SVG',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/user_profile_settings.php';
                });
        </script>

    <?php } elseif ($imageSize > 1200000) { ?>

        <script>
            Swal.fire({
                    icon: 'warning',
                    title: 'Something Went Wrong.',
                    text: 'Please Dont Use High Image Size',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/user_profile_settings.php';
                });
        </script>

    <?php } else {

        // unlink($user["image"]);
        if (isset($_SESSION["user_id_admin"])) {
            $id = $_SESSION["user_id_admin"];
        } else if (isset($_SESSION["user_id_cashier"])) {
            $id = $_SESSION["user_id_cashier"];
        } else {
            $id = $_SESSION["user_id_inventory_clerk"];
        }
        $sessionId = $id;
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = $sessionId"));

        $user["signature"] = $user["signature"] ? $user["signature"] : 'profile.jpg';

        unlink('../assets/images/signature_images/' . $user["signature"]);

        $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name

        $newImageName = $newImageName . '.' . $imageExtension;
        $query = "UPDATE user  SET `signature` = '$newImageName' WHERE `user_id` = $id ";

        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/signature_images/' . $newImageName);

    ?>

        <script>
            Swal.fire({
                    icon: 'success',
                    title: 'SUCCESS',
                    text: 'Successfully Change Signature',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/user_profile_settings.php';
                });
        </script>

<?php  }
}

?>