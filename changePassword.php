<?php
    include("classes/Login.php");
    include("classes/Database.php");
    $passwordTokenIsValid = False;
    if(Login::isLoggedIn()) {
        if(isset($_POST["changePassword"])) {
            $oldPassword = $_POST["oldPassword"];
            $newPassword = $_POST["newPassword"];
            $newPasswordRepeat = $_POST["newPasswordRepeat"];
            $userId = Login::isLoggedIn();
            if(password_verify($oldPassword, Database::query("SELECT password FROM users WHERE id=:userId", array(":userId"=>$userId))[0]["password"])) {
                if($newPassword == $newPasswordRepeat) {
                    if(strlen($newPassword) >= 5 && strlen($newPassword) <= 32) {
                        Database::query("UPDATE users SET password=:newPassword WHERE id=:userId", array(":newPassword"=>password_hash($newPassword, PASSWORD_BCRYPT), ":userId"=>$userId));
                        echo "Password change successful";
                    } else {
                        echo "Password must be between 5 and 32 characters long";
                    }
                } else {
                    echo "The passwords don't match";
                }
            } else {
                echo "Incorrect password";
            }
        } 
    } else {
        if(isset($_GET["token"])) {
            $passwordToken = $_GET["token"];
            if(Database::query("SELECT userId FROM passwordTokens WHERE token=:token", array(":token"=>sha1($passwordToken)))) {
                $userId = Database::query("SELECT userId FROM passwordTokens WHERE token=:token", array(":token"=>sha1($passwordToken)))[0]["userId"];
                $passwordTokenIsValid = True;
                if(isset($_POST["changePassword"])) {
                    $newPassword = $_POST["newPassword"];
                    $newPasswordRepeat = $_POST["newPasswordRepeat"];
                    if($newPassword == $newPasswordRepeat) {
                        if(strlen($newPassword) >= 5 && strlen($newPassword) <= 32) {
                            Database::query("UPDATE users SET password=:newPassword WHERE id=:userId", array(":newPassword"=>password_hash($newPassword, PASSWORD_BCRYPT), ":userId"=>$userId));
                            echo "Password change successful! <a href='/mogle/login.php'>Log in</a> to Mogle";
                            Database::query("DELETE FROM passwordTokens WHERE userId=:userId", array(":userId"=>$userId));
                        } else {
                            echo "Password must be between 5 and 32 characters long";
                        }
                    } else {
                        echo "The passwords don't match";
                    }
                }
            } else {
                die("Token invalid");
            }
        } else {
            die("Not logged in");
        }
    }
?>
<h1>Change your password</h1>
<form action="<?php if(!$passwordTokenIsValid) { echo "changePassword.php"; } else { echo 'changePassword.php?token='.$passwordToken.''; } ?>" method="POST">
	<?php
        if(!$passwordTokenIsValid) {
            echo '<input type="password" name="oldPassword" value="" placeholder="Current password"><p />';
        }
	?>
	<input type="password" name="newPassword" value="" placeholder="New password"/>
	<input type="password" name="newPasswordRepeat" value="" placeholder="Re-enter new password"/>
	<input type="submit" name="changePassword" value="Change Password"/>
</form>