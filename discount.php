<?php
  require_once 'inc/headers.php';
  require_once 'inc/functions.php';

  try {
    $db = openDB();

    $sql = "SELECT * FROM `tuote` where alehinta>0";
    $query = $db->query($sql);
    $result = $query->fetchAll();

    http_response_code(200);
    print json_encode($result);

  } catch(PDOException $error) {
    returnError($error);
  }