<?php
  try {
      $db = new PDO("mysql:host=localhost;dbname=256project;charset=utf8mb4", "root", "") ;
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
  } catch (Exception $ex) {
    die ("Connection Error : " . $ex->getMessage()) ;
  }