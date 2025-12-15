<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | Stripe uses API keys to authenticate requests. You can view and manage
    | your API keys in the Stripe Dashboard.
    |
    | Test mode secret keys have the prefix sk_test_ and live mode secret
    | keys have the prefix sk_live_.
    |
    */

    'secret_key' => env('STRIPE_SECRET_KEY', ''),

    'public_key' => env('STRIPE_PUBLIC_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhook Secret
    |--------------------------------------------------------------------------
    |
    | Stripe can send webhook events to notify your application about events
    | that happen in your Stripe account. Use this secret to verify that
    | webhook requests are sent by Stripe, not by a third party.
    |
    */

    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for Stripe transactions. For Vietnam, use 'vnd'.
    | Note: Stripe amounts are in the smallest currency unit (e.g., cents).
    |
    */

    'currency' => env('STRIPE_CURRENCY', 'vnd'),

    /*
    |--------------------------------------------------------------------------
    | Success & Cancel URLs
    |--------------------------------------------------------------------------
    |
    | URLs where customers will be redirected after completing or canceling
    | their Stripe Checkout session.
    |
    */

    'success_url' => env('STRIPE_SUCCESS_URL', env('FRONTEND_URL', 'http://localhost:3000') . '/checkout/success'),

    'cancel_url' => env('STRIPE_CANCEL_URL', env('FRONTEND_URL', 'http://localhost:3000') . '/checkout/cancel'),
];
