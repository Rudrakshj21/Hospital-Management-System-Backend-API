<?php
require_once("./../db/connection.php");
function response($status = "fail", $message = "", $data = null)
{
  if ($status == 'fail') {
    header("HTTP/1.0 400");
  }
  if ($status == 'error') {
    header("HTTP/1.0 404");
  }
  if ($status == "success") {
    header("HTTP/1.0 200");
  }
  echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
  exit();
}


function insert_bill_in_db($data)
{
  $patientID = $data[0]['patient_id'];
  $total_price = $data[0]['total_price'];
  // generates unique number with BILL prefix
  $BillNo = uniqid("BILL");
  $PatientName = get_patient_Name($patientID);
  try {
    $pdo = generatePDO();
    $stmt = $pdo->prepare("INSERT INTO bills (PatientName,BillNo,Amount) VALUES(:PatientName,:BillNo,:Amount)");
    $stmt->bindParam(":Amount", $total_price);
    $stmt->bindParam(":PatientName", $PatientName);
    $stmt->bindParam(":BillNo", $BillNo);
    $stmt->execute();
    return true;
  } catch (Exception $e) {
    response('error', $e->getMessage());
  }
}


function get_patient_Name($id)
{

  try {
    $pdo = generatePDO();
    // echo $id;
    $stmt = $pdo->prepare("SELECT Name from patient where PatientID =:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if ($stmt->rowCount() != 0) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['Name'];
    } else {
      response('fail', 'cannot get patient name');
    }
  } catch (Exception $e) {
    response('error', $e->getMessage());
  }
}
