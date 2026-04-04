<?php

namespace App\Services\Payments;

use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    public static function initCheckout(int $tenantId, int $userId, string $userEmail, Plan $plan): array
    {
        $driver   = config('payments.driver', 'paystack');
        $currency = config('payments.currency', 'NGN');
        $reference = strtoupper(Str::random(12)).'-'.time();

        $payment = Payment::create([
            'tenant_id'   => $tenantId,
            'user_id'     => $userId,
            'plan_code'   => $plan->code,
            'provider'    => $driver,
            'reference'   => $reference,
            'amount'      => (float) $plan->price,
            'currency'    => $currency,
            'status'      => 'pending',
            'meta'        => ['interval' => $plan->interval, 'plan_name' => $plan->name],
        ]);

        return $driver === 'flutterwave'
            ? self::initFlutterwave($payment, $userEmail)
            : self::initPaystack($payment, $userEmail);
    }

    public static function verifyAndFinalize(string $driver, Payment $payment, array $callbackData): array
    {
        return $driver === 'flutterwave'
            ? self::verifyFlutterwave($payment, $callbackData)
            : self::verifyPaystack($payment, $callbackData);
    }

    protected static function initPaystack(Payment $payment, string $email): array
    {
        $cfg = config('payments.paystack');
        $callbackUrl = $cfg['callback'] ?: route('ui.billing.callback', [], true);

        $res = Http::withToken($cfg['secret'])
            ->post(rtrim($cfg['base_url'], '/').'/transaction/initialize', [
                'email'        => $email,
                'amount'       => (int) round($payment->amount * 100),
                'currency'     => $payment->currency,
                'reference'    => $payment->reference,
                'callback_url' => $callbackUrl,
                'metadata'     => [
                    'tenant_id' => $payment->tenant_id,
                    'plan_code' => $payment->plan_code,
                ],
            ]);

        if (!$res->ok() || !data_get($res->json(), 'status')) {
            throw new \RuntimeException('Failed to initialize Paystack payment.');
        }

        return ['redirect' => data_get($res->json(), 'data.authorization_url')];
    }

    protected static function verifyPaystack(Payment $payment, array $callbackData): array
    {
        $cfg = config('payments.paystack');
        $ref = $payment->reference;

        $res = Http::withToken($cfg['secret'])
            ->get(rtrim($cfg['base_url'], '/').'/transaction/verify/'.$ref);

        if (!$res->ok() || !data_get($res->json(), 'status')) {
            return ['success' => false, 'message' => 'Verification failed'];
        }

        $data = data_get($res->json(), 'data', []);
        $status = $data['status'] ?? 'failed';

        $payment->provider_ref = (string) ($data['id'] ?? null);
        $payment->status = $status === 'success' ? 'success' : 'failed';
        $payment->meta = array_merge($payment->meta ?? [], ['provider_payload' => $data]);
        $payment->save();

        return [
            'success'  => $payment->status === 'success',
            'amount'   => (float) ($data['amount'] ?? 0) / 100,
            'currency' => $data['currency'] ?? $payment->currency,
        ];
    }

    protected static function initFlutterwave(Payment $payment, string $email): array
    {
        $cfg = config('payments.flutterwave');
        $callbackUrl = $cfg['callback'] ?: route('ui.billing.callback', [], true);

        $res = Http::withToken($cfg['secret'])
            ->post(rtrim($cfg['base_url'], '/').'/payments', [
                'tx_ref'       => $payment->reference,
                'amount'       => $payment->amount,
                'currency'     => $payment->currency,
                'redirect_url' => $callbackUrl,
                'customer'     => ['email' => $email],
                'customizations' => [
                    'title' => config('app.name').' Subscription',
                    'description' => $payment->meta['plan_name'] ?? 'Plan',
                ],
            ]);

        if (!$res->ok() || data_get($res->json(), 'status') !== 'success') {
            throw new \RuntimeException('Failed to initialize Flutterwave payment.');
        }

        return ['redirect' => data_get($res->json(), 'data.link')];
    }

    protected static function verifyFlutterwave(Payment $payment, array $callbackData): array
    {
        $cfg = config('payments.flutterwave');

        $txRef  = $callbackData['tx_ref'] ?? null;
        $txId   = $callbackData['transaction_id'] ?? null;

        if (!$txRef || $txRef !== $payment->reference || !$txId) {
            return ['success' => false, 'message' => 'Invalid reference'];
        }

        $res = Http::withToken($cfg['secret'])
            ->get(rtrim($cfg['base_url'], '/').'/transactions/'.$txId.'/verify');

        if (!$res->ok() || data_get($res->json(), 'status') !== 'success') {
            return ['success' => false, 'message' => 'Verification failed'];
        }

        $data = data_get($res->json(), 'data', []);
        $chargeStatus = $data['status'] ?? 'failed';

        $payment->provider_ref = (string) ($data['id'] ?? null);
        $payment->status = $chargeStatus === 'successful' ? 'success' : 'failed';
        $payment->meta = array_merge($payment->meta ?? [], ['provider_payload' => $data]);
        $payment->save();

        return [
            'success'  => $payment->status === 'success',
            'amount'   => (float) ($data['amount'] ?? 0),
            'currency' => $data['currency'] ?? $payment->currency,
        ];
    }
}
