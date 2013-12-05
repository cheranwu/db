<?php
	include("classes/users.php");
	$user = new users();
	$flight_legs = explode("_", $_POST['Legs']);
	$reservation = array("Email" => $_POST['Email'],"Name"=>$_POST['Name'], "Addr"=> $_POST['Address'], "Phone" => $_POST['Phone'], "ReserveDate" => strtotime("now"));
	$user->insert("Reservation", $reservation);
	$resNum = $user->run_sql("SELECT MAX(ReservationNum) as MAX FROM Reservation;")[0]['MAX'];
	$trip = array("Airline" => "Fake", "Price" => $_POST["Price"], "Departure" => $_POST["Depart"], "Destination" => $_POST["Dest"], "NumLegs" => count($flight_legs)-1);
	$user->insert("Trip", $trip);
	$tripNum = $user->run_sql("SELECT MAX(TripNum) as MAX FROM Trip;")[0]['MAX'];
	$payment = array("TripNum" => $tripNum, "ReservationNum" => $resNum, "TransactionNum" => $tripNum + $resNum, "PaymentDate" => strtotime("now"), "Account" => $_POST["Account"], "Name" => $_POST["Account_Name"]);
	$user->insert("Payment", $payment);
	for($i = 0; $i < count($flight_legs)-1; $i++) {
		$leg = array("TripNum" => $tripNum, "FlightLegNum" => $flight_legs[$i]);
		$user->insert("Leg", $leg);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book</title>
</head>
<body id="page3">
<div class="main">
	<h1> Booking Successful! <a href="/db/index.php"> Click here to go back to Home </a> </h1>
</div>
</body>
</html>