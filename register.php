<?php
session_start();

//if user is already logged in...
if (isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

$first_name = '';
$last_name = '';
$email = '';
$username = '';
$password = '';

$connection = new mysqli('localhost', 'root', '', 'dashboard');
mysqli_set_charset($connection, "utf8");

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    $first_name = $connection->real_escape_string($_POST['first_name']);
    $last_name = $connection->real_escape_string($_POST['last_name']);
    $email = $connection->real_escape_string($_POST['email']);
    $username = $connection->real_escape_string($_POST['username']);
    $password = md5($connection->real_escape_string($_POST['password']));

    $data = $connection->query("INSERT INTO employees (`first_name`, `last_name`, `email`, `username`, `password`) VALUES ('$first_name', '$last_name', '$email', '$username', '$password')");
    
    if($data) {
        echo 'success';
    } else {
        echo 'failed';
    }
    
    $connection->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/loginAndRegister.css">
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
                    <a href="javascript:login()" type="button" class="btn btn-primary"><i class="fa fa-users"></i> Login</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="wrapper">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="img/user-icon.png" id="icon" alt="User Icon" />
            </div>

            <!-- Register Form -->
            <form method="POST" action="register.php">
                <div class="form-group">
                    <input type="text" id="firstName" class="fadeIn second" name="first_name" placeholder="First name">
                </div>
                <div class="form-group">
                    <input type="text" id="lastName" class="fadeIn second" name="last_name" placeholder="Last name">
                </div>
                <div class="form-group">
                    <input type="email" id="email" class="fadeIn second" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" id="password" class="fadeIn second" name="password" placeholder="Password">
                </div>

                <input type="button" id="register-btn" class="fadeIn fourth" value="Register">
            </form>
        </div>

        <p id="response"></p>
    </div>

    <footer class="footer pt-2">
        <div class="container text-center">
            <p class="copyright text-muted">&copy; XYZ Corporation | <span id="currentYear"></span></p>
        </div>
    </footer>

    <script src="logic/register.js"></script>

    <script>
        getYear = () => {
            let d = new Date();
            let year = d.getFullYear();
            document.getElementById('currentYear').innerHTML = year;
        };
        getYear();

        login = () => {
            window.location = 'login.php';
        }
    </script>
</body>

</html>