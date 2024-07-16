<?php

return [
    'ttl' => env('TRANSACTION_TTL', 60),
    'queue_name' => 'transactions',
];
