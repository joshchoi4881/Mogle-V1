<?php
    header('Content-Type: application/json');
    include("../classes/Database.php");
    // Batch 1
    $uberManhattanNewYork = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Uber",
    ":loc"=>"Columbia University"));
    $lyftManhattanNewYork = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Lyft",
    ":loc"=>"Columbia University"));
    $uberPrincetonNewJersey = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Uber",
    ":loc"=>"Princeton University"));
    $lyftPrincetonNewJersey = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Lyft",
    ":loc"=>"Princeton University"));
    $uberPhiladelphiaPennsylvania = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Uber",
    ":loc"=>"Thomas Jefferson University"));
    $lyftPhiladelphiaPennsylvania = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Lyft",
    ":loc"=>"Thomas Jefferson University"));
    $uberManhattanNewYorkArray = array();
    $lyftManhattanNewYorkArray = array();
    $uberPrincetonNewJerseyArray = array();
    $lyftPrincetonNewJerseyArray = array();
    $uberPhiladelphiaPennsylvaniaArray = array();
    $lyftPhiladelphiaPennsylvaniaArray = array();
    foreach($uberManhattanNewYork as $uberManhattanNewYorkVariable) {
        $uberManhattanNewYorkArray[] = $uberManhattanNewYorkVariable;
    }
    foreach($lyftManhattanNewYork as $lyftManhattanNewYorkVariable) {
        $lyftManhattanNewYorkArray[] = $lyftManhattanNewYorkVariable;
    }
    foreach($uberPrincetonNewJersey as $uberPrincetonNewJerseyVariable) {
        $uberPrincetonNewJerseyArray[] = $uberPrincetonNewJerseyVariable;
    }
    foreach($lyftPrincetonNewJersey as $lyftPrincetonNewJerseyVariable) {
        $lyftPrincetonNewJerseyArray[] = $lyftPrincetonNewJerseyVariable;
    }
    foreach($uberPhiladelphiaPennsylvania as $uberPhiladelphiaPennsylvaniaVariable) {
        $uberPhiladelphiaPennsylvaniaArray[] = $uberPhiladelphiaPennsylvaniaVariable;
    }
    foreach($lyftPhiladelphiaPennsylvania as $lyftPhiladelphiaPennsylvaniaVariable) {
        $lyftPhiladelphiaPennsylvaniaArray[] = $lyftPhiladelphiaPennsylvaniaVariable;
    }
    /*
    // Batch 2
    $uberMinneapolisMinnesota = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Uber",
    ":loc"=>"Minneapolis Convention Center"));
    $lyftMinneapolisMinnesota = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Lyft",
    ":loc"=>"Minneapolis Convention Center"));
    $uberDelrayBeachFlorida = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Uber",
    ":loc"=>"SaltWater Brewery, Delray Beach, Florida"));
    $lyftDelrayBeachFlorida = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Lyft",
    ":loc"=>"SaltWater Brewery, Delray Beach, Florida"));
    $uberDallasTexas = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Uber",
    ":loc"=>"Dallas Museum of Art"));
    $lyftDallasTexas = Database::query("SELECT dayOfWeek, hour, average FROM liveValues1 WHERE dayOfWeek IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') AND platform=:platform AND loc=:loc ORDER BY CASE dayOfWeek WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END, hour", array(":platform"=>"Lyft",
    ":loc"=>"Dallas Museum of Art"));
    $uberMinneapolisMinnesotaArray = array();
    $lyftMinneapolisMinnesotaArray = array();
    $uberDelrayBeachFloridaArray = array();
    $lyftDelrayBeachFloridaArray = array();
    $uberDallasTexasArray = array();
    $lyftDallasTexasArray = array();
    foreach($uberMinneapolisMinnesota as $uberMinneapolisMinnesotaVariable) {
        $uberMinneapolisMinnesotaArray[] = $uberMinneapolisMinnesotaVariable;
    }
    foreach($lyftMinneapolisMinnesota as $lyftMinneapolisMinnesotaVariable) {
        $lyftMinneapolisMinnesotaArray[] = $lyftMinneapolisMinnesotaVariable;
    }
    foreach($uberDelrayBeachFlorida as $uberDelrayBeachFloridaVariable) {
        $uberDelrayBeachFloridaArray[] = $uberDelrayBeachFloridaVariable;
    }
    foreach($lyftDelrayBeachFlorida as $lyftDelrayBeachFloridaArrayVariable) {
        $lyftDelrayBeachFloridaArray[] = $lyftDelrayBeachFloridaArrayVariable;
    }
    foreach($uberDallasTexas as $uberDallasTexasVariable) {
        $uberDallasTexasArray[] = $uberDallasTexasVariable;
    }
    foreach($lyftDallasTexas as $lyftDallasTexasVariable) {
        $lyftDallasTexasArray[] = $lyftDallasTexasVariable;
    }
    */
    // Send information
    $arr = [
        $uberManhattanNewYorkArray,
        $lyftManhattanNewYorkArray,
        $uberPrincetonNewJerseyArray,
        $lyftPrincetonNewJerseyArray,
        $uberPhiladelphiaPennsylvaniaArray,
        $lyftPhiladelphiaPennsylvaniaArray,
        /*
        $uberMinneapolisMinnesotaArray,
        $lyftMinneapolisMinnesotaArray,
        $uberDelrayBeachFloridaArray,
        $lyftDelrayBeachFloridaArray,
        $uberDallasTexasArray,
        $lyftDallasTexasArray
        */
    ];
    print json_encode($arr);
?>