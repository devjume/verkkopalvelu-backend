<?php
  require_once 'inc/headers.php';
  require_once 'inc/functions.php';

  try {
    http_response_code(200);
    print json_encode(array("Hello" => "World"));

  } catch(PDOException $e) {
    returnError($e);
  }
