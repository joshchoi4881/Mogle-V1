<?php
    include("classes/Database.php");
    require_once('vendor/autoload.php');
    \Stripe\Stripe::setApiKey('sk_test_f7iIjQBT618di2ifC8Z9cfSJ00PqEikiRO');
    // Sanitize POST array
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $userId = $POST['userId'];
    $token = $POST['stripeToken'];
    echo $token;
    // Create customer in Stripe
    $email = Database::query("SELECT email FROM users WHERE id=:id", array(":id"=>$userId))[0]["email"];
    $customer = \Stripe\Customer::create(array(
        "email" => $email,
        "source" => $token
    ));
    // Charge customer
    $charge = \Stripe\Charge::create(array(
        "amount" => 200,
        "currency" => "usd",
        "description" => "Monthly Subscription Fee",
        "customer" => $customer->id
    ));
    print_r($charge);
?>