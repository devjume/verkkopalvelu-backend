<?php
require_once 'inc/headers.php';
require_once 'inc/functions.php';

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);



if (!isset($id)) {
  http_response_code(400);
  print json_encode(array("error" => " ID puuttuu"));
  exit;
}

try {
  $db = openDB();

  if (!$db) {
    http_response_code(500);
    print json_encode(array("error" => "Tietokanta yhteys epäonnistui"));
    exit;
  }

  $sql = "SELECT * FROM `yhteydenotto` WHERE id = ?";

  $pdo = $db->prepare($sql);
  $pdo->bindParam(1, $id);
  $pdo->execute();

  $result = $pdo->fetchAll();

  http_response_code(200);
  print json_encode($result);
} catch (PDOException $error) {
  returnError($error);
}
