<?php
require_once '../inc/headers.php';
require_once '../inc/functions.php';

$db = null;
$input1 = file_get_contents('php://input');
$input = json_decode($input1);

$fname = filter_var($input->firstname,FILTER_SANITIZE_SPECIAL_CHARS);
$lname = filter_var($input->lastname,FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($input->email);
$number = filter_var($input->number, FILTER_SANITIZE_NUMBER_FLOAT);
$address = filter_var($input->address, FILTER_SANITIZE_SPECIAL_CHARS);
$zip = filter_var($input->zip, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$city = filter_var($input->city, FILTER_SANITIZE_SPECIAL_CHARS);
$cart = $input->cart;

try{
    $db = openDB(); // Open database connection.
    $db->beginTransaction();

  // Insert customer
  $sql = "insert into asiakas (etunimi, sukunimi, sahkoposti, puhnro, osoite, postinro, postitmp) values ('". 
    filter_var($fname,FILTER_SANITIZE_SPECIAL_CHARS). "','" .
    filter_var($lname,FILTER_SANITIZE_SPECIAL_CHARS). "','" .
    filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($number, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS). "','" .
    filter_var($zip, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($city, FILTER_SANITIZE_SPECIAL_CHARS). "')";
    
    $customer_id = executeInsert($db,$sql);
    //$array as $key => $value
    $sql = "insert into tilaus (asiakas_id, tila) values ($customer_id, 1)";
    $order_id = executeInsert($db,$sql);

    // Insert order rows by looping through cart (which is an array).
    
    foreach($cart as $key => $product){
      if ($product->alehinta > 0) {
        $sql = "insert into tilausrivi (tilausnro, rivinro, tuotenimi, kpl, kpl_hinta, tuote_id) values ("
        .
          $order_id . "," .
          $key + 1 . "," .
          "'" .  $product->tuotenimi . "'" . "," .
          $product->amount . "," .
          $product->alehinta . "," .
          $product->tuote_id
        .")";
      } else {
        $sql = "insert into tilausrivi (tilausnro, rivinro, tuotenimi, kpl, kpl_hinta, tuote_id) values ("
        .
          $order_id . "," .
          $key + 1 . "," .
          "'" .  $product->tuotenimi . "'" . "," .
          $product->amount . "," .
          $product->hinta . "," .
          $product->tuote_id
        .")";
      }
        
        executeInsert($db, $sql);
    }

    $db->commit(); // Commit transaction

    // Return 200 status and customer id.
    header("HTTP/1.1 200 OK");
    $data = array("id"=>$customer_id);
    echo json_encode($data);
}
catch (PDOException $pdoex) {
  $db->rollback(); // Error, rollback transaction.
  returnError($pdoex); // Return error with 500 status and message.
}