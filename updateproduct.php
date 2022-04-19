<?php
require_once "./inc/functions.php";
require_once "./inc/headers.php";

$tuotenimi = filter_input(INPUT_POST, "tuotenimi");
$hinta = filter_input(INPUT_POST, "hinta");
$alehinta = filter_input(INPUT_POST, "alehinta");
$kuvaus = filter_input(INPUT_POST, "kuvaus");
$valmistaja = filter_input(INPUT_POST, "valmistaja");
$kuvatiedosto = filter_input(INPUT_POST, "kuvatiedosto");
$id = filter_input(INPUT_POST, "id");

$hinta = str_replace(',', '.', $hinta);
$alehinta =  str_replace(',', '.', $alehinta);


echo $hinta . $alehinta;

try {
  $db = openDB();

  if (!$db) {
    echo "Database connection Failed!";
  }

  $sql = "UPDATE `tuote` SET `tuotenimi`=? , `hinta`=? , `alehinta`=? , `kuvaus`=? , `valmistaja`=? ,`kuvatiedosto`=? WHERE tuote_id = ?";

  $pdoStatement = $db->prepare($sql);
  $pdoStatement->bindParam(1, $tuotenimi);
  $pdoStatement->bindParam(2, $hinta);
  $pdoStatement->bindParam(3, $alehinta);
  $pdoStatement->bindParam(4, $kuvaus);
  $pdoStatement->bindParam(5, $valmistaja);
  $pdoStatement->bindParam(6, $kuvatiedosto);
  $pdoStatement->bindParam(7, $id);
  

  $pdoStatement->execute();

  exit();

} catch (PDOException $e) {
  returnError($e);
}

