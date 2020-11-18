<?php
	include("../classes/Database.php");
	$email = $_POST["email"];
	if(!Database::query("SELECT email FROM users WHERE email=:email", array(":email"=>$email))) {
		if(!Database::query("SELECT email FROM newsletter WHERE email=:email", array(":email"=>$email))) {
            Database::query("INSERT INTO newsletter VALUES (:id, :email)", array(":id"=>null, ":email"=>$email));
            echo "Successfully added to the newsletter!";
        } else {
            echo "You are already signed up for the newsletter! <a href='signUp.php'>Sign up</a> to join the Mogle platform!";
        }
	} else {
		echo "You are already signed up with Mogle!";
	}
?>