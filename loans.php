<?php
session_start();
    if(!isset($_SESSION['user'])){
        header("location: /");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/loans.css">
    <link rel="stylesheet" href="styles/pages.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    
    <script src="controller/loan_script.js"></script>
    <title>Loans</title>
</head>
<body>
<?php
    include("nav.php");
?>

    <div class="content">
        <div class="container">
            <div class="inputs-container">
                <div class="inputs">
                    <h3>ENTER VALUES</h3>
                    <form id="kanor">
                        <label>
                            Loan Amount:
                            <input type="number" class="form-control" min="1000" name="loanAmount" required>
                        </label>
                        <label>
                            Annual interest rate:
                            <input type="number" class="form-control" min="0" name="annualInterestRate" required>
                        </label>
                        <label>
                            Loan period in years:
                            <input type="number" class="form-control" min="1" name="loanPeriodYears" required>
                        </label>
                        <label>
                            Number of payments per year:
                            <input type="number" class="form-control" min="1" max="12" name="noPaymentsPerYear" required>
                        </label>
                        <label>
                            Start date of loan:
                            <input type="date" class="form-control" name="startDateLoan" required>
                        </label>
                        <label>
                            Optional extra payments:
                            <input type="number" class="form-control" min="10" name="xtraPayments">
                        </label>
                        <label>
                            Lender Full Name:
                            <input type="text" class="form-control" name="lenderName" required>
                        </label>
                        <button id="setSched" class="btn btn-primary">Set Schedule</button>
                    </form>
                    
                </div>
                <div class="outputs">
                    <h3>LOAN SUMMARY</h3>
                    <div class="output-list">
                        <ul class="p-0">
                            <li>Scheduled payment:<span></span></li>
                            <li>Scheduled number of payments:<span></span></li>
                            <li>Actual number of payments:<span></span></li>
                            <li>Total early payments:<span></span></li>
                            <li>Total interest:<span></span></li>
                            <li>Lender name:<span></span></li>
                        </ul>
                        <div class="actions">
                            <button class="btn btn-secondary" id="refresh">Refresh</button>
                            <button class="btn btn-danger" id="cancel" disabled>Cancel</button>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <div class="sched-table">
                    <table class="table table-bordered table-hover">
                        <thead class="table-warning">
                            <tr>
                                <th scope="col">PMT no.</th>
                                <th scope="col">Payment Date</th>
                                <th scope="col">Beginning Balance</th>
                                <th scope="col">Scheduled Payment</th>
                                <th scope="col">Extra Payment</th>
                                <th scope="col">Total_payment</th>
                                <th scope="col">Principal</th>
                                <th scope="col">Interest</th>
                                <th scope="col">Ending Balance</th>
                                <th scope="col">Cumulative Interest</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="sched"></tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</body>
</html>