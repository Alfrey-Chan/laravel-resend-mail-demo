<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderInquiryRequest extends FormRequest
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
            'email' => ['required', 'email:rfc', 'max:255'],
            'city' => ['required', 'in:vancouver,coquitlam,burnaby,port coquitlam'],
            'items' => ['nullable', 'array', 'max:10'],
            'items.*.photos' => ['nullable', 'array', 'max:3'], // max 3 photos per item
            'items.*.photos.*' => ['mimes:jpeg,jpg,png,webp', 'max:2048'], // 2MB per file
            'items.*.details' => ['required', 'string', 'max:5000'],
            'additional_details' => ['nullable', 'string', 'max:8000'],
        ];
    }
}
