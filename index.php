<?php
session_start();

//if user isn't logged in...
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];

$today = new DateTime("now", new DateTimeZone('Europe/Sarajevo'));

$connection = new mysqli('localhost', 'root', '', 'dashboard');
mysqli_set_charset($connection, "utf8");

$data = $connection->query("SELECT * FROM employees WHERE username = '$username'");
?>

<!DOCTYPE html>
<html>

<head>
    <title>XYZ | Dashboard</title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/index.css">
    <link rel="icon" href="img/site-icon.png">
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- Brand -->
        <a class="navbar-brand" href="#">XYZ Corp</a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto p-2">
                <li class="nav-item p-2">
                    <a class="nav-link" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square-o"></i> New input</a>
                </li>
                <li class="nav-item p-2">
                    <a class="nav-link" href="table.php"><i class="fa fa-line-chart"></i> Stats</a>
                </li>
                <li class="nav-item p-2">
                    <a href="javascript:logout()" type="button" class="btn btn-primary"><i class="fa fa-power-off"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <br>
        <div class="jumbotron">
            <br>
            <div class="row tabela">
                <?php
                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $daily_sales = $row['daily_sales'];
                        $monthly_sales = $row['monthly_sales'];
                        $daily_ranking = $row['daily_ranking'];
                        $monthly_ranking = $row['monthly_ranking'];
                        $items_in_store = $row['items_in_store'];


                        echo    '<div class="col-sm-4">
                        <p>Full name</p>
                        <h3 class="p-2">' . $first_name . ' ' .  $last_name . '</h3>
                        <hr class="divider">
                        <p>Items in store</p>
                        <h3 class="p-2">' . $items_in_store . '</h3>
                        <hr class="divider">
                    </div>

                    <div class="col-sm-4">
                        <p>Monthly sales</p>
                        <h3 class="p-2"> ' . $monthly_sales . ' </h3>
                        <hr class="divider">
                        <p>Monthly ranking</p>
                        <h3  class="p-2"> ' . $monthly_ranking . ' </h3>
                        <hr class="divider">
                    </div>
                    
                    <div class="col-sm-4">
                        <p>Daily sales</p>
                        <h3 class="p-2"> ' . $daily_sales . '</h3>
                        <hr class="divider">
                        <p>Daily ranking</p> 
                        <h3 class="p-2"> ' . $daily_ranking . ' </h3>
                        <hr class="divider">
                    </div>';
                    }
                } else {
                    echo 'no data';
                }
                ?>
            </div>
            <br>
        </div>

        <div class="container">
            <div class="text-center">
                <div class="btn-group btn-group-justified">
                    <button type="button" class="btn btn-info btn-lg m-2" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square-o"></i> New input</button>
                    <button onclick="table()" type="button" class="btn btn-secondary btn-lg m-2"> <i class="fa fa-line-chart"></i> Stats</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <p class="error_msg">Please make sure you fill in all the fields.</p>
                    <h4 class="modal-title">New input</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="update.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <i class="fa fa-cloud-upload" style="font-size:20px"></i>
                            <label for="report-file">Report file: *</label>
                            <input type="file" class="form-control" id="report-file" name="report_file">
                        </div>
                        <input id="report-file-submit" style="visibility: hidden;" type="submit" value="upload">

                        <div class="form-group">
                            <i class="fa fa-ellipsis-h" style="font-size:20px"></i>
                            <label for="new-report-sales-number">Number of sales: *</label>
                            <input type="number" class="form-control" id="new-report-sales-number" name="new_report_sales_number">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-newspaper-o" style="font-size:20px"></i>
                            <label for="summary">Summary:</label>
                            <textarea rows="4" cols="50" class="form-control" id="summary" name="summary"></textarea>
                        </div>
                        <div class="modal-footer">
                            <input type="button" id="submit-btn" data-dismiss="modal" class="btn btn-success" value="Submit">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="logic/update.js" type="text/javascript"></script>
    <script type="text/javascript">
        table = () => {
            window.location = 'table.php';
        }

        logout = () => {
            window.location = 'logout.php';
        }
    </script>
</body>

</html>