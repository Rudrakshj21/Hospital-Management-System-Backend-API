
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "GET") {
  response('fail', 'access denied ', null);
}

// Get the path of the current URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Split the URL path by "/"
$url_parts = explode('/', $url);

// The last element of the URL parts array contains the ID
$id =  end($url_parts);


if (empty($id)) {
  response('error', 'patient id missing');
}

try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare("SELECT * FROM patient where PatientID = :id");
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  if ($stmt->rowCount() != 0) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    response('fail', 'wrong id');
  }
  response('success', "fetched patient successfully", $data);
} catch (Exception $e) {
  response('fail', "could not fetch patient ");
}
