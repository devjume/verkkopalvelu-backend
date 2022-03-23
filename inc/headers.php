<?php
  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  #header('Access-Control-Allow-Headers: Accept, Content-Type');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Max-Age: 3600');
  header('Content-type: application/json');

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
  }
