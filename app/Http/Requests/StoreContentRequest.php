<?php

namespace App\Http\Requests;

use App\Models\Content;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\HasRequiredTextKeys;

class StoreContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => ['nullable', 'array'],
            'files.*' => ['required', 'exists:files,id'],
            'lang' => ['required', 'in:' . collect(langs())->pluck('lang')->values()->join(',')],
            'type' => ['required', 'in:' . collect(types())->pluck('type')->values()->join(',')],
            'status' => ['required', 'in:' . join(',', collect(statuses())->where('type', request('type'))->first()['status'])],
            'stock' => [collect(types())->where('type', request('type'))->first()['stock'] ? 'required' : 'nullable'],
            'price' => collect(types())->where('type', request('type'))->first()['price'] ? ['required'] : ['nullable'],
            'discount' => collect(types())->where('type', request('type'))->first()['discount'] ? ['required', 'integer', 'between:0,100'] : ['nullable'],
            'currency' => collect(types())->where('type', request('type'))->first()['price'] ? ['required', 'in:' . collect(currencies())->pluck('currency')->values()->join(',')] : ['nullable'],
            'texts' => count(collect(types())->where('type', request('type'))->first()['label']) > 0 ? ['required', 'array', new HasRequiredTextKeys] : ['nullable'],
            'texts.*.label' => count(collect(types())->where('type', request('type'))->first()['label']) > 0 ? ['required', 'string', Rule::in(array_keys(collect(types())->where('type', request('type'))->first()['label']))] : ['nullable'],
            'texts.*.text' => count(collect(types())->where('type', request('type'))->first()['label']) > 0 ? ['required', 'string'] : ['nullable'],
            'relations' => ['nullable', 'array'],
            'relations.*' => count(collect(types())->where('type', request('type'))->first()['relations']) > 0 ? ['required', function($key, $value, $fail){
                $relations = collect(types())->where('type', request('type'))->first()['relations'];
                $relationTypes = collect($relations)->pluck('to')->values()->toArray();
                if(!Content::where('id', $value)->whereIn('type', $relationTypes)->exists()){
                    $fail(trans('message.errorType'));
                }
            }] : ['nullable'],
        ];
    }
}
