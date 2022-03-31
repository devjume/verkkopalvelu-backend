<?php
  require_once 'inc/headers.php';
  require_once 'inc/functions.php';
  $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

  try {
    $db = openDB();

    $sql2 = "delete from tuote where tuote_id=?";

    $pdoStatement = $db->prepare($sql2);
    $pdoStatement->bindParam(1,  $id);
    $pdoStatement->execute();
    $result = $pdoStatement->fetchAll();
    http_response_code(200);
    print json_encode($result);

  } catch(PDOException $error) {
    returnError($error);
  }

  