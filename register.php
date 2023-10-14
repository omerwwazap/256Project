<?php
  $validExt = 0;
  $validMail = 0;
  $validDate = 0;
  session_start() ;
  require_once 'db.php';
  extract($_POST);
    if ( isset($_POST["btnRegister"])) {
       if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $validMail = 1;
           }
       else {
           echo "<p>Invalid Email!</p>";
           }  
       if($_FILES['file']['error'] > 0) { echo 'Error during uploading, try again'; }
       $extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );
       $extUpload = strtolower( substr( strrchr($_FILES['file']['name'], '.') ,1) ) ;
       if (in_array($extUpload, $extsAllowed) ) {
           $validExt = 1;
           $pname = "profilepics/" . uniqid() . "_" . "{$_FILES['file']['name']}";
           $result = move_uploaded_file($_FILES['file']['tmp_name'], $pname);
       if(!$result){ echo 'Uploaded file is not valid. Please try again'; }  }
       if (empty($email) || empty($name) || empty($surname) || empty($birthdate) || empty($password) || empty($gender) || empty($pname)) {
           echo "<p>Please fill all the fields!</p>";}
       else {
       $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $surname = filter_var($surname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       if($validExt == 0)
       {
           echo "<p>File type not allowed! Use .jpg, .jpeg, .png or .gif.</p>";
       }
       if ($_FILES['file']['error'] == 0 && $validExt == 1 && $validMail == 1)
       {       
       $password = password_hash($password, PASSWORD_BCRYPT) ;
       try {
           $stmt = $db->prepare("insert into member (user_email, user_name, user_surname, user_birthdate, user_pass, user_gender, user_profilepic) values (?,?,?,?,?,?,?)") ;
           $stmt->execute( [$email, $name, $surname, $birthdate, $password, $gender, $pname]) ;
           header("Location: login.php");
           exit ;
       } catch (Exception $ex) {
          $error = true ;
       }
       }
       }
          
       
  }
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
    <div id="container-register">
        <div id="title">
            <i class="material-icons lock">lock</i> Register
        </div>

        <form action="" method="post" action="" autocomplete="false" enctype="multipart/form-data">
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">email</i>
                </div>
                <input name="email" id="email" placeholder="Email" type="email" required class="validate" autocomplete="off">
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">face</i>
                </div>
                <input name="name" id="name" placeholder="Name" type="text" required autocomplete="off">
            </div>

            <div class="clearfix"></div>
            
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">people</i>
                </div>
                <input name="surname" id="surname" placeholder="Surname" type="text" required autocomplete="off">
            </div>
            
            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">date_range</i>
                </div>
                <input name="birthdate" id="birthdate" type="date" required class="validate" autocomplete="off">
            </div>

            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">vpn_key</i>
                </div>
                <input name="password" id="password" placeholder="Password" type="password" required autocomplete="off">
            </div>
            
            <div class="clearfix"></div>

            <div class="input">
                <div class="input-addon">
                    <i class="material-icons">attachment</i>
                </div>
                <input name="file" type="file" required autocomplete="off">
            </div>
            
            <div class="gender">
            <input name="gender"  type="radio" required  value="M"> Male
            <input name="gender" type="radio" value="F"> Female
            </div>
            

            <input type="submit" value="Register" class="submit" name="btnRegister"/>
        </form>

        <div class="register">
            Do you already have an account?
            <a href="login.php"><button id="register-link">Log In here</button></a>
        </div>
    </div>
</body>
</html>
