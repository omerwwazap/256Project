<?php
  require_once 'auth.php';
  // destroy all sessions
  session_destroy();
  header('Location: login.php');
  