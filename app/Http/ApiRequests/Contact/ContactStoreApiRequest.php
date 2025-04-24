<?php

namespace App\Http\ApiRequests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ];
    }
}
