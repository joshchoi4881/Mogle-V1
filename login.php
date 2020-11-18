<!DOCTYPE html>
<?php
	include("classes/Database.php");
	$success = false;
	if(isset($_POST["login"])) {
		$email = $_POST["email"];
		$password = $_POST["password"];
		if(Database::query("SELECT email FROM users WHERE email=:email", array(":email"=>$email))) {
			if(password_verify($password, Database::query("SELECT password FROM users WHERE email=:email", array(":email"=>$email))[0]["password"])) {
				$cstrong = True;
				$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
				$userId = Database::query("SELECT id FROM users WHERE email=:email", array(":email"=>$email))[0]["id"];
				Database::query("INSERT INTO loginTokens VALUES (:id, :userId, :token)", array(":id"=>null, ":userId"=>$userId, ":token"=>sha1($token)));
				setcookie("MOGLE_ID", $token, time() + 60 * 60 * 24 * 7, "/", NULL, NULL, TRUE);
				setcookie("MOGLE_ID_", "1", time() + 60 * 60 * 24 * 3, "/", NULL, NULL, TRUE);
				header("Location: profile.php");
				#$success = true;
			} else {
				echo "Incorrect password";
			}
		} else {
			echo "User does not exist";
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
                <a href="signUp.php">Sign Up</a>
                <a id="login" href="login.php">Login</a>
            </div>
        </header>
    	<section class="center">
			<div class="card">
				<h1>Login</h1>
				<br/>
				<form id="loginForm" action="login.php" method="POST">
					<input type="text" name="email" placeholder="Email" required autofocus/>
					<br/>
					<br/>
					<input type="password" name="password" placeholder="Password" required/>
					<br/>
					<br/>
					<div class="submitForm">
						<input type="submit" name="login" value="Login"/>
					</div>
					<br/>
					<a href="forgotPassword.php">Forgot Password?</a>
				</form>
			</div>
		</section>
		<script>
            $(function() {
				$("#login").css({"background-color": "#800000", "color": "#fff"});
			});
		</script>
		<script src="js/mogle.js"></script>
		<!--
		<script src="js/firebase/auth.js"></script>
		<?php
#			if($success) {
#				echo "<script>
#						$('#loginForm').before('<input id=\"email\" style=\"display:none\" type=\"text\" value=\"".$email."\"/><input id=\"password\" style=\"display:none\" type=\"password\" value=\"".$password."\"/>');
#						async function func() {
#							await logIn();
#							window.location = 'profile.php';
#						};
#						func();
#					</script>";
#			}
		?>
		-->
    </body>
</html>