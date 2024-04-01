
<?php
require_once('./../utils/response.php');
require_once('./../db/connection.php');

header("Access-Control-Allow-Origin:*");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] != "GET") {
  response('fail', 'access denied ', null);
}


$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);


$url_parts = explode('/', $url);

$patientID = end($url_parts);

if (str_ends_with($patientID, ".php") || empty($url) || empty($patientID)) {
  response("fail", "patient id missing");
}




try {
  $pdo = generatePDO();
  $query = "WITH patient_price_per_medicine AS (
    SELECT 
        medicine.Name AS Name,
        medicine.price AS price,
        prescription.`PatientID` AS id,
        prescription.quantity,
        (medicine.price * prescription.quantity) AS price_quantity 
    FROM 
        medicine 
    INNER JOIN 
        prescription ON medicine.`Name` = prescription.`Medication`
    WHERE 
        prescription.`PatientID` = :patientID
)
SELECT 
    patient_price_per_medicine.id AS patient_id, 
    SUM(patient_price_per_medicine.price_quantity) AS total_price
FROM 
    patient_price_per_medicine;
  ";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(":patientID", $patientID);
  $stmt->execute();
  if ($stmt->rowCount() != 0)
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (insert_bill_in_db($data)) {
    response('success', "generated bill successfully", $data);
  } else {
    response('fail', 'could not generate bill ');
  }
} catch (Exception $e) {
  response('fail', "could not generate bill");
}
