<?php

namespace App\Http\ApiRequests\Profile;

use App\RestfulApi\ApiFormRequest;

class UpdateProfileRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'website' => 'nullable|url|max:255',
            'social_links' => 'nullable|array',
            'social_links.*' => 'url',
        ];
    }

    public function messages(): array
    {
        return [
            'bio.max' => 'The bio cannot be longer than 500 characters.',
            'phone.max' => 'The phone number cannot be longer than 20 characters.',
            'gender.in' => 'The gender must be either male, female, or other.',
            'website.url' => 'The website must be a valid URL.',
            'social_links.*.url' => 'All social links must be valid URLs.',
        ];
    }
}
