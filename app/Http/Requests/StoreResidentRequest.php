<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResidentRequest extends FormRequest
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
            'full_name' => 'required|max:255',
            'resident_status' => 'required|in:permanent,temporary',
            'phone_number' => 'required|max:20',
            'marital_status' => 'required|in:single,married',
            'house_id' => 'nullable|exists:houses,id',
            'date_of_entry' => 'nullable|date',
            'date_of_exit' => 'nullable|date|after_or_equal:date_of_entry',
            'id_card_photo' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10048'
        ];
    }
}
