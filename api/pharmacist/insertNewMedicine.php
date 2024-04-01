<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  response('fail', 'access denied ', null);
}

$Name = $_POST['Name'] ?? null;
$Description = $_POST['Description'] ?? null;
$Manufacturer = $_POST['Manufacturer'] ?? null;
$DosageForm = $_POST['DosageForm'] ?? null;
$Strength = $_POST['Strength'] ?? null;
$stock = $_POST['Stock'] ?? null;
$categoryID = $_POST['categoryID'] ?? null;

echo $stock;

if (empty($Name) || empty($Description) || empty($Manufacturer) || empty($DosageForm) || empty($Strength) || empty($stock) || empty($categoryID)) {
  response("fail", "one or more values is missing ");
}


try {
  $pdo = generatePDO();
  $stmt = $pdo->prepare('INSERT INTO medicine(Name,Description,Manufacturer,DosageForm,Strength,stock,categoryID)
  VALUES(:Name,:Description,:Manufacturer,:DosageForm, :Strength,:stock,:categoryID)');
  $stmt->bindParam(':Name', $Name);
  $stmt->bindParam(':Description', $Description);
  $stmt->bindParam(':Manufacturer', $Manufacturer);
  $stmt->bindParam(':DosageForm', $DosageForm);
  $stmt->bindParam(':Strength', $Strength);
  $stmt->bindParam(':stock', $stock);
  $stmt->bindParam(':categoryID', $categoryID);
  $stmt->execute();
  response('success', "created medicine successfully");
} catch (Exception $e) {
  response('fail', "could not create medicine" . $e->getMessage());
}
