<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['required','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'payment_method' => ['nullable','string','max:50'],
        ];
    }
}
