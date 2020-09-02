<?php
session_start();

// if user isn't logged in...
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];

$today = new DateTime("now", new DateTimeZone('Europe/Sarajevo'));

$connection = new mysqli('localhost', 'root', '', 'dashboard');
mysqli_set_charset($connection, "utf8");

//update           
if (isset($_POST['new_report_sales_number']) && isset($_FILES['report_file']) && isset($_POST['summary'])) {
    $new_report_sales_number = $_POST['new_report_sales_number'];
    $summary = $_POST['summary'];

    $sql = "SELECT * FROM employees WHERE username = '$username'";;

    $employees = $connection->query($sql);

    if ($employees->num_rows > 0) {
        while ($row = $employees->fetch_assoc()) {
            $daily_sales = $row['daily_sales'];
            $monthly_sales = $row['monthly_sales'];
            $items_in_store = $row['items_in_store'];

            $new_report_sales_number_today = $daily_sales + $new_report_sales_number;
            $new_report_sales_number_month = $monthly_sales + $new_report_sales_number;

            $report_file = $_FILES['report_file'];

            //file properties
            $file_name = $report_file['name'];
            $file_tmp = $report_file['tmp_name'];
            $file_error = $report_file['error'];

            //get extension
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));
            $allowed = array('txt');

            //folder structure should be created for this before attempting to save files to destination!!! 
            if (in_array($file_ext, $allowed)) {
                if ($file_error === 0) {
                    $file_name_new = 'db_' . $username . '_' . $today->format('Y-m-d,h-i-s') . '.' . $file_ext;
                    $file_destination = 'files/' . $username . '/' . $file_name_new;

                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        echo 'Success!';
                    }
                }
            }

            $sql_update = "UPDATE employees SET new_report_sales_number = '$new_report_sales_number', daily_sales = '$new_report_sales_number_today', monthly_sales = '$new_report_sales_number_month', summary = '$summary' WHERE username = '$username'";
            $update = $connection->query($sql_update);
        }
    }
}
echo 'Success!';
header('Location: index.php');
