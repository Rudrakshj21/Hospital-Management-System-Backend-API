
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "GET") {
  response('fail', 'access denied ', null);
}



try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare("SELECT * FROM rooms");
  $stmt->execute();
  if ($stmt->rowCount() != 0) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  response('success', "fetched all rooms successfully", $data);
} catch (Exception $e) {
  response('fail', "could not fetch rooms ");
}
