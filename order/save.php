<?php
require_once '../inc/headers.php';
require_once '../inc/functions.php';

$db = null;
$input = file_get_contents('php://input');
$input = json_decode($input);

print($input);
$fname = filter_var($input->firstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lname = filter_var($input->lastname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_var($input->email);
$number = filter_var($input->number, FILTER_SANITIZE_NUMBER_FLOAT);
$address = filter_var($input->address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$zip = filter_var($input->zip, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$city = filter_var($input->city, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cart = $input->cart;

try{
    $db = openDB(); // Open database connection.
    $db->beginTransaction();

  // Insert customer
  $sql = "insert into asiakas (etunimi, sukunimi, sahkoposti, puhnro, osoite, postinro, postitmp) values ('". 
    filter_var($fname, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($lname, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($number, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($address, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($zip, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "','" .
    filter_var($city, FILTER_SANITIZE_FULL_SPECIAL_CHARS). "')";
    
    $customer_id = executeInsert($db,$sql);


    // Insert order rows by looping through cart (which is an array).
    foreach($cart as $product){
        $sql = "insert into tilausrivi (tilausnro, tuote_id) values ("
        .
          $order_id . "," .
          $product->id
        .")";
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