<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");


// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] != "DELETE") {
  response('fail', 'Access denied', null);
}

// Extract the resource ID from the URL
$url_parts = explode('/', $_SERVER['REQUEST_URI']);
$id = (int) end($url_parts);


if (empty($id) || $id < 1) {
  response('fail', 'invalid patient id or missing');
}
try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare('DELETE FROM patient WHERE PatientID = :id');
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    response('success', 'patient deleted successfully', null);
  } else {
    response('fail', 'patient not found', null);
  }
} catch (Exception $e) {
  response('fail', 'Could not delete patient', null);
}
