<?php

namespace App\Http\ApiRequests\Portfolio;

use Illuminate\Support\Facades\Gate;
use App\RestfulApi\ApiFormRequest;

class UpdatePortfolioRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('portfolio_update');
    }

    public function rules(): array
    {
        return [
            'cover_image' => 'sometimes|image|max:3000|mimes:jpeg,png,jpg,gif,svg',
            'images' => 'sometimes|string',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'site_address' => 'nullable|string|url',
            'our_job' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'cover_image.image' => 'The cover image must be an image file.',
            'cover_image.max' => 'The cover image cannot be larger than 3MB.',
            'cover_image.mimes' => 'The cover image must be a file of type: jpeg, png, jpg, gif, svg.',
            'title.max' => 'The title cannot be longer than 255 characters.',
            'site_address.url' => 'The site address must be a valid URL.'
        ];
    }
}
