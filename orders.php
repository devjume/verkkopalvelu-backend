<?php
require_once 'inc/headers.php';
require_once 'inc/functions.php';

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);


#
#if (!isset($id)) {
#  http_response_code(400);
#  print json_encode(array("error" => "Tuote ID puuttuu"));
#  exit;
#}

try {
  $db = openDB();

  if (!$db) {
    http_response_code(500);
    print json_encode(array("error" => "Tietokanta yhteys epäonnistui"));
    exit;
  }

  # Jos id:ta ei ole määritelty näytetään kaikki tilaukset ja niiden asiakkaat
  # Muuten näytetään tietyn tilauksen tilausrivit tilaus.id perusteella
  if(!isset($id)) {
    $sql = "SELECT DISTINCT asiakas.asiakas_id, asiakas.etunimi, asiakas.sukunimi, tilaus.tilausnro,  UNIX_TIMESTAMP(tilaus.tilauspvm) as pvm, tilausrivi.tilausnro
          FROM asiakas
          LEFT JOIN tilaus ON tilaus.asiakas_id = asiakas.asiakas_id
          LEFT JOIN tilausrivi ON tilausrivi.tilausnro = tilaus.tilausnro;";
    $pdo = $db->prepare($sql);
    $pdo->execute();
    $json = $pdo->fetchAll();
  } else {
    $sql = "SELECT tilaus.tilausnro, tilausrivi.rivinro, tilausrivi.tuotenimi, tilausrivi.kpl, tilausrivi.kpl_hinta, tilausrivi.summa
      FROM `asiakas`
      LEFT JOIN tilaus ON tilaus.asiakas_id = asiakas.asiakas_id
      LEFT JOIN tilausrivi ON tilausrivi.tilausnro = tilaus.tilausnro
      WHERE tilaus.tilausnro = ?";

      $pdo = $db->prepare($sql);  
      $pdo->bindParam(1, $id);
      $pdo->execute();
      $orderRows = $pdo->fetchAll();

    $customerDetailsQuery = "SELECT asiakas.etunimi, asiakas.sukunimi, asiakas.sahkoposti, asiakas.puhnro, asiakas.osoite, asiakas.postinro, asiakas.postitmp, UNIX_TIMESTAMP(tilaus.tilauspvm) as pvm
        FROM `asiakas`
        LEFT JOIN tilaus ON tilaus.asiakas_id = asiakas.asiakas_id
        WHERE tilaus.tilausnro = ?";
    
    $pdo = $db->prepare($customerDetailsQuery);
    $pdo->bindParam(1, $id);
    $pdo->execute();
    $customerDetails = $pdo->fetch(PDO::FETCH_OBJ);


      $json = array(
      "rows" => $orderRows,
      "firstname" => $customerDetails->etunimi,
      "lastname" => $customerDetails->sukunimi,
      "email" => $customerDetails->sahkoposti,
      "phone" => $customerDetails->puhnro,
      "address" => $customerDetails->osoite,
      "zip" => $customerDetails->postinro,
      "city" => $customerDetails->postitmp,
      "address" => $customerDetails->osoite,
      "orderDate" => $customerDetails->pvm
    );
  }


  http_response_code(200);
  print json_encode($json);
} catch (PDOException $error) {
  returnError($error);
}


#SELECT asiakas.asiakas_id, asiakas.etunimi, asiakas.sukunimi, tilaus.tilausnro, tilaus.tilauspvm, tilausrivi.tilausnro, tilausrivi.rivinro
#FROM `asiakas`
#LEFT JOIN tilaus ON tilaus.asiakas_id = asiakas.asiakas_id
#LEFT JOIN tilausrivi ON tilausrivi.tilausnro = tilaus.tilausnro
#WHERE asiakas.asiakas_id = 1;