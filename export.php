<?php
include_once("inc/db_connect.php");
$query = "SELECT * FROM provider_data ORDER BY date_processed DESC";
$results = mysqli_query($conn, $query) or die("database error:". mysqli_error($conn));
$allOrders = array();
while( $order = mysqli_fetch_assoc($results) ) {
	$allOrders[] = $order;
}
$startDateMessage = '';
$endDate = '';
$noResult ='';
if(isset($_POST["export"])){
 if(empty($_POST["fromDate"])){
  $startDateMessage = '<label class="text-danger">Select start date.</label>';
 }else if(empty($_POST["toDate"])){
  $endDate = '<label class="text-danger">Select end date.</label>';
 } else {  
  $orderQuery = "
	SELECT * FROM provider_data 
	WHERE date_processed >= '".$_POST["fromDate"]."' AND date_processed <= '".$_POST["toDate"]."' ORDER BY date_processed DESC";
  $orderResult = mysqli_query($conn, $orderQuery) or die("database error:". mysqli_error($conn));
  $filterOrders = array();
  while( $order = mysqli_fetch_assoc($orderResult) ) {
	$filterOrders[] = $order;
  }
  if(count($filterOrders)) {
	  $fileName = "export_".date('Ymd') . ".csv";
	  header("Content-Description: File Transfer");
	  header("Content-Disposition: attachment; filename=$fileName");
	  header("Content-Type: application/csv;");
	  $file = fopen('php://output', 'w');
	  $header = array(
		"id",
		"country", 
		"First Name", 
		"Middle Name",
		"Last Name",
		"Maturity Suffx",
		"Profession", 
		"License Number", 
		"document name", 
		"Address", 
		"birthdate", 
		"Sanction Description", 
		"date processed"
	);
	
	  fputcsv($file, $header);  
	  foreach($filterOrders as $order) {
	   $orderData = array();
	   $orderData[] = $order["id"];
	   $orderData[] = $order["country"];
	   $orderData[] = $order["fname"];
	   $orderData[] = $order["mname"];
	   $orderData[] = $order["lname"];
	   $orderData[] = $order["maturity_suffix"];
	   $orderData[] = $order["profession"];
	   $orderData[] = $order["license_number"];
	   $orderData[] = $order["document_name"];
	   $orderData[] = $order["provider_address"];
	   $orderData[] = $order["birthdate"];
	   $orderData[] = $order["provider_sanction"];
	   $orderData[] = $order["date_processed"];
	   fputcsv($file, $orderData);
	  }
	  fclose($file);
	  exit;
  } else {
	 $noResult = '<label class="text-danger">There are no record exist with this date range to export. Please choose different date range.</label>';  
  }
 }
}
?>