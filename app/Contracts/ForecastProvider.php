<?php

namespace App\Contracts;

interface ForecastProvider
{
    /**
     * @param array $context Baseline context and aggregates from ForecastService
     * @return array An associative array of AI-derived forecasts to overlay on baseline
     *
     * Expected shape (partial keys accepted, missing fields ignored by consumer):
     * [
     *   'overall' => [
     *      'profit_next_7d_sum' => float,
     *   ],
     *   'products' => [
     *      ['id' => int, 'days_to_deplete' => int|null, 'price_30d' => float|null],
     *      ...
     *   ],
     * ]
     */
    public function forecast(array $context): array;
}

