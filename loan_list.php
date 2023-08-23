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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/pages.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/pages.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    
    <title>Loan Lists</title>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: 'loan-list-process.php',
                method: 'GET',
                success: function(response){
                    $('#loans').append(response);
                },
                error: function(error){
                    console.log("doesnt work: ", error)
                }
            });

            $('#myTable').on('click', 'tbody tr', function() {
                var rowData = $(this).find('td:first').text();
                $('#schedule').empty();
                $.post('loan-list-process.php', { rowData: rowData, use: 'view' }, function(response){
                    $('#schedule').append(response);
                })
            });
            $('#search').change(function(){
                $('#loans').empty();
                let input = $(this).val();
                $.post('loan-list-process.php', { input: input, use: 'search' }, function(response){
                    $('#loans').append(response);
                })
            });
            $('#myTable').on('click', 'tbody tr #pay', function() {
                let input = $(this).closest('tr').find('td:first').text();
                let confirm = window.confirm("Are you sure this loan is paid? ID: " + input);
                if(confirm){
                    $.post('loan-list-process.php', { input: input, use: 'pay' }, function(response){
                        alert("Update " + response);
                        location.reload();
                    })
                }
                
            });
            $('#myTable').on('click', 'tbody tr #delete', function() {
                let input = $(this).closest('tr').find('td:first').text();
                let confirm = window.confirm("Are you sure you want to delete this loan? ID: " + input);
                if(confirm){
                    $.post('loan-list-process.php', { input: input, use: 'remove' }, function(response){
                        alert("Update " + response);
                        location.reload();
                    })
                }
            });
          
        })
    </script>
</head>
<body>
<?php
    include("nav.php");
?>
    
    <div class="content">
        <div class="container">
            <h1>LOANS</h1>
            <label>
                Search: <input type="text" id="search" class="form-control m-3">
            </label>
            
            <table class="table table-hover" id="myTable">
                <thead class="table-info">
                    <tr>
                        <th>ID</th>
                        <th>Lender Name</th>
                        <th>Loan Amount</th>
                        <th>Scheduled Payment</th>
                        <th>Scheduled number of Payment</th>
                        <th>Actual number of Payment</th>
                        <th>Total early Payment</th>
                        <th>Total Interest</th>
                        <th>Process</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="loans">
                    
                </tbody>
            </table>
            <div class="details">
                <h2>LOAN DETAILS</h2>
                <table class="table">
                    <thead class="table-warning">
                        <tr>
                            <th>PMT No.</th>
                            <th>Payment Date</th>
                            <th>Beginning Balance</th>
                            <th>Scheduled Payment</th>
                            <th>Extra Payment</th>
                            <th>Total_payment</th>
                            <th>Principal</th>
                            <th>Interest</th>
                            <th>Ending Balance</th>
                            <th>Cumulative Interest</th>
                        </tr>
                    </thead>
                    <tbody id="schedule">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>