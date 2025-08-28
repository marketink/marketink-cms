<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\ShopService;
use Exception;
use Illuminate\Http\Request;
use \App\Services\Payment;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        try {
            return Payment::make()->setUser(auth()->user())->initiate();
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['message' => 'خطا در تأیید پرداخت: ' . $e->getMessage()]);
        }
    }
    public function verify(Request $request)
    {
        $transactionId = $request->input('trackId');
        try {
            Payment::make()->verify($transactionId, $request->toArray());
            flash(trans("message.payment_successful"));
            return redirect()->to(route("user.orders"));
        } catch (Exception $e) {
            Payment::make()->failed($transactionId);
            return redirect()->route("current.cart")->withErrors(['message' => 'خطا در تأیید پرداخت: ' . $e->getMessage()]);
        }
    }
}
