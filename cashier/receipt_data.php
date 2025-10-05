<table class="table" id="table">
    <thead>
        <tr>
            <th>Receipt Number</th>
            <th>Item Code</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Total Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>


        <?php
        include '../config/connect.php';


        $change_list_query = "SELECT *  FROM receipt ORDER BY re_id DESC;";
        $change_list_result = mysqli_query($conn, $change_list_query);

        if (mysqli_num_rows($change_list_result) > 0) {
            while ($change = mysqli_fetch_array($change_list_result)) {

        ?>
                <tr>
                   
                    <td><?=  $change["sales_code"] ?  $change["sales_code"]  : ''  ?></td>
                    <td><?=  $change["item_code"] ?  $change["item_code"]  : ''  ?></td>

                    <td><?= $change["description"] ?  $change["description"]  : ''  ?></td>

                    <td><?= $change["quantity"] ?  $change["quantity"]  : ''  ?></td>
                    <td><?= $change["total_amount"] ?  $change["total_amount"]  : ''  ?></td>
                    <td><?= $change["status"] ?  $change["status"]  : ''  ?></td>
                  
                  
                </tr>

           
        <?php
            }
        }
        ?>
    </tbody>
</table>