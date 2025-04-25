<?php

require_once __DIR__ . '/../../vendor/autoload.php'; // Cargar las dependencias de Composer

// Configurar la clave secreta de Stripe
\Stripe\Stripe::setApiKey('sk_test_51RHjoeCWVJE2plq7ICjPoLnP3wiGhmd0WA3mbTVWt7nwdbZ77Ry1Oo3iE2KVZX329hMLeaSSEjMM9DxAzkYM0VTs00ymmHoEOg'); // Reemplaza con tu clave secreta de Stripe