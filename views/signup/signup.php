<!DOCTYPE html>
<html>
	<head>
		<title>Profile Page</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<section id = "titleBox">
			<h1>Sign Up</h1>
		</section>

		<section id = "profileBox">
			<form id="form" class="minimal" method="post" action="">
				<div style = "text-align: center">
				    <label><input type="radio" name="position" value="student" id="student" align='center' />Student</label>
				    <label><input type="radio" name="position" value="recuritor" id="recruitor" align='center' />Recruitor</label>
				</div>
				<div style = "text-align: center">
				   	<label for="username">
						Username:
					<input type="text" name="username" id="username" required="required" />
					</label>
					<label for="eamil">
						E-Mail:
					<input type="email" name="email" id="email" required="required" />
					</label>
					<label for="password">
						Password:
						<input type="password" name="password" id="password" required="required" />
					</label>
					<label for="confirmpwd">
						Confirm Password:
						<input type="password" name="confirmpwd" id="confirmpwd" required="required" />
					</label>
					<button type="submit" class="btn-submit">Sign Up</button>
				</div>
			</form>
		</section>
	</body>
</html>
