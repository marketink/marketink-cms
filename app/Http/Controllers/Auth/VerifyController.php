<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use RalphJSmit\Laravel\SEO\Support\SEOData;


class VerifyController extends Controller
{
    protected User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function verifyAndReset(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'code' => 'required',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('username', $request->username)->first();
        if (!$user) {
            return back()->withErrors(['phone' => 'کاربری با این شماره وجود ندارد']);
        }
        $otpCheck = (new Otp())->validate($request->username, $request->code);
        if ($otpCheck->status == 'true') {
            $user = \App\Models\User::query()
                ->where("username", $request->username)
                ->firstOrFail();
            $user->update([
                "password" => Hash::make($request->password)
            ]);
            flash(trans("message.password_changed_successfully"));
            return redirect()->to(route("login"));
        }else
        {
            return redirect('/login')->with('status', 'رمز عبور با موفقیت تغییر یافت');
        }
    }

    public function sendCode()
    {
        $user = $this->user
            ->sendVerificationCode(auth()->user());
        return view("profile.index",[
            "user" => auth()->user(),
            "send_code" => true,
            "SEOData" => new SEOData(
                title: trans("message.profile"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.profile")
            )
        ]);
    }

    public function verifyAccount(Request $request)
    {
        try {
            $user = $this->user;
            $verification = $user->verifyAccount(auth()->user(),$request->code);
            flash($verification);
            return redirect(route("profile"));
        }catch (\Exception $e)
        {
            flash($e->getMessage());
            return redirect(route("profile"));
        }

    }
}
