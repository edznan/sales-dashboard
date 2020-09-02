<?php
session_start();

// if user is already logged in...
if (isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit();
}

$username = '';
$password = '';

$connection = new mysqli('localhost', 'root', '', 'dashboard');
mysqli_set_charset($connection, "utf8");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $connection->real_escape_string($_POST['username']);
    $password = md5($connection->real_escape_string($_POST['password']));

    $data = $connection->query("SELECT * FROM employees WHERE username = '$username' AND password = '$password'");

    if ($data->num_rows > 0) {
        $_SESSION['logged_in'] = '1';
        $_SESSION['username'] = $username;
        exit('success');
    } else {
        exit('fail');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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
                    <a href="javascript:register()" type="button" class="btn btn-primary"><i class="fa fa-user-plus"></i> Register</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="wrapper mb-8">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="img/user-icon.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form method="POST" action="login.php">
                <div class="form-group">
                    <input type="text" id="username" class="fadeIn second" name="username" placeholder="username">
                </div>
                <div class="form-group">
                    <input type="password" id="password" class="fadeIn third" name="password" placeholder="password">
                </div>
                <div class="checkbox fadeIn fourth">
                    <label id="remember-me-label"><input type="checkbox" name="remember_me" id="remember-me-checkbox" data-value="false"> remember me?</label>
                </div>

                <input type="button" id="login-btn" class="fadeIn fourth" value="Login">
            </form>
        </div>

        <p id="response"></p>

    </div>

    <footer class="footer pt-2" style="bottom: 0">
        <div class="container text-center">
            <p class="copyright text-muted">&copy; XYZ Corporation | <span id="currentYear"></span></p>
        </div>
    </footer>

    <script src="logic/login.js"></script>

    <script>
        getYear = () => {
            let d = new Date();
            let year = d.getFullYear();
            document.getElementById('currentYear').innerHTML = year;
        };
        getYear();

        register = () => {
            window.location = 'register.php';
        }
    </script>
</body>

</html>