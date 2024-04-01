<?php


function generatePDO()
{
  $username = "root";
  $password = "root";
  $host = "localhost";
  $database = "hospital";
  $dsn = "mysql:host=$host;dbname=$database";
  try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo  "database connected ✅";
    return $pdo;
  } catch (Exception $e) {
    // echo "database connection failed ❌ ";
    echo $e->getMessage();
    return false;
  }
}

