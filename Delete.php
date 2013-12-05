<?php
include("classes/search.php");
include("classes/users.php");

function Delete($table, $id) {
	$user = new users();
	$keys = array(
		'FlightLeg' => 'LegNum',
		'Airport' => 'Code',
		'Airplane' => 'Id',
	);
	
	if (!array_key_exists($table, $keys)) {
		echo "You are only allowed to delete rows in FlightLeg, Airport, and Airplane.";
		return;
	}
	
	if ($id == 'FlightLeg') {
		$count = $user->run_sql("SELECT Count(*) FROM Leg WHERE FlightLegNum = " . $id . ";")[0]['Count(*)'];
		if ($count > 0) {
			echo "Unable to delete the flight leg because there are reservations on it.\n";
			return;
		}
	}
	
	$user->run_sql_insert("DELETE FROM $table WHERE $keys[$table] = '$id';");
}

if(array_key_exists('Secret',$_POST)) {
	Delete($_POST['table'], $_POST['id']);
	echo "Successfully Removed Entry";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Delete</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/Delete.php">
			<div class="row"><span class="left">Table</span>
				<input type="text" name="table">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">ID</span>
				<input type="text" name="id">
				<a href="#" class="help"></a>
			</div>
			<div style = "visibility: hidden">
				<input type="text" name="Secret" value="True">
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Delete</strong></a></span>
		</form>
		<div><a href="/db/admin.php"> Go back to admin index </a></div>
	</section>
</div>
</body>
</html>
