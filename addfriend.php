<?php
require_once 'auth.php';
require_once 'db.php';
if (isset($_GET['token']))
{
    if ($_GET['token'] == $_SESSION['token'])
    {
      if (isset($_GET['add']))
      {
          extract($_SESSION["user"]);
          $send_id = ($_SESSION["user"]["user_id"]);
          $rec_id = $_GET['add'];
          $stmt = $db->prepare("INSERT INTO `relationship` (`sender_id`, `receiver_id`, `status`) VALUES (?,?,'P')");
          $stmt->execute([$send_id, $rec_id]);
          header("Location: home.php");
      }
      if (isset($_GET['accept']))
      {
          extract($_SESSION["user"]);
          $send_id = ($_SESSION["user"]["user_id"]);
          $rec_id = $_GET['accept'];
          $stmt = $db->prepare("UPDATE `relationship` SET `status`='F' WHERE `sender_id`=? AND `receiver_id`=?");
          $stmt->execute([$rec_id, $send_id]);
          header("Location: home.php");
      }
      if (isset($_GET['reject']))
      {
          extract($_SESSION["user"]);
          $send_id = ($_SESSION["user"]["user_id"]);
          $rec_id = $_GET['reject'];
          $stmt = $db->prepare("DELETE FROM `relationship` WHERE `status`='P' AND `sender_id`=? AND `receiver_id`=?");
          $stmt->execute([$rec_id, $send_id]);
          header("Location: home.php");
      }
        if (isset($_GET['remove']))
      {
          extract($_SESSION["user"]);
          $send_id = ($_SESSION["user"]["user_id"]);
          $_SESSION['unf'] = $send_id;
          $rec_id = $_GET['remove'];
          $stmt = $db->prepare("UPDATE `relationship` SET STATUS='D' WHERE `status`='F' AND (`sender_id`=? AND `receiver_id`=?) OR (`sender_id`=? AND `receiver_id`=?)");
          $stmt->execute([$rec_id, $send_id, $send_id, $rec_id]);
          header("Location: home.php");
      }
        if (isset($_GET['ignore']))
      {
          extract($_SESSION["user"]);
          $send_id = ($_SESSION["user"]["user_id"]);
          $rec_id = $_GET['ignore'];
          $stmt = $db->prepare("DELETE FROM `relationship` WHERE `status`='D' AND (`sender_id`=? AND `receiver_id`=?) OR (`sender_id`=? AND `receiver_id`=?)");
          $stmt->execute([$rec_id, $send_id, $send_id, $rec_id]);
          header("Location: home.php");
      }
    }
}
echo "Invalid Token!";
  
?>