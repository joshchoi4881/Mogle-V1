<?php
	include("../classes/Database.php");
    $userId = $_POST["userId"];
    $gigs = $_POST["gigs"];
    $schedule = json_encode($gigs);
	if(!Database::query("SELECT userId FROM schedules WHERE userId=:userId", array(":userId"=>$userId))) {
        Database::query("INSERT INTO schedules VALUES (:id, :userId, :schedule)", array(":id"=>null, ":userId"=>$userId, ":schedule"=>$schedule));
        echo "Successfully submitted schedule!";
	} else {
        Database::query("UPDATE schedules SET schedule=:schedule WHERE userId=:userId", array(":schedule"=>$schedule, ":userId"=>$userId));
		echo "Your schedule has been updated!";
	}
?>