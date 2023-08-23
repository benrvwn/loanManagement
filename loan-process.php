<?php
require("controller/database.php");
session_start();
ob_start();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    

    //-----COMMON PROCESS------//
    $payment = 1;
    $loan = $_POST['loanAmount'];
    $annualInterestRate = $_POST['annualInterestRate'] / 100;
    $loanPeriodInYears = $_POST['loanPeriodYears'];
    $noPaymentsPerYear = $_POST['noPaymentsPerYear'];
    $startDateLoan = new DateTime($_POST['startDateLoan']);
    $formattedDate = $startDateLoan->format("Y-m-d");
    $xtraPayments = $_POST['xtraPayments'];
    $lenderName = strtoupper($_POST['lenderName']);
    $beginningBalance = $loan;
    $cumuInterest = 0;
    $totalEarlyPayment = 0;

    //------convert the annual interest rate to monthly interest rate-----//
    $monthlyInterestRate = $annualInterestRate / $noPaymentsPerYear;
    $totalNoPayments = $loanPeriodInYears * $noPaymentsPerYear;
    $scheduledPayment = ($monthlyInterestRate * $loan) / (1 - (1 + $monthlyInterestRate) ** (-$totalNoPayments));
    $scheduledPayment = round($scheduledPayment, 2);

    //-------COMMON CALCULATION-------//
    $totalPayment = $scheduledPayment + $xtraPayments;
    $interest = $beginningBalance * $monthlyInterestRate;
    $principal = $totalPayment - $interest;
    $endBalance = $beginningBalance - $principal;
    $cumuInterest = $cumuInterest + $interest;
    $userId = $_SESSION['user']['id'];

    $conn->query("INSERT INTO loans(user_id, lender_name, loan_amount, status, created_at, updated_at)
                    VALUES({$userId}, '{$lenderName}', '{$loan}', 'Ongoing', now(), now())");
    $loanID = $conn->insert_id;
    $_SESSION['loanId'] = $loanID;

    while ($beginningBalance >= 0){
        $beginningBalance = round($beginningBalance, 2);
        $totalPayment = round($totalPayment, 2);
        $interest = round($interest, 2);
        $principal = round($principal, 2);
        $endBalance = round($endBalance, 2);
        $cumuInterest = round($cumuInterest, 2);

        if($beginningBalance < $scheduledPayment || $beginningBalance < $totalNoPayments){
            $xtraPayments = 0;
            $totalPayment = $beginningBalance;
            $principal = $totalPayment - $interest;
            $endBalance = 0;
        }

        $conn->query("INSERT INTO loan_schedule(pmt_no, loan_id, payment_date, beginning_balance, scheduled_payment, xtra_payment, total_payment, principal, interest, ending_balance, cumulative_interest)
                    VALUES('{$payment}', '{$loanID}', '{$formattedDate}', '{$beginningBalance}', '{$scheduledPayment}', '{$xtraPayments}', '{$totalPayment}', '{$principal}', '{$interest}', '{$endBalance}', '{$cumuInterest}')");
        
        if($endBalance == 0){
            $beginningBalance = 0;
            break;
        }
        //------------UPDATE TTAL EARLY PAYMENT
        $totalEarlyPayment = $totalEarlyPayment + $xtraPayments;
        $interval = new DateInterval("P1M");
        $startDateLoan->add($interval);
        $formattedDate = $startDateLoan->format("Y-m-d");

        //-------------UPDATE BEGINNING BALANCE
        $beginningBalance = $beginningBalance - $principal;
        $totalPayment = $scheduledPayment + $xtraPayments;
        $interest = $beginningBalance * $monthlyInterestRate;
        $principal = $totalPayment - $interest;
        $endBalance = $beginningBalance - $principal;
        $cumuInterest = $cumuInterest + $interest;

        $payment = $payment + 1;
    }
    $numPayment = $noPaymentsPerYear * $loanPeriodInYears;

    $conn->query("UPDATE loans SET scheduled_payment = '{$numPayment}', scheduled_no_payments = '{$scheduledPayment}', actual_no_payments = '{$payment}', total_early_payments = '{$totalEarlyPayment}',
                    total_interest = '{$cumuInterest}' WHERE id = {$loanID}");

    
    $data = array('numPayment' => $numPayment, 'payment' => $scheduledPayment, 'actualNoPayment' => $payment,
                'totalEarlyPayment' => $totalEarlyPayment, 'totalInterest' => $cumuInterest, 'lenderName' => $lenderName);

    header("Content-Type: application/json");
    echo json_encode($data);
}
else if($_SERVER['REQUEST_METHOD'] == "GET"){

    $id = $_SESSION['loanId'];
    $result = $conn->query("SELECT * FROM loan_schedule WHERE loan_id = {$id}");
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
else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

    $id = $_SESSION['loanId'];

    if($conn->query("DELETE FROM loan_schedule WHERE loan_id = {$id}") === TRUE){
        
        if($conn->query("DELETE FROM loans WHERE id = {$id}")){
            echo "Delete succeeded";
        }
    }else{
        echo "error" . $conn->error;
    }

}

?>