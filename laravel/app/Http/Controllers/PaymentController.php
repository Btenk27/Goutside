<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function pay(Reservation $reservation)
    {
        $user = Auth::user();

        if ($reservation->user_id !== $user->id) {
            abort(403);
        }

        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        if ($reservation->payment_status === 'paid') {
            return redirect()
                ->route('reservasi.index')
                ->with('success', 'Reservasi sudah dibayar.');
        }

        // ORDER ID UNIK
        $orderId = 'RES-' . $reservation->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $reservation->grand_total,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // SIMPAN ORDER ID + TOKEN
        $reservation->update([
            'payment_token'    => $snapToken,
            'payment_order_id' => $orderId,
        ]);

        return view('payment.pay', compact('snapToken'));
    }

    //  INI YANG UPDATE DB
    public function callback(Request $request)
    {
        Log::info('MIDTRANS CALLBACK MASUK', $request->all());

        $serverKey = config('services.midtrans.server_key');

        $signature = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            Log::error('Signature Midtrans tidak valid');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $reservation = Reservation::where(
            'payment_order_id',
            $request->order_id
        )->first();

        if (!$reservation) {
            Log::error('Reservasi tidak ditemukan');
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            DB::transaction(function () use ($reservation, $request) {

                foreach ($reservation->items as $item) {
                    $item->produk->decrement('stok', $item->qty);
                }

                $reservation->update([
                    'payment_status' => 'paid',
                    'payment_method' => $request->payment_type,
                    'status'         => 'approved',
                ]);
            });
        }

        return response()->json(['success' => true]);
    }

    public function finish(Request $request)
    {
        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Pembayaran selesai.');
    }
}
