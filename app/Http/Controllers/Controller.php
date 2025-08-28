<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected bool $hasMessage = true;
    public function res($data = null, ?string $message = null, ?int $code = 200){
        if(!$message)
            $message = trans("message.done_successfully");
        $data = [
            'data' => $data,
            'message' => $message
        ];
        if(!$this->hasMessage)
            $data = $data['data'];
        return response()->json($data);
    }

    public function withoutMessage(){
        $this->hasMessage = false;
        return $this;
    }
}
