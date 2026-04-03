<?php

return [
    'forecast' => [
        // baseline|openai
        'driver' => env('AI_FORECAST_DRIVER', 'baseline'),

        'openai' => [
            'api_key'  => env('OPENAI_API_KEY'),
            'model'    => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'timeout'  => env('OPENAI_TIMEOUT', 15),
        ],
    ],
];

