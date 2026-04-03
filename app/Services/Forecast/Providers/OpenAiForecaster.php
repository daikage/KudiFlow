<?php

namespace App\Services\Forecast\Providers;

use App\Contracts\ForecastProvider;
use Illuminate\Support\Facades\Http;

class OpenAiForecaster implements ForecastProvider
{
    public function forecast(array $context): array
    {
        $cfg = config('ai.forecast.openai');

        $apiKey  = $cfg['api_key'] ?? null;
        $model   = $cfg['model'] ?? 'gpt-4o-mini';
        $baseUrl = rtrim((string) ($cfg['base_url'] ?? 'https://api.openai.com/v1'), '/');
        $timeout = (int) ($cfg['timeout'] ?? 15);

        if (!$apiKey) {
            return [];
        }

        // Keep payload small: send only aggregates needed for forecasts
        $payload = [
            'overall' => [
                'profit_series' => $context['overall']['profit_series'] ?? [],
            ],
            'products' => collect($context['products'] ?? [])->map(fn ($p) => [
                'id'              => $p['id'],
                'name'            => $p['name'],
                'stock'           => $p['stock'],
                'avg_daily_units' => $p['avg_daily_units'],
                'price_now'       => $p['price_now'],
            ])->values()->all(),
        ];

        $system = 'You are a financial forecasting assistant for small retail businesses. Always reply in strict JSON only.';
        $user   = <<<PROMPT
Given the following store summaries, produce short-horizon forecasts:

- Forecast the total profit for the next 7 days (sum). Use recent trends.
- For each product, estimate days_to_deplete (based on stock and avg_daily_units). If avg is 0, return null.
- For each product, forecast price_30d (price in 30 days). If no price_now, return null.

Return JSON with keys: overall.profit_next_7d_sum (number), products: [{id, days_to_deplete, price_30d}].

Data:
{$this->json($payload)}
PROMPT;

        try {
            $response = Http::withToken($apiKey)
                ->timeout($timeout)
                ->withHeaders(['OpenAI-Beta' => 'assistants=v2'])
                ->post($baseUrl.'/chat/completions', [
                    'model' => $model,
                    'temperature' => 0.2,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $user],
                    ],
                ]);

            if (!$response->ok()) {
                return [];
            }

            $content = data_get($response->json(), 'choices.0.message.content');
            if (!is_string($content) || $content === '') {
                return [];
            }

            $json = json_decode($content, true);
            if (!is_array($json)) {
                return [];
            }

            // Normalize shape to expected
            $overall  = (array) ($json['overall'] ?? []);
            $products = is_array($json['products'] ?? null) ? $json['products'] : [];

            return [
                'overall' => [
                    'profit_next_7d_sum' => isset($overall['profit_next_7d_sum'])
                        ? (float) $overall['profit_next_7d_sum']
                        : null,
                ],
                'products' => collect($products)->map(function ($p) {
                    return [
                        'id'              => (int) ($p['id'] ?? 0),
                        'days_to_deplete' => isset($p['days_to_deplete']) ? (is_null($p['days_to_deplete']) ? null : (int) $p['days_to_deplete']) : null,
                        'price_30d'       => isset($p['price_30d']) ? (is_null($p['price_30d']) ? null : (float) $p['price_30d']) : null,
                    ];
                })->all(),
            ];
        } catch (\Throwable $e) {
            // Fail open to baseline if API errors
            return [];
        }
    }

    protected function json($data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

