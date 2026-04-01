<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => ['required','string','max:255'],
            'sku' => ['required','string','max:64', Rule::unique('products','sku')->ignore($productId)],
            'category_id' => ['nullable','exists:categories,id'],
            'price' => ['required','numeric','min:0'],
            'cost' => ['nullable','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'min_stock' => ['nullable','integer','min:0'],
            'status' => ['required','in:active,inactive'],
            'image_url' => ['nullable','url'],
        ];
    }
}
