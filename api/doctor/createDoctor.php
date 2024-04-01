<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  response('fail', 'access denied ', null);
}

$Name = $_POST['Name'] ?? null;
$Designation = $_POST['Designation'] ?? null;
$Specialisation = $_POST['Specialisation'] ?? null;
$PhoneNo = $_POST['PhoneNo'] ?? null;
$Location = $_POST['Location'] ?? null;



if (empty($Name) || empty($Designation) || empty($Specialisation) || empty($PhoneNo) || empty($Location)) {
  response("fail", "one or more values is missing ");
}


try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare('INSERT INTO doctor(Name,Designation,Specialisation,PhoneNo,Location)
  VALUES(:Name,:Designation,:Specialisation,:PhoneNo, :Location)');
  $stmt->bindParam(':Name', $Name);
  $stmt->bindParam(':Designation', $Designation);
  $stmt->bindParam(':Specialisation', $Specialisation);
  $stmt->bindParam(':PhoneNo', $PhoneNo);
  $stmt->bindParam(':Location', $Location);
  $stmt->execute();
  response('success', "created doctor successfully");
} catch (Exception $e) {
  response('fail', "could not create doctor");
}
