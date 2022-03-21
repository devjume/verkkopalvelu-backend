<?php
  require_once 'inc/headers.php';
  require_once 'inc/functions.php';

  try {
    $db = openDB();

    $sql = "select * from item";
    $query = $db->query($sql);
    $result = $query->fetchAll();

    header('HTTP/1.1 200 OK');
    print json_encode($result);

  } catch(PDOException $e) {
    returnError($e);
  }
