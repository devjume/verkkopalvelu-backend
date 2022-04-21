<?php
require_once 'inc/headers.php';
require_once 'inc/functions.php';

try {
  $db = openDB();

  if (!$db) {
    http_response_code(500);
    print json_encode(array("error" => "Tietokanta yhteys epäonnistui"));
    exit;
  }

  $sql = "SELECT * FROM `yhteydenotto`";

  $pdo = $db->prepare($sql);
  $pdo->execute();

  $result = $pdo->fetchAll();

  http_response_code(200);
  print json_encode($result);
} catch (PDOException $error) {
  returnError($error);
}