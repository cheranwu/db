<?php
include("classes/search.php");
include("classes/users.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Leg</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/add_flight.php">
			<div class="row"><span class="left">Plane ID</span>
				<input type="text" name="AirplaneNum">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Origin</span>
				<input type="text" name="DepartureAirport">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Departure Time</span>
				<input type="text" name="DepartureTime">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Destination</span>
				<input type="text" name="ArrivalAirport">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Arrival Time</span>
				<input type="text" name="ArrivalTime">
				<a href="#" class="help"></a>
			</div>
			<div class="row"><span class="left">Date</span>
				<input type="text" name="Date">
				<a href="#" class="help"></a>
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Add Plane</strong></a></span>
		</form>
	</section>
</div>
</body>
</html>

<?php

function AddLeg(array $args) {
	$user = new users();
	$numSeats = $user->run_sql("SELECT NumSeat FROM Airplane WHERE Id = " . $args['AirplaneNum'] . ";")[0]['NumSeat'];
	
	if ($numSeats <= 0) {
		echo "Number of seats must be a positive integer.";
		return;
	}
	
	$args['NumSeatsAvailable'] = $numSeats;
	
	$user->insert("FlightLeg", $args);
}
AddLeg(array('AirplaneNum' => 2, 'DepartureAirport' => 'LAX', 'ArrivalAirport' => 'JFK', 'DepartureTime' => '12:00:00', 'ArrivalTime' => '18:00:00', 'Date' => '12-10-13'));
?>