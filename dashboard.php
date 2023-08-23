

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/pages.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <title>Dashboard</title>
    <script>
        $(document).ready(function(){
            // Show loading overlay when the page starts loading
            $(".loading-overlay").show();

            // Hide loading overlay when the page finishes loading
            $(window).on("load", function () {
                $(".loading-overlay").fadeOut("slow");
            });


            $.get('dashboard-process.php', function(response){
                $('#loaned').html(response.total_loaned);
                $('#num_loans').html(response.numOfloans);
                $('#earnings').html(response.earnings);
                $('#paid').html(response.paid);
                $('#ongoing').html(response.ongoing);
                console.log(response);
            })
        })
    </script>
</head>
<body>
    
<?php
    include("nav.php");
?>
    
    <div class="content">
        <div class="container">
            <div class="loading-overlay">
                <div class="loading-spinner"></div>
            </div>
            <h1>DASHBOARD</h1>
            <div class="totals">
                <div class="card">
                    <h3>TOTAL LOANED</h3>
                    <div>
                        <h2 id="loaned">20</h2>
                    </div>
                </div>
                <div class="card">
                    <h3>TOTAL NUMBER OF LOANS</h3>
                    <div>
                        <h2 id="num_loans">20</h2>
                    </div>
                </div>
                <div class="card">
                    <h3>TOTAL EARNINGS</h3>
                    <div>
                        <h2 id="earnings">20</h2>
                    </div>
                </div>
            </div>
            <div class="status">
                <div class="card">
                    <h3>PAID LOANS</h3>
                    <div>
                        <h2 id="paid">50</h2>
                    </div>
                </div>
                <div class="card">
                    <h3>ONGOING LOANS</h3>
                    <div>
                        <h2 id="ongoing">20</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>