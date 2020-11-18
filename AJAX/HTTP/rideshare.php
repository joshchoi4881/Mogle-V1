<?php
    require "../../vendor/autoload.php";
    require "../../config.php";
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, "../../.env");
    $dotenv->load();
    $address = $_POST["address"];
    $url = "http://".$_ENV["SERVER_IP"].":".$ridesharePort."/rideshare_bots";
    $data = array("address" => $address);
    $CURL = curl_init();
    curl_setopt($CURL, CURLOPT_URL, $url);
    curl_setopt($CURL, CURLOPT_POST, true);
    curl_setopt($CURL, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($CURL, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($CURL, CURLOPT_TIMEOUT, 0);
    curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($CURL, CURLOPT_USERAGENT, "Mogle");
    $result = curl_exec($CURL);
    curl_close($CURL);
    $json = json_decode($result, true);
    echo json_encode($json);
?>