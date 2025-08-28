<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\CompleteProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Services\User;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class HomeController extends Controller
{
    protected User $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!auth()->user()->username_verified_at) {
            flash(trans("message.please_verify_your_account_to_order"));
        }
        return view('profile.index',[
            "user" => auth()->user(),
            "SEOData" => new SEOData(
                title: trans("message.profile"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.profile")
            )
        ]);
    }

    public function update(CompleteProfileRequest $request)
    {
        $user = auth()->user();
        $this->user->update($user,$request->validated());
        return redirect()->back();
    }
    
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $user = auth()->user();
            $this->user->updatePassword($user->id,$request->validated());
            flash(trans("message.password_changed"));
            return redirect()->back();
        }catch (\Exception $exception){
            flash($exception->getMessage());
            return redirect()->back();
        }
    }
}
