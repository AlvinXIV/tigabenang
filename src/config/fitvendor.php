<?php

return [

    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER', '6281234567890'),
        'message' => env('WHATSAPP_MESSAGE', 'Halo FitVendor, saya ingin memesan pakaian custom.'),
    ],

    'contact' => [
        'email' => env('FITVENDOR_EMAIL', 'hello@fitvendor.id'),
        'location' => env('FITVENDOR_LOCATION', 'Bandung, Indonesia'),
    ],

];
