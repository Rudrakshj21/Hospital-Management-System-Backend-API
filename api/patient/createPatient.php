
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');
header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  response('fail', 'access denied ', null);
}


$Name = $_POST['Name'];
$PhoneNo = $_POST['PhoneNo'];
$Address = $_POST['Address'];
$Age =  $_POST["Age"];
$Sex = $_POST["Sex"];
$DoctorID =  $_POST['DoctorID'];


echo $Age . "<br>";

if (empty($Name) || empty($PhoneNo) || empty($Address) || empty($Age) || empty($Sex)) {
  response("fail", "one or more values is missing ");
}


try {
  $pdo = generatePDO();

  if (empty($DoctorID)) {
    $stmt = $pdo->prepare('INSERT INTO patient(Name,PhoneNo,Address,Age,Sex) VALUES(:Name,:PhoneNo,:Address,:Age, :Sex)');
  } else {
    $stmt = $pdo->prepare('INSERT INTO patient(Name,PhoneNo,Address,Age,Sex,DoctorID) VALUES(:Name,:PhoneNo,:Address,:Age, :Sex,:DoctorID)');
    $stmt->bindParam(":DoctorID", $DoctorID);
  }

  $stmt->bindParam(':Name', $Name);
  $stmt->bindParam(':Age', $PhoneNo);
  $stmt->bindParam(':Address', $Address);
  $stmt->bindParam(':Age', $Age);
  $stmt->bindParam(':PhoneNo', $PhoneNo);
  $stmt->bindParam(':Sex', $Sex);

  $stmt->execute();

  response('success', "created patient successfully");
} catch (Exception $e) {
  response('fail', "could not create patient", $e->getMessage());
}
