<?php
// require __DIR__ . "vendor/autoload.php";
// $stripe_secret_key = "sk_test_vvbNSLYqyz0wlCvXC6x72wS600WBeoH8l6";
// \Stripe\Stripe::setApiKey($stripe_secret_key);
// $checkout_session = \Stripe\Checkout\Session::create([
//     'payment_method_types' => ['card'],
//     'line_items' => [
//         [
//             'price_data' => [
//                 'currency' => 'eur',
//                 'product_data' => [
//                     'name' => 'T-shirt',
//                 ],
//                 'unit_amount' => 2000,
//             ],
//             'quantity' => 1,
//         ],
//     ],
//     'mode' => 'payment',
//     'success_url' => 'http://localhost:8000/success',
//     'cancel_url' => 'http://localhost:8000/cancel',
// ]);