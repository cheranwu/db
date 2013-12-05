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
			<div class="row"><span class="left">Code</span>
				<input type="text" name="Code">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">City</span>
				<input type="text" name="City">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">State</span>
				<input type="text" name="State">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Name</span>
				<input type="text" name="Name">
				<a href="#" class="help"></a>
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Add Plane</strong></a></span>
		</form>
	</section>
</div>
</body>
</html>

<?php

function AddAirport(array $args) {
	$user = new users();
	$user->insert("FlightLeg", $args);
}

// AddPlane(array('type' => 'boeing', 'numSeats' => 189));
?>