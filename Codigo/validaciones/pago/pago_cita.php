<?php

require_once __DIR__ . '/../../config/stripe_config.php'; // Configuración de Stripe

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Formatear fecha en español
    $formatter = new \IntlDateFormatter(
        'es_ES',
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE,
        'Europe/Madrid',
        \IntlDateFormatter::GREGORIAN,
        "d 'de' MMMM 'de' yyyy"
    );
    $fechaDateTime = new DateTime($fecha);
    $fechaFormateada = $formatter->format($fechaDateTime);

    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 1500,
            'currency' => 'eur',
            'metadata' => [
                'fecha' => $fecha,
                'hora' => $hora,
            ],
        ]);

        $clientSecret = $paymentIntent->client_secret;
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo 'Error al crear el PaymentIntent: ' . $e->getMessage();
        exit();
    }

    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../estilos/styleColores.css"> 
        <link rel="stylesheet" href="../../estilos/style.css">
        <link rel="stylesheet" href="../../estilos/stylePago.css">
        <title>Pago de Cita</title>
    </head>
    <body>

        <div class="container">
            <h3>Pago para la cita del <?php echo htmlspecialchars($fechaFormateada); ?> a las <?php echo htmlspecialchars($hora); ?></h3>
            <form id="payment-form">
                <div id="card-element"></div>
                <button id="submit">Pagar</button>
            </form>
            <br>
            <a href="../../citas.php" class="cancel">Volver</a>
        </div>

        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('pk_test_51RHjoeCWVJE2plq76oTl3HTXrUkm6HhhrwJRucYIduzzsiCOClYD95FK8fOojibH0rvYwezsyhdSrzD62pPGtHQs00nlF1U4SB');
            const elements = stripe.elements();
            const card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#32325d',
                        '::placeholder': { color: '#aab7c4' }
                    },
                    invalid: { color: '#fa755a', iconColor: '#fa755a' }
                }
            });
            card.mount('#card-element');

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const { paymentIntent, error } = await stripe.confirmCardPayment('<?php echo $clientSecret; ?>', {
                    payment_method: { card: card },
                });

                if (error) {
                    alert('Error en el pago: ' + error.message);
                } else {
                    window.location.href = '../../citas/reservar_tramo.php?payment_intent=' + paymentIntent.id + '&fecha=<?php echo urlencode($fecha); ?>&hora=<?php echo urlencode($hora); ?>';
                }
            });
        </script>
    </body>
    </html>

    <?php
}
?>
