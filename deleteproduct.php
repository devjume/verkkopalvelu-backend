<?php
  require_once 'inc/headers.php';
  require_once 'inc/functions.php';
  $nimi = filter_input(INPUT_POST, "tuotenimi");

  try {
    $db = openDB();

    $sql2 = "delete from tuote where tuotenimi=?";

    $pdoStatement = $db->prepare($sql2);
    $pdoStatement->bindParam(1,  $nimi);
    $pdoStatement->execute();
    $result = $pdoStatement->fetchAll();
    http_response_code(200);
    print json_encode($result);

  } catch(PDOException $error) {
    returnError($error);
  }

  