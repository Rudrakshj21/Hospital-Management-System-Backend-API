
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
  $stmt = $pdo->prepare("SELECT * FROM bills");
  $stmt->execute();
  if ($stmt->rowCount() != 0) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    response('success', "fetched all bills successfully", $data);
  } else {
    response('fail', 'bill fetching failed');
  }
} catch (Exception $e) {
  response('error', $e->getMessage());
}
