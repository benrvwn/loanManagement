<?php
session_start();
require_once('controller/database.php');

$id = $_SESSION['user']['id'];

$result = $conn->query("select sum(loan_amount) as total_loaned, count(id) as numOfloans, sum(total_interest) as earnings, count(status = 'Paid') as paid, count(status = 'Ongoing') as ongoing from loans where user_id = {$id}");
$data = mysqli_fetch_assoc($result);

header("content-type: application/json");
echo json_encode($data);


?>