<?php
  session_start();

  session_destroy();

  header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/~somarsan/pec3/somarsan_pec3/blog.php");
  exit();
?>
