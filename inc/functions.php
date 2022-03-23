<?php
  function openDB() {
    $ini = parse_ini_file("config.ini");

    $host = $ini["host"];
    $database = $ini["database"];
    $user = $ini["user"];
    $password = $ini["password"];
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8";

    return new PDO($dsn, $user, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }

  function selectAsJson(object $db, string $sql) :void {
    $query = $db->query($sql);
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    print json_encode($results);

  }

  function executeInsert(object $db, string $sql): int {
    $query = $db->query($sql);
    return $db->lastInsertId();
  }

  function returnError(PDOException $pdoex) {
    http_response_code(500);
    $error = ['error' => $pdoex->getMessage()];
    print json_encode($error);
    exit();
  }

?>