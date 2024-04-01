<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  response("fail", 'access denied');
}

// read data 

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data)) {
  response('fail', 'data missing and must be send in request body');
}
$location = $data['location'] ?? null;
$patientID = $data['patientID'] ?? null;
$wardID = $data['wardID'] ?? null;

if (empty($location) || empty($patientID) || empty($wardID)) {
  response('fail', 'one or more fields is empty');
}

try {
  $pdo = generatePDO();

  $stmt = $pdo->prepare('INSERT INTO rooms(Location,patientID,wardID) VALUES (:Location,:patientID,:wardID)');
  $stmt->bindParam(':Location', $location);
  $stmt->bindParam(':patientID', $patientID);
  $stmt->bindParam(':wardID', $wardID);

  $stmt->execute();
  if ($stmt->rowCount() != 0) {
    response("success", "allocated room");
  } else {
    response("fail", "failed allocation of room ");
  }
} catch (Exception  $e) {
  response("fail", $e->getMessage());
}
