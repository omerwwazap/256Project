<?php
   require "./db.php";
   header("Content-Type: application/json") ;
   header("Access-Control-Allow-Origin: *") ; // allow cors requests from any domain
   
   $uid = $_POST["uid"];
   $postid = $_POST["postid"];
   $q1 = $db->prepare("select * from likes where post_id = ? and liker_id = ?");
   $q1->execute(array($postid, $uid));
   $query1 = $q1->fetchAll(PDO::FETCH_ASSOC);
   $q3 = $db->prepare("select * from posts where id = ?");
   $q3->execute([$postid]);
   $query3 = $q3->fetchAll(PDO::FETCH_ASSOC);
   $newlike = $query3[0]["likes"] + 1;
   $deletedlike = $query3[0]["likes"] - 1;
   if(empty($query1)){
       $q2 = "insert into likes values (?, ?)";
       $stmt = $db->prepare($q2);
       $stmt->execute([$postid, $uid]);
       $q4 = "update posts set likes = ? where id = ?";
       $stmt2 = $db->prepare($q4);
       $stmt2->execute([$newlike, $postid]);
       $result = array( "like" => $newlike);
       print json_encode($result);
   } else {
       $delete = "update posts set likes = ? where id = ?";
       $stmt3 = $db->prepare($delete);
       $stmt3->execute([$deletedlike, $postid]);
       $q5 = "delete from likes where liker_id = ? and post_id = ?";
       $stmt4 = $db->prepare($q5);
       $stmt4->execute([$uid, $postid]);
       $result = array( "like" => $deletedlike);
       print json_encode($result);
   }
   
