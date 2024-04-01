<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "PATCH") {
  response("fail", 'access denied');
}

// read data 

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data) || empty($data["NurseID"])) {
  response('fail', 'data missing and must be send in request body');
}

try {
  $pdo = generatePDO();
  $query = "UPDATE nurse SET ";
  foreach ($data as $col_name => &$val) {
    // do not update the id
    if ($col_name == 'NurseID') {
      continue;
    }
    // echo $col_name . " " . $val . "\n";
    // for binding params
    $query .= $col_name . '=' . ':' . $col_name . ",";
  }
  // $stmt = $pdo->prepare($query);
  // $stmt->execute();
  $query =  rtrim($query, ',');

  $query .= " WHERE NurseID = :NurseID";

  // echo $query;

  $stmt = $pdo->prepare($query);
  // binding params
  $stmt->bindParam(":NurseID", $data["NurseID"]);
  foreach ($data as $col_name => &$val) {
    if ($col_name != 'NurseID') {
      $stmt->bindParam(":" . $col_name, $val, PDO::PARAM_STR); // Specify the data type
    }
  }
  // var_dump($stmt);

  $stmt->execute();
  // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  response("success", "updated Nurse");
} catch (Exception  $e) {
  response("fail", $e->getMessage());
}

// echo json_encode($data);
