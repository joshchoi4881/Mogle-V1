<?php
    include("../classes/Database.php");
    class Gig {
        public $name;
        public $value;
        public function __construct($name, $value) {
            $this->name = $name;
            $this->value = $value;
        }
        function getName() {
            return $this->name;
        }
        function getValue() {
            return $this->value;
        }
    }
    $location = $_POST["location"];
    $city = $_POST["city"];
    $uber = new Gig("Uber", $_POST["uber"]);
    $lyft = new Gig("Lyft", $_POST["lyft"]);
    $gigs = array($uber, $lyft);
    $timeZone = "America/New_York";
	$timeStamp = time();
	$dateTime = new DateTime("now", new DateTimeZone($timeZone));
    $dateTime->setTimestamp($timeStamp);
    $date = $dateTime->format("y-m-d");
    $timeval = $dateTime->format("H:i:s");
    $d8time = $date."T".$timeval."Z";
    $dayOfWeek = $dateTime->format("l");
    $hour = $dateTime->format("H");
    foreach($gigs as $g) {
        $id;
        if(!Database::query("SELECT id FROM liveValues2 WHERE platform=:platform AND city=:city AND dayOfWeek=:dayOfWeek AND hour=:hour", array(":platform"=>$g->getName(), ":city"
        =>$city, ":dayOfWeek"=>$dayOfWeek, ":hour"=>$hour))) {
            $id = Database::query("INSERT INTO liveValues2 VALUES (:id, :platform, :city, :dayOfWeek, :hour, :average)", array(":id"=>null, ":platform"=>$g->getName(), ":city"=>$city, ":dayOfWeek"=>$dayOfWeek, ":hour"=>$hour, ":average"=>0));
        } else {
            $id = Database::query("SELECT id FROM liveValues2 WHERE platform=:platform AND city=:city AND dayOfWeek=:dayOfWeek AND hour=:hour", array(":platform"=>$g->getName(), ":city"=>$city, ":dayOfWeek"=>$dayOfWeek, ":hour"=>$hour))[0]["id"];
        }
        Database::query("INSERT INTO valuesArray VALUES (:id, :liveValuesId, :loc, :d8time, :val)", array(":id"=>null, ":liveValuesId"=>$id, ":loc"=>$location, ":d8time"=>$d8time, ":val"=>$g->getValue()));
        $vals = Database::query("SELECT val FROM valuesArray WHERE liveValuesId=:liveValuesId", array(":liveValuesId"=>$id));
        $sum = 0;
        $count = 0;
        foreach($vals as $v) {
            $sum += $v[0];
            $count += 1;
        }
        $average = $sum / $count;
        Database::query("UPDATE liveValues2 SET average=:average WHERE id=:id", array(":average"=>$average, ":id"=>$id));
    }
    echo "Success";
?>