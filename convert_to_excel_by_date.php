<?php
include('export.php');
include('inc/header.php');

// Define the number of records to display per page
$recordsPerPage = 10;

// Determine the current page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the records to be displayed
$offset = ($page - 1) * $recordsPerPage;

$query = "SELECT * FROM provider_data ORDER BY date_processed DESC LIMIT $recordsPerPage OFFSET $offset";
$results = mysqli_query($conn, $query) or die("database error:". mysqli_error($conn));
$allOrders = array();

while ($order = mysqli_fetch_assoc($results)) {
    $allOrders[] = $order;
}

$paginationQuery = "SELECT COUNT(*) as total FROM provider_data";
$paginationResult = mysqli_query($conn, $paginationQuery) or die("database error:". mysqli_error($conn));
$row = mysqli_fetch_assoc($paginationResult);
$totalRecords = $row['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);
?>

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
<link href="bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="css_sidebar/styles.css" rel="stylesheet" />
<link href="css_form/styles.css" rel="stylesheet" />
<link href="css_form/toggle_button.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="js/datepickers.js"></script>
</head>

<style>
.input-daterange input {
  text-align: left;
}
</style>


<div class="container">
<br>
<div class="row">
 <form method="post">
  <div class="input-daterange">
   <div class="col-md-4">
	Start Date:<input type="text" name="fromDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly />
	<?php echo $startDateMessage; ?>
   </div>
   <div class="col-md-3">
	End Date:<input type="text" name="toDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" readonly />
	<?php echo $endDate; ?>
   </div>
  </div>
    <div class="col-auto"><div>&nbsp;</div>
        <input type="submit" name="export" value="Export to CSV" class="btn btn-success btn-lg" />
        <a href="entries.php" class="btn btn-outline-success btn-lg" tabindex="-1" role="button" aria-disabled="true">Back to Entries</a> 
    </div>
 </form>
</div>

<div class="row">
	<div class="col-md-8">
		<?php echo $noResult;?>
	</div>
</div>
<br />
<table class="table table-bordered table-striped">
 <thead>
  <tr>
   <th>Country</th>
   <th>First Name</th>
   <th>Middle Name</th>
   <th>Last Name</th>
   <th>Profession</th>
   <th>License #</th>
   <th>Sanction Description</th>

   <th>Processed Date</th>
  </tr>
 </thead>
 <div class='pagination'>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="convert_to_excel_by_date.php?page=<?php echo ($page - 1); ?>">Previous</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="convert_to_excel_by_date.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li class="page-item"><a class="page-link" href="convert_to_excel_by_date.php?page=<?php echo ($page + 1); ?>">Next</a></li>
        <?php endif; ?>
    </ul>
    </div>
</div>
 <tbody>
  <?php
  foreach($allOrders as $order) {
   echo '
    <tr>
        <td>'.$order["country"].'</td>
        <td>'.$order["fname"].'</td>
        <td>'.$order["mname"].'</td>
        <td>'.$order["lname"].'</td>
        <td>'.$order["profession"].'</td>
        <td>'.$order["license_number"].'</td>
        <td>'.$order["provider_sanction"].'</td>
        <td>'.$order["date_processed"].'</td>
    </tr>
   ';
  }
  ?>
 </tbody>
</table>

