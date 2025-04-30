<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Cargar las dependencias de Composer

// Cargar configuración desde config.env
$config = parse_ini_file(__DIR__ . '/../../config.env');

// Obtener la clave de Stripe
$stripeSecretKey = $config['STRIPE_SECRET_KEY'] ?? null;

if (!$stripeSecretKey) {
    die("Error: Clave secreta de Stripe no encontrada.");
}

\Stripe\Stripe::setApiKey($stripeSecretKey);