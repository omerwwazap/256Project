<?php
require_once 'auth.php';
require_once 'db.php';
$token = $_SESSION['token'];
//var_dump($token);
extract($_SESSION["user"]);
$uid = ($_SESSION["user"]["user_id"]);
if (isset($_GET["search"])) {
  $name = $_GET["search"];
  $q2 = $db->prepare("select * from relationship where (receiver_id = ? or sender_id = ?) and status = 'F'");
  $q2->execute(array($uid, $uid));
  $alreadyfriends = $q2->fetchAll(PDO::FETCH_ASSOC);
  $hold = [];
  foreach ($alreadyfriends as $p) {
    if ($p["sender_id"] == $uid) {
      $hold[] = $p["receiver_id"];
    } else {
      $hold[] = $p["sender_id"];
    }
  }
  $banned = implode(", ", $hold);
  if ($banned == "")
  {
    $q = $db->prepare("select * from member where user_name = ? and user_id != ?");
    $q->execute(array($name, $uid));
  }
  else
  {
    $q = $db->prepare("select * from member where user_name = ? and user_id not in(?, ?)");
    $q->execute(array($name, $banned, $uid));
  }
  //var_dump($banned);
  $list = $q->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>FaceClone</title>

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
        <li><a href="search.php">Search Users</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>
  <!-- ./nav -->

  <!-- main -->
  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- profile brief -->
        <!-- ./profile brief -->

        <!-- friend requests -->
        <!-- ./friend requests -->
      </div>
      <div class="col-md-6">
        <!-- post form -->
        <form method="get" action="">
          <div class="input-group">
            <input required="required" class="form-control" type="text" name="search" placeholder="Enter Username Here">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit" name="post">Search</button>
            </span>
          </div>
        </form>
        <hr>
        <!-- ./post form -->

        <!-- feed -->
        <div>
          <!-- post -->
          <div class="panel panel-default">
            <?php
            if (isset($_GET["search"])) {
              if (!empty($list)){
                foreach ($list as $m) {
                  echo "<div class='panel-body'>
                      <img src = '{$m['user_profilepic']}' width='50' height='50'>
                  <p style='display: inline; padding: 10px;'><span style='font-weight: bold;'>Name:</span> {$m["user_name"]} <span style='font-weight: bold;'>Surname:</span> {$m["user_surname"]} <span style='font-weight: bold;'>Birthdate:</span> {$m["user_birthdate"]}<a style='padding: 10px;'href='addfriend.php?add={$m["user_id"]}&token=" . $token . "'> Add Friend</a></p>                 
                          </div>";
                }
              }else {
                echo "<p class='text-center'>User not found</p>";
              } 
            }
            ?>
          </div>
          <!-- ./post -->
        </div>
        <!-- ./feed -->
      </div>
    </div>
  </main>
  <!-- ./main -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
</body>
<?php include "footer.php"; ?>

</html>