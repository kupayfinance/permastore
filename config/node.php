<?php

return [
    'url' => env('NODE_URL', 'http://localhost:8545'), // (!) SET TO FALSE ON .env FILE TO TEST LOCALLY
    'data' => [
        'jsonrpc' => '2.0',
        'method'  =>  'eth_sendTransaction',
        'params' => [
             [
                'from' => env('NODE_FROM', '0x36Cb1e33cF9d526f36e1fAF533ec310ee4059b3D'),
                'to' => env('NODE_TO', '0x36Cb1e33cF9d526f36e1fAF533ec310ee4059b3D'), // send to ourselves
                /*
                    this is 0.00001 kcs in hex. Amounts have 18 decimals, therefor 1^13 = 0.00001
                */
                'value' => env('NODE_VALUE', '0x9184E72A000'),
                'data' => null, // this is where we will store our data string
            ]
        ],
        'id' => env('NODE_id', 1),
    ],
    'headers' => [
        'Content-Type' => 'application/json'
    ],
];
