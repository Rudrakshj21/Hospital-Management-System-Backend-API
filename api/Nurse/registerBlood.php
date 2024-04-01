
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  response('fail', 'access denied ', null);
}


$BloodType = $_POST['BloodType'] ?? null;
$Quantity = $_POST['Quantity'] ?? null;
$ExpiryDate = $_POST['ExpiryDate'] ?? null;
$Location = $_POST['Location'] ?? null;



if (empty($BloodType) || empty($Quantity) || empty($ExpiryDate) || empty($Location)) {
  response("fail", "one or more values is missing ");
}


try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare('INSERT INTO blood_bank(BloodType,Quantity,ExpiryDate,Location)
  VALUES(:BloodType,:Quantity,:ExpiryDate, :Location)');
  $stmt->bindParam(':BloodType', $BloodType);
  $stmt->bindParam(':Quantity', $Quantity);
  $stmt->bindParam(':ExpiryDate', $ExpiryDate);
  $stmt->bindParam(':Location', $Location);
  $stmt->execute();

  response('success', "created blood bank donation successfully", $data);
} catch (Exception $e) {
  response('fail', "could not create blood bank donation");
}
