<?php
include("classes/search.php");
include("classes/users.php");
$user = new users();
//convert passed in day/month/year into epoch times

$_POST['e_depart_time'] = mktime(0,0,0,intval(substr($_POST['depart'],5,7)),intval(substr($_POST['depart'],8,10)),intval(substr($_POST['depart'],0,4)));

//find routes
$routes = new Search($_POST, $user);
$a = $_POST['org'];
$b = $_POST['dest'];
$to_routes = $routes->depart_routes;

$option_num = 1;
if(count($to_routes) == 0){
    echo "Sorry, no flights available";
}?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pick a Flight</title>
</head>
<body><div>
	<form class="flight_selection" action="confirm_flight.php" method="POST">
	<div style = "visibility: hidden">
		<input type="text" name="Depart" value=<?=$_POST['org']?>>
		<input type="text" name="Dest" value=<?=$_POST['dest']?>>
	</div>
	<table border = "1">
		<tr><td colspan='6'><center><b><?=$a?></b> to <b><?=$b?></b><center></td></tr>
		<tr>
			<td style='width: 50px'><center>Option</center></td>
			<td style='width: 150px'><center>Depart Time</center></td>
			<td style='width: 150px'><center>Arrival Time</center></td>
			<td style='width: 50px'><center>Layovers</center></td>
			<td style='width: 75px'><center>Open Seats</center></td>
			<td style='width: 50px'><center>Book</center></td>
		</tr>    

	<?php foreach($to_routes as $option) {?>
		<tr>
			<td><center><?=$option_num?></center></td>
			<?=$option->to_string()?>
		</tr>
	<?php $option_num++;}?>

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
	<?php
		if( $to_routes != null)
		{
			?>
			<td><input type='submit' value='Reserve Flight'></td> <?php
		}
		else
			
	?>
		</tr>
	</table>
	</form>
</div></body></html>