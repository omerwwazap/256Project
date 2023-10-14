<?php

   require "./db.php";
   header("Content-Type: application/json") ;
   header("Access-Control-Allow-Origin: *") ; // allow cors requests from any domain

    $content = $_POST["content"];
    $uid = $_POST["uid"];
    filter_var($content, FILTER_SANITIZE_STRING);
    if ($content!=NULL) {
        $posting = "insert into posts (content, user_id, likes, comment_id) values (?, ?, 0, 0)";
        $stmt = $db->prepare($posting);
        $stmt->execute([$content, $uid]);
        $retrievelatest = "select * from posts ORDER BY created_at desc";
        $query = $db->query($retrievelatest)->fetchAll(PDO::FETCH_ASSOC);
        $name = $db->prepare("select * from member where user_id = ?");
        $name->execute([$uid]);
        $query2 = $name->fetchAll(PDO::FETCH_ASSOC);
        $result = array( "id" => $query[0]["id"],  "content" => $query[0]["content"], "uid" => $uid, "created_at" => $query[0]["created_at"], "likes" => $query[0]["likes"], "comment_id" => $query[0]["comment_id"], "user_name" => $query2[0]["user_name"]) ;
        print json_encode($result) ;
    }

    