<?php
require_once 'inc/headers.php';
require_once 'inc/functions.php';

$name = filter_input(INPUT_POST, "nimi");
$email = filter_input(INPUT_POST, "sposti");
$orderId = filter_input(INPUT_POST, "tilausnro");
$message = filter_input(INPUT_POST, "viesti");

if (!isset($name) || !isset($email) || !isset($message)) {
  http_response_code(400);
  print json_encode(array("message" => "Attribuutteja puuttuu"));
  exit;
}


try {
  $db = openDB();

  #$responseMessage = checkCategory($db, $categoryName);
  $sql = "INSERT INTO `yhteydenotto` (`nimi`, `sposti`, `tilausnro`, `viesti`) VALUES (?,?,?,?)";
  $pdoStatement = $db->prepare($sql);

  $pdoStatement->bindParam(1, $name);
  $pdoStatement->bindParam(2, $email);
  $pdoStatement->bindParam(3, $orderId);
  $pdoStatement->bindParam(4, $message);

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


function saveMessage($db, $userInput) {
  $sql = "SELECT `nimi` FROM `tuoteryhma` WHERE `nimi` = ?";
  $pdoStatement = $db->prepare($sql);
  $pdoStatement->bindParam(1, $userInput);
  $pdoStatement->execute();
  $categoryName = $pdoStatement->fetchColumn();

  if(empty($categoryName)) {
    $sqlCreate = "INSERT INTO tuoteryhma(nimi) VALUES (?)";
    $pdoCreate = $db->prepare($sqlCreate);
    $pdoCreate->bindParam(1, $userInput);
    $pdoCreate->execute();
    $categoryName = $pdoCreate-> fetchColumn();
    return $userInput . " kategoria luotu";
  }

  return $userInput . " kategoria on jo luotu";
}
