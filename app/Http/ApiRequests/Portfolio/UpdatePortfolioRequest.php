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
            'cover_image' => 'sometimes|file|image|max:2048',
            'images' => 'sometimes|array',
            'images.*' => 'file|image|max:2048',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'site_address' => 'nullable|string|url',
            'our_job' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'cover_image.file' => 'The cover image must be a file.',
            'cover_image.image' => 'The cover image must be an image file.',
            'cover_image.max' => 'The cover image cannot be larger than 2MB.',
            'images.array' => 'Portfolio images must be provided as an array.',
            'images.*.file' => 'Each portfolio image must be a file.',
            'images.*.image' => 'Each portfolio image must be an image file.',
            'images.*.max' => 'Each portfolio image cannot be larger than 2MB.',
            'title.max' => 'The title cannot be longer than 255 characters.',
            'site_address.url' => 'The site address must be a valid URL.'
        ];
    }
}
