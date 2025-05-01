<?php


require_once __DIR__ . '/../../config/stripe_config.php';

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1500, // Monto en centavos (5000 = 50.00 EUR)
        'currency' => 'eur',
        'payment_method' => $_POST['payment_method_id'],
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    echo json_encode(['success' => true, 'paymentIntent' => $paymentIntent]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>