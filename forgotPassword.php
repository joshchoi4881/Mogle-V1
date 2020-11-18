<?php
    require "config.php";
    include("classes/Mail.php");
    include("classes/Database.php");
    if(isset($_POST["resetPassword"])) {
        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $email = $_POST["email"];
        $userId = Database::query("SELECT id FROM users WHERE email=:email", array(":email"=>$email))[0]["id"];
        Database::query("INSERT INTO passwordTokens VALUES (:id, :userId, :token)", array(":id"=>null, ":userId"=>$userId, ":token"=>sha1($token)));
        Mail::sendMail("Forgot Password", "<a href='".$forgotPasswordURL."$token'>Change Password</a>", $email);
        echo "Email sent!";
    }
?>
<h1>Forgot Password?</h1>
<form action="forgotPassword.php" method="POST">
	<input type="text" name="email" value="" placeholder="Email"?/>
	<input type="submit" name="resetPassword" value="Reset Password"/>
</form>