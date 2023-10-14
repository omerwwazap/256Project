<?php
require_once 'auth.php';
require_once 'db.php';
extract($_SESSION["user"]);
$uid = ($_SESSION["user"]["user_id"]);
$stmt = $db->prepare("SELECT * FROM `relationship` WHERE `receiver_id`=? AND `status`='P'");
$stmt->execute([$uid]);
$numRow = $stmt->rowCount();
$requests = $stmt->fetchAll();
////var_dump($requests);
?>

<!DOCTYPE html>
<html>
<head>
<title>Requests</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <!-- nav -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="home.php">FaceClone</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="home.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>
  <!-- ./nav -->

  <!-- main -->
  <main class="container">
    <h1 style="  color: #ff0000;  text-align: center;"> You have Successfully Found The Easter Egg </h1>
    <h1 style="  color: #ff0000;  text-align: center;">For A Better One</h1>
    <h1 style="  color: #ff0000;  text-align: center;" ><a href="https://www.google.com/search?client=firefox-b-d&q=thanos">  Go Here </h1> </a>
    <h1 style="  color: #ff0000;  text-align: center;"> And </h1>
    <h1 style="  color: #ff0000;  text-align: center;">Click The Small Gauntlet on the Right </h1>
  </main>
  <!-- ./main -->

  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
</body>
</html>