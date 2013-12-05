<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/finish_booking.php">
			<div>
				<div class="pad">
					<div class="row"><span class="left">Email</span>
						<input type="text" name="Email">
					</div>
					<div class="row"><span class="left">Name</span>
						<input type="text" name="Name">
					</div>
					<div class="row"><span class="left">Address</span>
						<input type="text" name="Address">
					</div>
					<div class="row"><span class="left">Phone</span>
						<input type="text" name="Phone">
					</div>
					<div class="row"><span class="left">Account Number</span>
						<input type="text" name="Account">
					</div>
					<div class="row"><span class="left">Account Holder's Name</span>
						<input type="text" name="Account_Name">
					</div>
					<div class="row"><span class="left">Price</span>
						<input type="text" name="Price">
					</div>
					<div style="visibility: hidden">
						<input type="text" name="Legs" value=<?=$_POST['Legs']?>>
						<input type="text" name="Depart" value=<?=$_POST['Depart']?>>
						<input type="text" name="Dest" value=<?=$_POST['Dest']?>>
					</div>
					<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Book!</strong></a></span>
				</div>
			</div>
		</form>
	</section>
</div>
</body>
</html>