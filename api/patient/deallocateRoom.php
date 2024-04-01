<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "PATCH") {
  response("fail", 'access denied');
}


// Get the path of the current URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Split the URL path by "/"
$url_parts = explode('/', $url);

//The last element of the URL parts array contains the ID
$id = (int)  end($url_parts);


if (empty($id)) {
  response('error', 'room id missing');
}

try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare("UPDATE rooms SET PatientID = null WHERE PatientID = :id");
  $stmt->bindParam("id", $id);
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
    response('success', 'room deallocated successfully', null);
  } else {
    response('fail', 'room deallocation failed', null);
  }
} catch (Exception $e) {
  response('error', $e->getMessage());
}
