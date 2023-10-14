<?php
    session_start();
    require_once 'db.php';
    if ( isset($_POST["logBtn"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $db->prepare("SELECT * FROM member WHERE user_email = ?");
        $stmt->execute( [$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            if (password_verify($password, $row['user_pass'])) {
                $_SESSION['loginAt'] = time();
                $_SESSION['user'] = $row;
                header("Location: home.php");
                exit; 
        }
        }
    }
    else { echo "<p>Invalid Email!</p>";}
    }
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="description" content="Login - Register Template">
    <meta name="author" content="Lorenzo Angelino aka MrLolok">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\registerlogin.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background-color: #303641;
        }
    </style>
</head>

<body>
    <div id="container-login">
        <div id="title">
            <i class="material-icons lock">lock</i> Login
        </div>

        <form method="post" action="">
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">email</i>
                </div>
                <input name="email" id="email" placeholder="Email" type="text" required autocomplete="off">
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <input name="password" id="password" placeholder="Password" type="password" required autocomplete="off">
            </div>

            <div class="remember-me">
                <input type="checkbox">
                <span style="color: #DDD">Remember Me</span>
            </div>

            <input type="submit" value="Log In" class="logbtn" name="logBtn" />
            <a href="register.php"><button class="logbtn" id="register-link" novalidate>Register</button></a>
        </form>


    </div>
</body>
</html>
