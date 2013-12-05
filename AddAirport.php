<?php
include("classes/search.php");
include("classes/users.php");

if(array_key_exists('Secret',$_POST)) {
	$user = new users();
	$user->insert("Airport", array('Code' => $_POST['Code'], 'City' => $_POST['City'], 'State' => $_POST['State'], 'Name' => $_POST['Name']));
	echo "Successfully added airport";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Airport</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/AddAirport.php">
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
			<div style = "visibility: hidden">
				<input type="text" name="Secret" value="True">
			</div>
			<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Add Plane</strong></a></span>
		</form>
		<div><a href="/db/admin.php"> Go back to admin index </a></div>
	</section>
</div>
</body>
</html>