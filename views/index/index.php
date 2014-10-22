<!DOCTYPE html>
<html>
	<head>
		<title>COMJOB</title>
	</head>
	<body>
		<section id = "titleBox">
			<h1>Let us find you a COMJOB</h1>
		</section>
		<section id="loginBox">
			<h2>Login</h2>
			<form method="post" class="minimal" action="">
				<label for="username">
					Username:
					<input type="text" name="username" id="username" required="required" />
				</label>
				<label for="password">
					Password:
					<input type="password" name="password" id="password" required="required" />
				</label>
				<button type="submit" class="btn-submit">Sign in</button>
			</form>
		</section>
		<section id = "newUserBox">
			<h3>Are you a new user?
				<form method="post" action="signup">
					<button type="newUser" class="btn-newUser">New User</button>
				</form>
			</h3>
		</section>
	</body>	
</html>