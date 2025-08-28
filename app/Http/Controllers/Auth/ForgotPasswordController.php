<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendSMS;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ForgotPasswordController extends Controller
{

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email', [
            "SEOData" => new SEOData(
                title: trans("message.forget_password"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.forget_password")
            )
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);
        $user = User::query()
            ->where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'کاربری با این نام کاربری پیدا نشد']);
        }
        $expireTime = 60;
        $otpCode = (new Otp)
            ->generate((string) $user->username, 'numeric', 5, $expireTime);
        $message = [
            'pattern' => config("smsm.forget_password_pattern"),
            'returnMessage' => " ارسال شد",
            'message' => [
                "otp" =>  $otpCode->token . "",
            ]
        ];
        SendSMS::dispatch($user->username,$message);
        return view('auth.passwords.reset', [
            'username' => $request->username,
            "SEOData" => new SEOData(
                title: trans("message.password_recovery"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.password_recovery")
            )
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
}
