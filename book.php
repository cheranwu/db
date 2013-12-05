<!DOCTYPE html>
<html lang="en">
<head>
  <title>Book</title>
</head>
<body id="page3">
<div class="main">
	<section id="content">
		<form id="form_5" class="form_5" method="post" action="/db/search.php">
			<div>
				<div class="pad">
					<div class="wrapper under">
						<div class="col1">
							<div class="row"><span class="left">From</span>
								<input type="text" name="org">
								<a href="#" class="help"></a>
							</div>
							<div class="row"><span class="left">To</span>
								<input type="text" name="dest">
								<a href="#" class="help"></a>
							</div>
						</div>
					</div>
					<div class="wrapper under">
						<div class="cols marg_right1">
							<span>Depart Date</span>
							<input type="text" name="depart" value="2013-12-05"  onblur="if(this.value=='') this.value='12/05/2013'" onFocus="if(this.value =='12/05/2013' ) this.value=''">
						</div>
					</div>
					<span class="right relative"><a href="#" class="button1" onClick="document.getElementById('form_5').submit()"><strong>Search</strong></a></span>
				</div>
			</div>
		</form>
	</section>
</div>
</body>
</html>