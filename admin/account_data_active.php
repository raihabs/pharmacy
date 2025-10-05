<table class="table" id="table_active">
    <thead>
        <tr>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Birthday</th>
            <th>Role</th>
            <th>Date Created</th>
            <th>Time Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php

        include '../config/connect.php';
        error_reporting(0);
        session_start();

        $id = $_SESSION["user_id_admin"];
        $sessionId = $id;
        $user_list_query = "SELECT * FROM `user` WHERE `user_id` != $sessionId && `status` = 'ACTIVE' ORDER BY `user_id` DESC";
        $user_list_result = mysqli_query($conn, $user_list_query);


        if (mysqli_num_rows($user_list_result) > 0) {
            while ($row = mysqli_fetch_array($user_list_result)) { ?>
                <tr>
                    <!-- <td><?php echo $row["user_id"] ?></td> -->
                    <td><?php echo $row["username"] ?></td>
                    <td><?php echo $row["firstname"] ?></td>
                    <td><?php echo $row["lastname"] ?></td>
                    <td><?php echo $row["email"] ?></td>
                    <td><?php echo $row["phone"] ?></td>
                    <td><?php echo $row["address"] ?></td>
                    <td><?php echo $row["birthday"] ?></td>
                    <td><?php echo $row["role"] ?></td>
                    <td><?= date("Y-m-d", strtotime($product["date_created_at"])) ? date("Y-m-d", strtotime($product["date_created_at"])) : '0000-00-00 00:00:00' ?></td>
                    <td><?= date("g:i:s", strtotime($product["date_created_at"])) ? date("g:i:s", strtotime($product["date_created_at"])) : '0000-00-00 00:00:00' ?></td>
                    <td>
                        <div class="action">
                            <button class="btn btn-dark btn-sm m-b-10 change_pass button1" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $row['user_id']; ?>" data-role="change_password" id="<?php echo $row['user_id']; ?>" style="background: #000; border-style: solid; border-color: #000;  border-color: #6c8cc4;"><i class='mdi mdi-lock' style="color: #fff; font-size: 20px;"></i></button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-info btn-sm m-b-10 account_edit button1" data-bs-toggle="modal" data-bs-target="#updateUserAccount" value="<?= $row['user_id']; ?>" data-role="update" id="<?php echo $row['user_id']; ?>" style="background-color: #DAA520; border-style: solid; border-color: #000;  border-color: #6c8cc4;"><i class='mdi mdi-pencil' style="color: #fff; font-size: 20px;"></i></button>&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-danger btn-sm m-b-10 account_delete1 button2" data-role="update" id="<?php echo $row['user_id']; ?>" style="background-color: #8B4513; border-color: red;"><i class='mdi mdi-archive' style="color: #fff; font-size: 20px;"></i></button>
                        </div>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>