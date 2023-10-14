<?php
require_once 'auth.php';
require_once 'db.php';
if(!isset($_SESSION['token']))
{
    $token = md5(uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    extract($_SESSION["user"]);
}
$token = $_SESSION['token'];
$uid = ($_SESSION["user"]["user_id"]);
$stmt = $db->prepare("SELECT * FROM `relationship` WHERE `receiver_id`=? AND `status`='P'");
$stmt->execute([$uid]);
$rstmt = $db->prepare("SELECT * FROM `relationship` WHERE `status`='D' AND (`sender_id`=? OR `receiver_id`=?)");
$rstmt->execute([$uid, $uid]);  
$removed = $rstmt->fetchAll(PDO::FETCH_ASSOC);
$numRow = $stmt->rowCount();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
////var_dump($_SESSION["user"]);
////var_dump($requests);
////var_dump($_SESSION['token']);
////var_dump($_SESSION['unf']);
$q = $db->prepare("SELECT * FROM relationship WHERE status = 'F' AND (receiver_id = ? OR sender_id = ?)");
$q->execute(array($uid, $uid));
$friends = $q->fetchAll(PDO::FETCH_ASSOC);
$q3 = $db->prepare("select * from member where user_id = ?");
$q3->execute([$uid]);
$user = $q3->fetchAll(PDO::FETCH_ASSOC);
if (isset($_GET["show"])){
    $show = $_GET["show"];
    if(preg_match('/\d{1,3}^$/', $show))
    {\
    filter_var($show, FILTER_SANITIZE_NUMBER_INT);
    //////var_dump($show);  
    }
    else
    {
        $show = 10;
    }
} else
    $show = 10;

if(isset($_POST["post"])){
    $validExt = 0;
    $content = $_POST["content"];
    filter_var($content, FILTER_SANITIZE_STRING);
    $extsAllowed = array( 'jpg', 'jpeg', 'png', 'gif' );
    $pname = "";
    if($_FILES["file"]["error"] == 0){
        $extUpload = strtolower( substr( strrchr($_FILES['file']['name'], '.') ,1) ) ;
         if (in_array($extUpload, $extsAllowed) ) {
             $validExt = 1;
         $pname = "images/" . uniqid() . "_" . "{$_FILES['file']['name']}";
         $result = move_uploaded_file($_FILES['file']['tmp_name'], $pname);
         if(!$result){ echo 'Uploaded file is not valid. Please try again'; }  }
         ////var_dump($pname);

    if ($content!=NULL && $validExt != 0) {
        $posting = "insert into posts (content, user_id, likes, comment_id, img_content) values (?, ?, 0, 0, ?)";
        $stmt = $db->prepare($posting);
        $stmt->execute([$content, $uid, $pname]);
        $retrievelatest = "select * from posts ORDER BY created_at desc";
        $query = $db->query($retrievelatest)->fetchAll(PDO::FETCH_ASSOC);
        $name = $db->prepare("select * from member where user_id = ?");
        $name->execute([$uid]);
        $query2 = $name->fetchAll(PDO::FETCH_ASSOC);

    } else
        echo "Invalid extension";
    } else {
            if ($content!=NULL) {
    } else
        $pname = " ";
    if ($content!=NULL) {
        $posting = "insert into posts (content, user_id, likes, comment_id, img_content) values (?, ?, 0, 0, ?)";
        $stmt = $db->prepare($posting);
        $stmt->execute([$content, $uid, $pname]);
        $retrievelatest = "select * from posts ORDER BY created_at desc";
        $query = $db->query($retrievelatest)->fetchAll(PDO::FETCH_ASSOC);
        $name = $db->prepare("select * from member where user_id = ?");
        $name->execute([$uid]);
        $query2 = $name->fetchAll(PDO::FETCH_ASSOC);
    }}
    
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>256 Project</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
 
<!--
      
 ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄       ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄ 
▐░░░r░░░░░░░▌▐░░░░░e░░░░░▌▐░░░░░q░░░░░▌▐░░░░░u░░░░░▌     ▐░░░░░e░░░░░▌▐░░░░░░s░░░░▌▐░░░░░t░░░░░▌    s
▐░█▀▀▀▀▀▀▀▀▀  ▀▀▀▀█░█▀▀▀▀  ▀▀▀▀█░█▀▀▀▀ ▐░█▀▀▀▀▀▀▀▀▀       ▀▀▀▀▀▀▀▀▀█░▌▐░█▀▀▀▀▀▀▀▀▀ ▐░█▀▀▀▀▀▀▀▀▀ 
▐░▌               ▐░▌          ▐░▌     ▐░▌                         ▐░▌▐░█▄▄▄▄▄▄▄▄▄ ▐░▌          
▐░▌               ▐░▌          ▐░▌     ▐░█▄▄▄▄▄▄▄▄▄                ▐░▌▐░░░░░░░░░░░▌▐░█▄▄▄▄▄▄▄▄▄ 
▐░▌               ▐░▌          ▐░▌     ▐░░░░░░░░░░░▌      ▄▄▄▄▄▄▄▄▄█░▌ ▀▀▀▀▀▀▀▀▀█░▌▐░░░░░░░░░░░▌
▐░▌               ▐░▌          ▐░▌      ▀▀▀▀▀▀▀▀▀█░▌     ▐░░░░░░░░░░░▌          ▐░▌▐░█▀▀▀▀▀▀▀█░▌
▐░▌               ▐░▌          ▐░▌               ▐░▌     ▐░█▀▀▀▀▀▀▀▀▀           ▐░▌▐░▌       ▐░▌
▐░█▄▄▄▄▄▄▄▄▄      ▐░▌      ▄▄▄▄█░█▄▄▄▄  ▄▄▄▄▄▄▄▄▄█░▌     ▐░█▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄█░▌▐░█▄▄▄▄▄▄▄█░▌
▐░░░░░░░░░░░▌     ▐░▌     ▐░░░░░░░░░░░▌▐░░░░░░░░░░░▌     ▐░░░░░░░░░░░▌▐░░░░░░░░░░░▌▐░░░░░░░░░░░▌
 ▀▀▀▀▀▀▀▀▀▀▀       ▀       ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀▀       ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀▀ 


-->

</head>
<body>
  <!-- nav -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="home.php">Fakebook</a>
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
        <div class="panel panel-default">
          <div class="panel-body">
              <?php
              echo "<h4>{$user[0]['user_name']} {$user[0]['user_surname']}</h4>";
             
              ?>
          </div>
        </div>
        <!-- ./profile brief -->

        <!-- friend requests -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>friend requests</h4>
            <ul>
            <?php
            $stmt2 = $db->prepare("SELECT * FROM `member` WHERE `user_id`=?");
            foreach ($requests as $request) :?>
            <?= $stmt2->execute([$request['sender_id']]);
                $sender = $stmt2->fetchAll(); ?>
              <li>
                <?php echo "<img src='{$sender[0]["user_profilepic"]}' height='50' width='35'>"; ?>
                <a href="#"><?= $sender[0]["user_name"] . " " . $sender[0]["user_surname"] ?></a> 
                <a class="text-success" href="<?php echo "addfriend.php?accept=" . $request['sender_id'] . "&token=$token" ?>">[accept]</a> 
                <a class="text-danger" href="<?php echo "addfriend.php?reject=" . $request['sender_id'] . "&token=$token" ?>">[decline]</a>
              </li>
            <?php endforeach; ?>  
            </ul>
          </div>
        </div>
        <!-- ./friend requests -->
      </div>
      <div class="col-md-6">
        <!-- post form -->
        <form method="post" action="" enctype="multipart/form-data" id="myform">
          <div class="input-group">
            <input class="form-control" type="text" name="content" id="content" name="content" placeholder="Make a post..." required="required">
            <span class="input-group-btn">
                <input class="btn btn-success" type="submit" value="Post" id="post" name="post"></input>
            </span>
          </div>
            <input type="file" id="file" name="file" />
        </form><hr>
        <!-- ./post form -->

        <!-- feed -->
        <div id="hold">
         <!-- post -->
         <?php 
          $sql = $db->prepare("SELECT p.* FROM posts p JOIN relationship r ON r.receiver_id = p.user_id WHERE r.status='F' AND r.sender_id = ? UNION SELECT p.* FROM posts p JOIN relationship r ON r.sender_id = p.user_id WHERE r.receiver_id = ? AND r.status='F' UNION SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC limit 0, $show");
          $sql->execute(array($uid, $uid, $uid));
          $query = $sql->fetchAll(PDO::FETCH_ASSOC);
          if ($query != NULL) {
              foreach ($query as $value) {  
                $qcomments = $db->prepare("select * from comment where post_id = ?");
                $qcomments->execute([$value["id"]]);
                $comments = $qcomments->fetchAll(PDO::FETCH_ASSOC);
                $qimage = $db->prepare("select * from likes where post_id = ? and liker_id = ?");
                $qimage->execute(array($value['id'], $uid));
                $image = $qimage->fetchAll(PDO::FETCH_ASSOC);
                if(empty($image))
                    $icon = "fa fa-thumbs-down";
                else
                    $icon = "fa fa-thumbs-up";
              ?>
                <div class="panel panel-default">
                  <div class="panel-body">
                    <p><?php echo $value['content']; ?></p>
                                        <?php
                    if($value["img_content"] != "")
                        echo "<p><img src='{$value['img_content']}' style='width: 150px; height: 150px;'></p>";
                    ?>
                  </div>
                  <div class="panel-footer">
                    <?php
                $sql2 = $db->prepare("SELECT * from member where user_id = ?");
                $sql2->execute([$value["user_id"]]);
                $query2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
                
                //////var_dump($query2);
                    ?>
                    <span>Posted <?php echo $value['created_at']; ?> by <a ><?php echo $query2[0]['user_name']; echo " ";
                     echo "UserId: ";  echo " "; echo $value['user_id'];?></a></span>                
                    <i onclick="myFunction(this)" name="like" id="<?php echo $value["id"]; ?>" class="<?php echo $icon; ?>"><?php echo $value["likes"]; ?></i>
                    <div id="<?php echo $value['id'] ?>cont">
                    --------------------------------------------------------------------------------------------------------------- 
                    <?php
                    foreach($comments as $c){
                        $commenter = $db->prepare("select * from member where user_id = ?");
                        $commenter->execute([$c["user_id"]]);
                        $user = $commenter->fetchAll(PDO::FETCH_ASSOC);
                        echo "                      <div class='media'>
                        <div class='media-left'>
                          <img src='{$user[0]['user_profilepic']}' class='media-object' style='width:45px'>
                        </div>
                        <div class='media-body'>
                          <h4 class='media-heading'>{$user[0]['user_name']} {$user[0]['user_surname']}<small><i> Posted on {$c['created_at']}</i></small></h4>
                          <p>{$c['content']}</p>
                        </div>
                      </div>";
                    }
                    echo "</div>";
                    echo "                   <div class='form-group'>
                      <label for='comment'>Comment:</label>
                      <textarea class='form-control' rows='1' placeholder='Make a comment' id='{$value['id']}content'></textarea>
                      <input onclick='comment(this)' class='btn btn-primary btn-sm' type='button' value='Comment' id='{$value['id']}' ></input>
                      
                  </div> ";
                    ?>                  
                  </div>
                </div>
              <?php
            }
          } else {
             echo "<p class='text-center'> No posts yet!</p>";
          }
        ?>
         <script>
                                function myFunction(x) {
                       
                      
                      var userid = <?php echo $uid; ?>;
                      var postsid = x.id;
                      var icon = $(x).attr("class");
                      if(icon == "fa fa-thumbs-down"){
                          $(x).removeClass("fa fa-thumbs-down");
                          $(x).addClass("fa fa-thumbs-up");
                      }
                      else{
                          $(x).removeClass("fa fa-thumbs-up");
                          $(x).addClass("fa fa-thumbs-down");
                      }
                      console.log(icon);
                      console.log(postsid);
                      console.log(userid);
                      $.post( "likedislike.php", 
                        { uid : userid, postid : postsid }, 
                        function ( data, status ) {
                            $("#" + postsid).html(data.like);
                            
                }) ;
                  }
                  function comment(x){
                      var userid = <?php echo $uid; ?>;
                      var post = $(x).attr("id");
                      var cont = $("#" + post + "content").val();
                                      $.post( "comment.php", 
                        { content : cont, uid : userid, postid : post }, 
                        function ( data, status ) {
                            $("#" + post + "cont").append("<div class='media'>\n\
                                        <div class='media-left'>\n\
                                         <img src='" + data.pic + "' class='media-object' style='width: 45px'>\n\
                                          </div>\n\
                                           <div class='media-body'>\n\
                                           <h4 class='media-heading'>" + data.name + " " + data.surname + "<small><i> Posted on " + data.created_at + "</i></small></h4>\n\
                                            <p>" + data.content + "</p>\n\
                                            </div></div>");
                            

                            
                }) ;
                      
                  };
                    
         </script>
        <!-- ./post -->
        </div>
        <!-- ./feed -->
      </div>
      <div class="col-md-3">
        <!-- friends -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>friends</h4>
            <ul>
                  <?php
                  foreach($friends as $f){
                      $q2 = $db->prepare("select * from member where user_id = ?");
                      $q2->execute([$f["sender_id"]]);
                      $members = $q2->fetchAll(PDO::FETCH_ASSOC);
                      if($members[0]["user_id"] == $uid){
                          $q2 = $db->prepare("select * from member where user_id = ?");
                          $q2->execute([$f["receiver_id"]]);
                          $members = $q2->fetchAll(PDO::FETCH_ASSOC);
                      }
                      echo "<li>";
                      echo "<img src='{$members[0]["user_profilepic"]}' height='50' width='35'>";
                      echo " {$members[0]["user_name"]}";
                      echo "<a href = 'addfriend.php?remove={$members[0]["user_id"]}&token=$token' class='text-danger'> [unfriend]</a>";
                      echo "</li>";
                      
                      }
                  foreach($removed as $r){
                      if ($r['sender_id'] == $uid)
                          $rid = $r['receiver_id'];
                      else
                          $rid = $r['sender_id'];
                      $rq = $db->prepare("select * from member where user_id = ?");
                      $rq->execute([$rid]);
                      $ru = $rq->fetchAll(PDO::FETCH_ASSOC);
                      if(!isset($_SESSION['unf']) || $_SESSION['unf'] != $uid)
                      {
                      echo "<p> <strong>" . $ru[0]['user_name'] . " " . $ru[0]['user_surname'] . "</strong>" . " has just unfriended you!";
                      echo "<a href = 'addfriend.php?ignore={$ru[0]["user_id"]}&token=$token' class='text-danger'> [ignore]</a>";
                      }
                      }
                     
                      
                  ?>
                  
            </ul>
          </div>
        </div>
        <!-- ./friends -->
      </div>
    </div>
  </main>
  <form method="get" action="">
  <button style='width: 100px; margin: 0 auto; display: block;' class="btn btn-success" type="submit" name="show" value='<?php echo $show+10;?>'>Show More</button>
  </form>
  <!-- ./main -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>


  <?php include "footer.php"; ?>


</body>
</html>
