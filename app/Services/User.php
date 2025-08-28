<?php

namespace App\Services;

use App\Jobs\SendSMS;
use App\Models\User as Model;
use App\Traits\Report;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use Mockery\Exception;
use Illuminate\Support\Facades\Hash;


class User
{
    use Report;
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index($request)
    {
        return $this->model->query();
    }

    public function parseDataForm(array $data)
    {
        if (isset($data['password']) && $data['password'])
            $data['password'] = Hash::make($data['password']);
        else
            unset($data['password']);
        return $data;
    }
    public function sendVerificationCode($user)
    {
        $expireTime = 60;
        $otpCode = (new Otp)
            ->generate((string) $user->username, 'numeric', 5, $expireTime);
        $message = [
            'pattern' => config("sms.verify_activation_pattern"),
            'returnMessage' => " ارسال شد",
            'message' => [
                "otp" =>  $otpCode->token . "",
            ]
        ];
        SendSMS::dispatch($user->username,$message);
        return $this;
    }
    public function verifyAccount($user, $code)
    {
        $otpCheck = (new Otp())->validate($user->username, $code);

        if ($otpCheck->status == 'true') {

            $user->username_verified_at = now();
            $user->save();
            $name = $user->first_name . " " . $user->last_name;
            if (!$name)
            {
                $name = trans("message.user");
            }
            $message = [
                'pattern' => config("sms.welcome_pattern"),
                'returnMessage' => " ارسال شد",
                'message' => [
                    "token1" =>  $name,
                ]
            ];
            SendSMS::dispatch($user->username,$message);
            return trans("message.verified_successfully");
        }else
        {
            throw new \Exception(trans("message.wrong_code"),403);
        }
    }

    public function store(array $data)
    {
        return $this->model->create($this->parseDataForm($data));
    }


    public function update($user, array $data)
    {
        return $user->update($this->parseDataForm($data));
    }

    public function destroy($user)
    {
        return $user->delete();
    }
    public function updatePassword($id, $data)
    {
        $user = \App\Models\User::query()
            ->findOrFail($id);
        if (Hash::check($data->current_password,$user->password))
        {
            $user->update([
                "password" => Hash::make($data->new_password)
            ]);
            return $user->refresh();
        }
        throw new Exception(trans("messages.password_not_match"));
    }

}
