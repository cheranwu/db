<?php
include("classes/users.php");
include("classes/flight.php");

$flights = Flight::get_all_flights();
foreach($flights as $flight) {
	print($flight);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/add_flight.php">
			<div class="row"><span class="left">From</span>
				<input type="text" name="org">
			</div>
			<div class="row"><span class="left">To</span>
				<input type="text" name="dest">
			</div>
			<div class="row"><span class="left">Date</span>
				<input type="text" name="date">
			</div>
			<div class="row"><span class="left">DepartTime</span>
				<input type="text" name="departTime">
			</div>
			<div class="row"><span class="left">ArriveTime</span>
				<input type="text" name="arriveTime">
			</div>
			<div class="row"><span class="left">PlaneID</span>
				<input type="text" name="planeID">
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Add Flight</strong></a></span>
		</form>
	</section>
</div>
</body>
</html>