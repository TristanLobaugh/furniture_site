<?php
require_once("config.php");

  $token  = $_POST['stripeToken'];
  $amount = $_POST['amount'];

  $customer = \Stripe\Customer::create(array(
      'email' => 'customer@example.com',
      'source'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $amount,
      'currency' => 'usd'
  ));

  echo '<h1>Successfully charged '.$amount.'!</h1>';
  ?>