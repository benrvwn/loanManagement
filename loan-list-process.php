<?php
session_start();
require_once("controller/database.php");
ob_start();

function loan_list($query){
    global $conn;
    $result = $conn->query($query);
            $data = array();
            while($row = mysqli_fetch_assoc($result)){
                $data[] = $row;
            }

            foreach($data as $row){
        ?>      <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['lender_name'] ?></td>
                    <td><?= $row['loan_amount'] ?></td>
                    <td><?= $row['scheduled_no_payments'] ?></td>
                    <td><?= $row['scheduled_payment']  ?></td>
                    <td><?= $row['actual_no_payments'] ?></td>
                    <td><?= $row['total_early_payments'] ?></td>
                    <td><?= $row['total_interest'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><button id="pay" class="btn btn-success"><i class="bi bi-hand-thumbs-up"></i></button><button id="delete" class="btn btn-danger"><i class="bi bi-trash"></i></button></td>
                </tr>
        <?php
            }
}

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $userId = $_SESSION['user']['id'];
    $query = "SELECT * FROM loans WHERE user_id = {$userId}";
    loan_list($query);
    $content = ob_get_clean();
    echo $content;
}
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    switch ($_POST['use']){
        //---------------SEARCH-----------------------//
        case 'search': 
            $input = $_POST['input'];
            $query = "SELECT * FROM loans WHERE lender_name LIKE '%{$input}%'";
            loan_list($query);
            $content = ob_get_clean();
            echo $content;
            break;
        //---------------PAID-----------------------//
        case 'pay':
            $id = $_POST['input'];
            $conn->query("UPDATE loans SET status = 'Paid' WHERE id = {$id}");
            echo 'Succeeded!';
            break;
        //---------------DELETE-----------------------//
        case 'remove':
            $id = $_POST['input'];
            if($conn->query("DELETE FROM loans WHERE id = {$id}") === TRUE){
                if($conn->query("DELETE FROM loan_schedule WHERE loan_id = {$id}")){
                    echo 'Succeeded!';
                }
            }else{
                echo 'Failed!';
            }
            break;
        default:
            $rowData = $_POST['rowData'];
            $result = $conn->query("SELECT * FROM loan_schedule WHERE loan_id = {$rowData}");
            $data = array();
            while($row = mysqli_fetch_assoc($result)){
                $data[] = $row;
            }

            foreach($data as $row){
        ?>      <tr>
                    <td><?= $row['pmt_no'] ?></td>
                    <td><?= $row['payment_date'] ?></td>
                    <td><?= $row['beginning_balance'] ?></td>
                    <td><?= $row['scheduled_payment'] ?></td>
                    <td><?= $row['xtra_payment'] ?></td>
                    <td><?= $row['total_payment'] ?></td>
                    <td><?= $row['principal'] ?></td>
                    <td><?= $row['interest'] ?></td>
                    <td><?= $row['ending_balance'] ?></td>
                    <td><?= $row['cumulative_interest'] ?></td>
                </tr>
        <?php
            }
            $content = ob_get_clean();

            echo $content;
    }




}
?>