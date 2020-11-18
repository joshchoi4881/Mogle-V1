<!DOCTYPE html>
<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include("classes/Database.php");
	$success = false;
	if(isset($_POST["createAccount"])) {
		$firstName = $_POST["firstName"];
		$lastName = $_POST["lastName"];
		$email1 = $_POST["email1"];
		$email2 = $_POST["email2"];
		$password1 = $_POST["password1"];
		$password2 = $_POST["password2"];
		$location = $_POST["location"];
		$timeZone = "America/New_York";
		$timeStamp = time();
		$dateTime = new DateTime("now", new DateTimeZone($timeZone));
		$dateTime->setTimestamp($timeStamp);
		if(strlen($password1) >= 5 && strlen($password1) <= 32) {
			if($password1 == $password2) {
				if($email1 == $email2) {
					if(filter_var($email1, FILTER_VALIDATE_EMAIL)) {
						if(!Database::query("SELECT email FROM users WHERE email=:email", array(":email"=>$email1))) {
							$id = Database::query("INSERT INTO users VALUES (:id, :firstName, :lastName, :email, :pswd, :loc, :signUpDate, :accountType, :profilePicture)", array(":id"=>null, ":firstName"=>$firstName, ":lastName"=>$lastName, ":email"=>$email1, ":pswd"=>password_hash($password1, PASSWORD_BCRYPT), ":loc"=>$location ,":signUpDate"=>$dateTime->format("m-d-y, h:i:s A"), ":accountType"=>0, ":profilePicture"=>null));
							Database::query("INSERT INTO userProfiles VALUES (:id, :userId, :bio)", array(":id"=>null, ":userId"=>$id, ":bio"=>""));
							echo "Success! <a href='login.php'>Login</a> to begin";
							#die("<h1>Welcome to Mogle</h1><br/><p><a href=\"login.php\">Log in</a> to begin</p>");
							#$success = true;
						} else {
							echo "Email already in use";
						}
					} else {
						echo "Invalid email";
					}
				} else {
					echo "Emails don't match";
				}
			} else {
				echo "Passwords don't match";
			}
		} else {
			echo "Password must be between 5 and 32 characters long";
		}
	}
?>
<html lang="en">
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Maximizing Human Capital in the Gig Economy">
        <meta name="keywords" content="Mogle, Gig Economy, Human Capital">
        <meta name="author" content="Josh Choi">
		<title>Mogle</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
		<link rel="stylesheet" type="text/css" href="css/mogle.css"/>
		<!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-138974831-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-138974831-2');
		</script>
		<!-- Firebase -->
		<!-- The core Firebase JS SDK is always required and must be listed first -->
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>
		<!-- TODO: Add SDKs for Firebase products that you want to use
			https://firebase.google.com/docs/web/setup#available-libraries -->
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-analytics.js"></script>
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-firestore.js"></script>
		<script>
			// Your web app's Firebase configuration
			var firebaseConfig = {
				apiKey: "AIzaSyDkdhG0FRBaJ2LlMSLpV3Xd2eqlbKzUnSU",
				authDomain: "mogleapp4881.firebaseapp.com",
				databaseURL: "https://mogleapp4881.firebaseio.com",
				projectId: "mogleapp4881",
				storageBucket: "mogleapp4881.appspot.com",
				messagingSenderId: "619304884169",
				appId: "1:619304884169:web:d0203971e1071253f97a18",
				measurementId: "G-W1HNG10V6G"
			};
			// Initialize Firebase
			firebase.initializeApp(firebaseConfig);
			firebase.analytics();
		</script>
	</head>
	<body>
		<header id="header">
            <div id="info">
                <a href="about.php">About</a>
                <!--
                <a href="team.php">Team</a>
                -->
            </div>
            <a href="homepage.php"><img id="logo" src="photos/design/mogle.png" alt="Mogle Logo"/></a>
            <div id="account">
                <a id="signUp" href="signUp.php">Sign Up</a>
                <a href="login.php">Login</a>
            </div>
        </header>
		<section class="center">
			<div class="card">
				<h1 id="heading">Sign Up</h1>
				<br/>
				<form id="signUpForm" class="left" action="signUp.php" method="POST" enctype="multipart/form-data">
					<label>First Name</label>
					<input type="text" name="firstName" placeholder="Enter first name" required autofocus/>
					<br/>
					<br/>
					<label>Last Name</label>
					<input type="text" name="lastName" placeholder="Enter last name" required/>
					<br/>
					<br/>
					<label>Email</label>
					<input type="text" name="email1" placeholder="Enter email" required/>
					<br/>
					<br/>
					<label>Confirm Email</label>
					<input type="text" name="email2" placeholder="Re-enter email" required/>
					<br/>
					<br/>
					<label>Password</label>
					<input type="password" name="password1" placeholder="Enter password" required/>
					<br/>
					<br/>
					<label>Confirm Password</label>
					<input type="password" name="password2" placeholder="Re-enter password" required/>
					<br/>
					<br/>
					<label>Optional City and State*</label>
					<input type="text" name="location" placeholder="Ellicott City, MD"/>
					<br/>
					<small>*Enter your city and state if you would like data for your location</small>
					<br/>
					<br/>
					<div class="submitForm center">
						<input type="submit" name="createAccount" value="Create Account"/>
					</div>
				</form>
			</div>
		</section>
		<script>
            $(function() {
				$("#signUp").css({"background-color": "#800000", "color": "#fff"});
			});
		</script>
		<script src="js/mogle.js"></script>
		<!--
		<script src="js/firebase/auth.js"></script>
		<?php
#			if($success) {
#				echo "<script>
#						$('#heading').html('Welcome to Mogle');
#						$('#signUpForm').before('<p><a href=\"login.php\">Log in</a> to begin</p><input id=\"email\" style=\"display:none\" type=\"text\" value=\"".$email1."\"/><input id=\"password\" style=\"display:none\" type=\"password\" value=\"".$password1."\"/>');
#						$('#signUpForm').hide();
#						signUp();
#					</script>";
#			}
		?>
		-->
	</body>
</html>