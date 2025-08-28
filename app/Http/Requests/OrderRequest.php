<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:contents,id',
            'orders.*.amount' => 'required|numeric',
            'orders.*.type' => 'required|string',
            'width' => 'required|integer',
            'from' => 'required|integer',
            'dookht' => 'required|integer',
            'height' => 'required|integer',
            'tool' => 'required|integer',
            'length' => 'required|integer',
            'rod' => 'required|integer',
            'porchin_kamchin' => 'nullable|string',
            'base_type' => 'required|string',
            'description' => 'nullable|string',
        ];
    }
}
