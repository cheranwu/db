<?php
include("classes/search.php");
include("classes/users.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Switch Plane</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/add_flight.php">
			<div class="row"><span class="left">Flight Leg ID</span>
				<input type="text" name="flightID">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">New Plane ID</span>
				<input type="text" name="planeID">
				<a href="#" class="help"></a>
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Add Plane</strong></a></span>
		</form>
	</section>
</div>
</body>
</html>

<?php

function SwitchPlanes($flightID, $planeID) {
	$user = new users();
	$count = $user->run_sql("SELECT Count(*) FROM Leg WHERE FlightLegNum = " . $flightID . ";")[0]['Count(*)'];
	$oldPlaneID = $user->run_sql("SELECT AirplaneNum FROM FlightLeg WHERE LegNum = " .$flightID . ";")[0]['AirplaneNum'];
	$oldSeats = $user->run_sql("SELECT NumSeat FROM Airplane WHERE Id = " . $oldPlaneID . ";")[0]['NumSeat'];
	$newSeats = $user->run_sql("SELECT NumSeat FROM Airplane WHERE Id = " . $planeID . ";")[0]['NumSeat'];
	if ($oldSeats >= $newSeats) {
		echo "You cannot make that the switch. The new plane must have more seats than the old one.\n";
		return;
	}
	
	$numSeats = $newSeats - $count;
	$user->run_sql_insert("UPDATE FlightLeg SET AirplaneNum = $planeID, NumSeatsAvailable = $numSeats WHERE LegNum = $flightID;");
}

// SwitchPlanes(2, 10);
?>