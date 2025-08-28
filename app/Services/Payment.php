<?php

namespace App\Services;

use App\Jobs\SendSMS;
use App\Models\Cart;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;
use PHPUnit\Framework\Exception;
use Shetabit\Multipay\Invoice;
use Illuminate\Support\Facades\URL;
use App\Models\Payment as PaymentModel;


class Payment
{
    protected $user;
    protected int $userId;
    public const USER_SMS_CART = "725arf0s75o0yub";
    public const ADMIN_SMS_CART = "dv24jyaiqlqxwfw";
    public static function make()
    {
        return new static();
    }

    public function initiate()
    {
        ;
        $userId = $this->user->id;
        $key = "payment-user-$userId";
        $lock = Cache::lock($key, 10);
        if ($lock->get()) {
            $cart = Cart::query()
                ->with(["orders"])
                ->where("user_id", $this->user->id)
                ->where("status", "pending")
                ->first();
            if (count($cart->orders) < 1) {
                throw new Exception(trans("messages.cart_empty"));
            }
            $amount = $cart->final_price;
            if ($amount < 1000) {
                throw new \Exception(trans("message.amount_is_too_low", 403));
            }
            try {
                $invoice = new Invoice;
                $invoice->amount($amount);
                return ShetabitPayment::callbackUrl(route("payment.verify"))->purchase(
                    $invoice,
                    function ($driver, $transactionId) use ($userId, $amount, $cart) {
                        PaymentModel::query()
                            ->create([
                                "user_id" => $userId,
                                "status" => "pending",
                                "transaction_id" => $transactionId,
                                "amount" => $amount,
                                "cart_id" => $cart->id,
                                "currency" => defaultCurrency()
                            ]);
                    }
                )->pay()->render();
            } catch (\Exception $e) {
                throw new \Exception('خطا در اتصال به درگاه پرداخت: ' . $e->getMessage());
            }
        } else {
            return redirect()->to('/profile');
        }

    }

    public function failed(int $transactionId, $info = null)
    {
        $payment = \App\Models\Payment::query()
            ->where("transaction_id", $transactionId)
            ->where('status', 'pending')
            ->first();
        if ($payment) {
            $payment->status = "failed";
            $payment->save();
        }
    }

    public function verify(int $transactionId, $info = null)
    {
        $payment = \App\Models\Payment::query()
            ->where("transaction_id", $transactionId)
            ->where('status', 'pending')
            ->first();
        if ($payment) {
            try {
                $receipt = ShetabitPayment::amount($payment->amount)->transactionId($transactionId)->verify();
                $payment->status = "success";
                $payment->reference_id = $receipt->getReferenceId();
                $payment->save();
                $cart = Cart::query()
                    ->where("status", "pending")
                    ->findOrFail($payment->cart_id);
                $cart->update([
                    "status" => "paid",
                ]);

                $status = new Status();
                $status->content_type = Cart::class;
                $status->content_id = $cart->id;
                $status->user_id = $cart->user_id;
                $status->status = "paid";
                $status->save();

                $this->sendCartPaymentSMS($cart);
                return true;
            } catch (Exception $e) {
                $payment->status = "failed";
                $payment->save();
                Log::error($e->getMessage());
            }
        }
    }

    public function sendCartPaymentSMS($cart)
    {
        $message = [
            'pattern' => config("sms.user_sms_cart_pattern"),
            'returnMessage' => " ارسال شد",
            'message' => [
                'name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                'id' => $cart->id,
                'price' => $cart->final_price,
            ]
        ];
        SendSMS::dispatch(auth()->user()->username, $message);
        $owners = \App\Models\User::query()
            ->where("role", "admin")
            ->get();
        foreach ($owners as $owner) {
            $message = [
                'pattern' => config("sms.admin_sms_cart_pattern"),
                'returnMessage' => " ارسال شد",
                'message' => [
                    'name' => $owner->first_name . ' ' . $owner->last_name,
                    'id' => $cart->id,
                    'price' => $cart->final_price,
                ]
            ];
            SendSMS::dispatch($owner->username, $message);
        }
        return $this;
    }
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    public function setCartId(int $cartId)
    {
        $this->userId = $cartId;
        return $this;
    }
}
