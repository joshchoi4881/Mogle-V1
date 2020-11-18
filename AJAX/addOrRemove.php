<?php
	include("../classes/Database.php");
	$userId = $_GET["userId"];
	$gig = $_GET["gig"];
	if(!Database::query("SELECT userId FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>$gig))) {
		Database::query("INSERT INTO gigs VALUES (:id, :userId, :gig)", array(":id"=>null, ":userId"=>$userId, ":gig"=>$gig));
		echo "Added";
	} else {
		Database::query("DELETE FROM gigs WHERE userId=:userId AND gig=:gig", array(":userId"=>$userId, ":gig"=>$gig));
		echo "Removed";
	}
?>