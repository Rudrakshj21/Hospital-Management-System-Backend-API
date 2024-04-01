
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  response('fail', 'access denied ', null);
}

$PatientID = $_POST['PatientID'] ?? null;
$DoctorID = $_POST['DoctorID'] ?? null;
$PrescriptionDate = $_POST['PrescriptionDate'] ?? null;
$Medication = $_POST['Medication'] ?? null;
$Dosage = $_POST['Dosage'] ?? null;
$Instructions = $_POST['Instructions'] ?? null;
$quantity = $_POST['quantity'] ?? null;


if (empty($PatientID) || empty($DoctorID) || empty($PrescriptionDate) || empty($Medication) || empty($Dosage) || empty($Instructions) || empty($quantity)) {
  response("fail", "one or more values is missing ");
}


try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare('INSERT INTO prescription(PatientID,DoctorID,PrescriptionDate,Medication,Dosage,Instructions,quantity)
  VALUES(:PatientID,:DoctorID,:PrescriptionDate,:Medication, :Dosage, :Instructions,:quantity)');
  $stmt->bindParam(':PatientID', $PatientID);
  $stmt->bindParam(':DoctorID', $DoctorID);
  $stmt->bindParam(':PrescriptionDate', $PrescriptionDate);
  $stmt->bindParam(':Medication', $Medication);
  $stmt->bindParam(':Dosage', $Dosage);
  $stmt->bindParam(':Instructions', $Instructions);
  $stmt->bindParam(':quantity', $quantity);
  $stmt->execute();

  response('success', "created patient prescription  successfully");
} catch (Exception $e) {
  response('fail', "could not create patient prescription " . $e->getMessage());
}
