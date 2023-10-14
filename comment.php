<?php //

   require "./db.php";
   header("Content-Type: application/json") ;
   header("Access-Control-Allow-Origin: *") ; // allow cors requests from any domain
   $postid = $_POST["postid"];
   $content = $_POST["content"];
   $uid = $_POST["uid"];
   
   $q = "insert into comment (content, user_id, post_id) values (?, ?, ?)";
   $stmt = $db->prepare($q);
   $stmt->execute([$content, $uid, $postid]);
   $q2 = "select * from comment order by created_at desc";
   $latest = $db->query($q2)->fetchAll(PDO::FETCH_ASSOC);
   $q3 = $db->prepare("select * from member where user_id = ?");
   $q3->execute([$uid]);
   $user = $q3->fetchAll(PDO::FETCH_ASSOC);
   $result = array( "created_at" => $latest[0]["created_at"], "pic" => $user[0]["user_profilepic"], "name" => $user[0]["user_name"], "surname" => $user[0]["user_surname"], "content" => $latest[0]["content"]);
   print json_encode($result);
   