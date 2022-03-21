<?php
  require_once 'inc/headers.php';
  require_once 'inc/functions.php';

  try {
    header('HTTP/1.1 200 OK');
    $hello = array("Hello"=>"World");
    print json_encode($hello);

  } catch(PDOException $e) {
    returnError($e);
  }
