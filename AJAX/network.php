<?php
	include("../classes/Notify.php");
	include("../classes/Database.php");
	$status = $_GET["status"];
	$userId = $_GET["userId"];
	$followingId = $_GET["followingId"];
	$followerCount = $_GET["followerCount"];
	if($status == "follow") {
		if(!Database::query("SELECT id FROM followers WHERE userId=:userId AND followingId=:followingId", array(":userId"=>$userId, ":followingId"=>$followingId))) {
			Database::query("INSERT INTO followers VALUES (:id, :userId, :followingId)", array(":id"=>null, ":userId"=>$userId, ":followingId"=>$followingId));
	    	Notify::createNotify("follow", $userId, $followingId);
	    	echo ++$followerCount;
		}
	}
	else if($status == "unfollow") {
		if(Database::query("SELECT id FROM followers WHERE userId=:userId AND followingId=:followingId", array(":userId"=>$userId, ":followingId"=>$followingId))) {
	        Database::query("DELETE FROM followers WHERE userId=:userId AND followingId=:followingId", array(":userId"=>$userId, ":followingId"=>$followingId));
	        Notify::deleteNotify("follow", $userId, $followingId);
	        echo --$followerCount;
	    }
	}
?>