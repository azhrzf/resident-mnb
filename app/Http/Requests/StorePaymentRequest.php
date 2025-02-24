<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'house_resident_id' => 'required|exists:house_residents,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'payment_period' => 'required|in:monthly,yearly',
            'payment_status' => 'required|in:paid,unpaid',
        ];
    }
}
