<?php
  function openDB() {
    return new PDO('mysql:host=localhost;dbname=shoppinglist;charset=utf8', 'root', '', [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  function returnError(PDOException $pdoex) {
    header('HTTP/1.1 500 Internal Server Error');
    $error = ['error' => $pdoex->getMessage()];
    print json_encode($error);
  }
