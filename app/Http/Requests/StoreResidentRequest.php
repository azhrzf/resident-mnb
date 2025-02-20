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
        $rules = [
            'full_name' => 'required|max:255',
            'resident_status' => 'required|in:permanent,temporary',
            'phone_number' => 'required|max:20',
            'marital_status' => 'required|in:single,married',
            'house_id' => 'nullable|exists:houses,id',
            'date_of_entry' => 'nullable|date',
            'date_of_exit' => 'nullable|date|after_or_equal:date_of_entry',
        ];

        if ($this->isMethod('post')) {
            $rules['id_card_photo'] = 'required|file|mimes:jpeg,png,jpg,webp|max:2048';
        } else {
            $rules['id_card_photo'] = 'file|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
    }
}
