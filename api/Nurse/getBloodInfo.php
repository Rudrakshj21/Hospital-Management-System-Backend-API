
<?php
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

require_once('./../utils/response.php');
require_once('./../db/connection.php');
if ($_SERVER['REQUEST_METHOD'] != "GET") {
  response('fail', 'access denied ', null);
}


try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare("SELECT * FROM blood_bank");
  $stmt->execute();
  if ($stmt->rowCount() != 0) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    response('success', "fetched all blood bank donations successfully", $data);
  } else {
    response('success', "fetching all blood bank donations failde", $data);
  }
} catch (Exception $e) {
  response('fail', "could not fetch donations ");
}
