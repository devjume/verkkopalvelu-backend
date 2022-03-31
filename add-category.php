<?php
require_once 'inc/headers.php';
require_once 'inc/functions.php';

$categoryName = filter_input(INPUT_POST, "categoryName");

if (!isset($categoryName) || empty($categoryName)) {
  http_response_code(400);
  print json_encode(array("message" => "Tuoteryhmän nimi puuttuu"));
  exit;
}


try {
  $db = openDB();

  $responseMessage = checkCategory($db, $categoryName);

  http_response_code(200);
  print json_encode(array("message" => $responseMessage));

  exit();
} catch (PDOException $error) {
  returnError($error);
}


function checkCategory($db, $userInput) {
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

?>