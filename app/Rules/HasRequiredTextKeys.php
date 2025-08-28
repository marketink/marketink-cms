<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HasRequiredTextKeys implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (!is_array($value)) return false;

        $keys = collect($value)->pluck('label')->unique()->toArray();

        $pass = true;
        $labels = array_keys(collect(types())->where('type', request('type'))->first()['label']);

        foreach($labels as $label){
            if(!in_array($label, $keys)){
                $pass = false;
            }
        }
        return $pass;
    }

    public function message(): string
    {
        return trans("message.texts_should_have_text_and_body");
    }
}
