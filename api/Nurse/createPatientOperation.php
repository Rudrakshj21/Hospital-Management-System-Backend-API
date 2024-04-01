
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  response('fail', 'access denied ', null);
}

$PatientID = $_POST['PatientID'] ?? null;
$OperationType = $_POST['OperationType'] ?? null;
$OperationDate = $_POST['OperationDate'] ?? null;
$SurgeonID = $_POST['SurgeonID'] ?? null;
$Notes = $_POST['Notes'] ?? null;




if (empty($PatientID) || empty($OperationType) || empty($OperationDate) || empty($SurgeonID) || empty($Notes)) {
  response("fail", "one or more values is missing ");
}


try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare('INSERT INTO operation_record(PatientID,OperationType,OperationDate,SurgeonID,Notes)
  VALUES(:PatientID,:OperationType,:OperationDate,:SurgeonID, :Notes)');
  $stmt->bindParam(':PatientID', $PatientID);
  $stmt->bindParam(':OperationType', $OperationType);
  $stmt->bindParam(':OperationDate', $OperationDate);
  $stmt->bindParam(':SurgeonID', $SurgeonID);
  $stmt->bindParam(':Notes', $Notes);
  $stmt->execute();

  response('success', "created patient operation record successfully", $data);
} catch (Exception $e) {
  response('fail', "could not create patient operation record" . $e->getMessage());
}
