<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Services\Payments\PaymentService;
use App\Services\Subscriptions\SubscriptionActivator;

class PaymentWebhookController extends Controller
{
    public function paystack(Request $request)
    {
        $secret = config('payments.paystack.secret');
        $sig    = $request->header('x-paystack-signature');
        $body   = $request->getContent();

        if (!$sig || hash_hmac('sha512', $body, (string) $secret) !== $sig) {
            Log::warning('Paystack webhook signature mismatch');
            return response()->json(['ok' => false], 400);
        }

        $payload = $request->json()->all();
        $ref = data_get($payload, 'data.reference');
        if (!$ref) {
            return response()->json(['ok' => false], 200);
        }

        $payment = Payment::where('reference', $ref)->where('provider', 'paystack')->first();
        if (!$payment) {
            return response()->json(['ok' => true], 200);
        }

        // Verify via API and finalize
        $result = PaymentService::verifyAndFinalize('paystack', $payment, []);
        if (($result['success'] ?? false) && $payment->status === 'success') {
            SubscriptionActivator::activate($payment->tenant_id, $payment->plan_code);
        }

        return response()->json(['ok' => true], 200);
    }

    public function flutterwave(Request $request)
    {
        $hash = config('payments.flutterwave.hash');
        $header = $request->header('verif-hash');

        if (!$hash || !$header || $header !== $hash) {
            Log::warning('Flutterwave webhook hash mismatch');
            return response()->json(['ok' => false], 400);
        }

        $payload = $request->json()->all();
        $txRef   = data_get($payload, 'data.tx_ref');
        $status  = data_get($payload, 'data.status');

        if (!$txRef) {
            return response()->json(['ok' => false], 200);
        }

        $payment = Payment::where('reference', $txRef)->where('provider','flutterwave')->first();
        if (!$payment) {
            return response()->json(['ok' => true], 200);
        }

        // Verify via API using transaction_id if present
        $result = PaymentService::verifyAndFinalize('flutterwave', $payment, [
            'tx_ref' => $txRef,
            'transaction_id' => data_get($payload, 'data.id'),
        ]);

        if (($result['success'] ?? false) && $payment->status === 'success') {
            SubscriptionActivator::activate($payment->tenant_id, $payment->plan_code);
        }

        return response()->json(['ok' => true], 200);
    }
}
