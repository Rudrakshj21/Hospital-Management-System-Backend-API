
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
  $stmt = $pdo->prepare('SELECT m.Name AS MedicineName, mc.Name AS CategoryName, m.Description, m.Manufacturer, m.DosageForm, m.Strength, m.stock,m.price
FROM medicine m
INNER JOIN medicine_category mc ON m.categoryID = mc.id;
');

  $stmt->execute();
  if ($stmt->rowCount() != 0) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  response('success', "fetched all medicine successfully", $data);
} catch (Exception $e) {
  response('fail', "could not fetch medicine ");
}
