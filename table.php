<!DOCTYPE html>
<html>

<head>
    <title>XYZ | Stats</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
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
                    <a class="nav-link" href="index.php"><i class="fa fa-user"></i> Dashboard</a>
                </li>
                <li class="nav-item p-2">
                    <a href="javascript:logout()" type="button" class="btn btn-primary"><i class="fa fa-power-off"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row p-4">
                    <div class="alert alert-primary w-100">
                        Monthly ranking
                    </div>
                    <div class="table-responsive">
                        <table data-order='[[ 0, "asc" ]]' data-page-length='25' class="text-center table table-hover table-bordered">
                            <tr>
                                <thead>
                                    <th class="text-center">monthly ranking</th>
                                    <th class="text-center">employee name</th>
                                    <th class="text-center">monthly sales</th>
                                </thead>
                            </tr>
                            <?php
                            session_start();

                            // if user isn't logged in...
                            if (!isset($_SESSION['logged_in'])) {
                                header('Location: login.php');
                            }

                            $username = $_SESSION['username'];

                            $monthly_ranking = 0;

                            $connection = new mysqli('localhost', 'root', '', 'dashboard');
                            mysqli_set_charset($connection, "utf8");

                            $data = $connection->query("SELECT * FROM employees ORDER BY monthly_sales DESC");

                            if ($data->num_rows > 0) {
                                while ($row = $data->fetch_assoc()) {
                                    $monthly_ranking++;
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $monthly_sales = $row['monthly_sales'];
                                    echo  '<tr>
                                        <td class="bg-primary" style="font-size: 15px; font-weight: 700; color: #fff;">
                                        ' . $monthly_ranking . ' 
                                        </td>
                                        <td>
                                        <p> ' . $first_name . ' ' . $last_name . ' </p>
                                    </td>
                                    <td>
                                    <p> ' . $monthly_sales . ' </p>
                                    </td>
                                    </tr>';
                                    $sql_update = "UPDATE employees SET monthly_ranking = '$monthly_ranking' WHERE first_name = '$first_name' AND last_name = '$last_name'";
                                    $update = $connection->query($sql_update);
                                }
                            } else {
                                echo 'no data';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row p-4">
                    <div class="alert alert-primary w-100">
                        Daily ranking
                    </div>
                    <div class="table-responsive">
                        <table data-order='[[ 0, "asc" ]]' data-page-length='25' class="text-center table table-hover table-bordered">
                            <tr>
                                <thead>
                                    <th class="text-center">daily ranking</th>
                                    <th class="text-center">employee name</th>
                                    <th class="text-center">daily sales</th>
                                </thead>
                            </tr>
                            <?php

                            $daily_ranking = 0;
                            $data = $connection->query("SELECT * FROM employees ORDER BY daily_sales DESC");

                            if ($data->num_rows > 0) {
                                while ($row = $data->fetch_assoc()) {
                                    $daily_ranking++;
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $daily_sales = $row['daily_sales'];

                                    echo  '<tr>
                                <td class="bg-primary" style="font-size: 15px; font-weight: 700; color: #fff;">
                                ' . $daily_ranking . '
                                </td>
                                <td>
                                    <p> ' . $first_name . ' ' . $last_name . ' </p>
                                </td>
                            <td>
                                <p> ' . $daily_sales . ' </p>
                            </td>
                            </tr>';

                                    $sql_update = "UPDATE employees SET daily_ranking = '$daily_ranking' WHERE first_name = '$first_name' AND last_name = '$last_name'";
                                    $update = $connection->query($sql_update);
                                }
                            } else {
                                echo 'no data';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr><br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-primary w-100">
                    Items in store
                </div>
                <div class="table-responsive">
                    <table data-order='[[ 0, "asc" ]]' data-page-length='25' class="text-center table table-hover rounded table-bordered">
                        <tr>
                            <thead>
                                <th class="text-center">employee name</th>
                                <th class="text-center">number of items</th>
                            </thead>
                        </tr>
                        <?php

                        $data = $connection->query("SELECT * FROM employees WHERE items_in_store > 0 ORDER BY items_in_store DESC");

                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $items_in_store = $row['items_in_store'];
                                echo  '<tr>
                                    <td>
                                    <p> ' . $first_name . ' ' . $last_name . ' </p>
                                </td>
                                <td style="font-size: 15px; font-weight: 700;">
                                ' . $items_in_store . ' 
                                </td>
                                </tr>';
                            }
                        } else {
                            echo 'no data';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <hr><br>
        <div class="container">
            <div class="text-center">
                <div class="btn-group btn-group-justified">
                    <button type="button" class="btn btn-info btn-lg m-2" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-square-o"></i> New input</button>
                    <button onclick="dashboard()" type="button" class="btn btn-secondary btn-lg m-2"> <i class="fa fa-user"></i> Dashboard</button>
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
                    <h4 class="modal-title">New input</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <p class="error_msg">Please make sure you fill in all the fields.</p>
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


    <script type="text/javascript" src="logic/update.js"></script>
    <script type="text/javascript">
        dashboard = () => {
            window.location = 'index.php';
        }
        logout = () => {
            window.location = 'logout.php';
        }
    </script>
</body>

</html>