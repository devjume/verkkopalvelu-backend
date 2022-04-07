<?php
require_once "./inc/functions.php";
require_once "./inc/headers.php";

$tuotenimi = filter_input(INPUT_POST, "tuotenimi");
$hinta = filter_input(INPUT_POST, "hinta", FILTER_VALIDATE_INT);
$alehinta = filter_input(INPUT_POST, "alehinta");
$kuvaus = filter_input(INPUT_POST, "kuvaus");
$valmistaja = filter_input(INPUT_POST, "valmistaja");
$kuvatiedosto = filter_input(INPUT_POST, "kuvatiedosto");
$tuoteryhma = filter_input(INPUT_POST, "tuoteryhma");

# Tarkistaa, että kaikki vaadittavat parametrit on löytyy
if (!isset($tuotenimi) || !isset($hinta) || empty($tuotenimi) || empty($hinta)) {
  http_response_code(400);
  print json_encode(array("error" => "Parametreja puuttui"));
  exit;
}

try {
  $db = openDB();

  if (!$db) {
    echo "Database connection Failed!";
  }
  
  ## TEE TÄSSÄ ENSIN GENRE ID JA OHJAAJA ID TARKASTUS JA MAHDOLLINEN LUONTI

  $sql = "INSERT INTO tuote (tuotenimi, hinta, kuvaus, valmistaja, kuvatiedosto, tuoteryhma_id, alehinta) VALUES (?,?,?,?,?,?,?)";

  $pdoStatement = $db->prepare($sql);
  $pdoStatement->bindParam(1, $tuotenimi);
  $pdoStatement->bindParam(2, $hinta);
  $pdoStatement->bindParam(3, $kuvaus);
  $pdoStatement->bindParam(4, $valmistaja);
  $pdoStatement->bindParam(5, $kuvatiedosto);
  $pdoStatement->bindParam(6, $tuoteryhma);
  $pdoStatement->bindParam(7, $alehinta);

  $pdoStatement->execute();

  # Tee tästä paremi -> palauta vain json ja tee frontendissä sen näyttäminen -> poista page auto refresh after post
  #header("Location: http://localhost/xx/workTime.php", true, 301);
  #echo "Käyttäjälle:" . $personid . " lisättiin uusi työaika merkintä.";
  #http_response_code(201);
  #print json_encode((array("success" => "Käyttäjälle: " . $personid . " lisättiin uusi työaika merkintä.")));
  exit();
  #header('Content-type: text/html');

} catch (PDOException $e) {
  returnError($e);
}



#echo $tuotenimi;
#echo "<br>";
#echo $vuosi;
#echo "<br>";
#echo $kesto;
#echo "<br>";
#echo $kieli;
#echo "<br>";
#echo $ikaraja;
#echo "<br>";
#echo $ohjaaja;
#echo "<br>";
#echo $genre;
#echo "<br>";
#echo "<br>";
#
#foreach($nayttelijat as $x) {
#  echo $x['tuotenimi'];
#  echo "<br>";
#  echo $x['rooli'];
#  echo "<br>";
#  echo $x['sukupuoli'];
#  echo "<br>";
#  echo "<br>";
#}
