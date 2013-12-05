<?php
include("classes/search.php");
include("classes/users.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Plane</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/add_flight.php">
			<div class="row"><span class="left">Type</span>
				<input type="text" name="type">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Number of Seats</span>
				<input type="text" name="numSeats">
				<a href="#" class="help"></a>
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Add Plane</strong></a></span>
		</form>
	</section>
</div>
</body>
</html>

<?php

function AddPlane(array $args) {
	$type = $args['type'];
	$numSeats = intval($args['numSeats']);
	
	if ($numSeats <= 0) {
		echo "Number of seats must be a positive integer.";
		return;
	}
	
	$user = new users();
	$user->insert(
		"Airplane",
		array('id' => 0, 'type' => $type, 'NumSeat' => $numSeats)
	);
}

// AddPlane(array('type' => 'boeing', 'numSeats' => 189));
?>