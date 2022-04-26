<?php
require_once 'inc/headers.php';
require_once 'inc/functions.php';

$updatedtila = filter_input(INPUT_POST, "tila");
$tilausnro = filter_input(INPUT_POST, "tilausnro");

if (!isset($updatedtila) || !isset($tilausnro)) {
  http_response_code(400);
  print json_encode(array("message" => "Attribuutteja puuttuu"));
  exit;
}


try {
  $db = openDB();

  #$responseMessage = checkCategory($db, $categoryName);
  $sql = "UPDATE `tilaus` SET `tila`=? WHERE tilausnro=?";
  $pdoStatement = $db->prepare($sql);
  $pdoStatement->bindParam(1, $updatedtila);
  $pdoStatement->bindParam(2, $tilausnro);
  $pdoStatement->execute();
  $affectedRows = $pdoStatement->rowCount();

  if ($affectedRows <= 0) {
    http_response_code(500);
    print json_encode(array("message" => "Viestin lähettäminen epäonnistui"));
  } else {
    http_response_code(200);
    print json_encode(array("message" => "Viesti lähetetty"));
  }

  exit();
} catch (PDOException $error) {
  returnError($error);
}