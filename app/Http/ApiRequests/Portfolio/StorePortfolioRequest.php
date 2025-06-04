<?php

namespace App\Http\ApiRequests\Portfolio;

use Illuminate\Support\Facades\Gate;
use App\RestfulApi\ApiFormRequest;

class StorePortfolioRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('portfolio_create');
    }

    public function rules(): array
    {
        return [
            'cover_image' => 'required|file|image|max:3000',
            'images' => 'required|array',
            'images.*' => 'file|image|max:3000',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'site_address' => 'nullable|string|url',
            'our_job' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'cover_image.required' => 'A cover image is required.',
            'cover_image.file' => 'The cover image must be a file.',
            'cover_image.image' => 'The cover image must be an image file.',
            'cover_image.max' => 'The cover image cannot be larger than 3MB.',
            'images.required' => 'At least one portfolio image is required.',
            'images.array' => 'Portfolio images must be provided as an array.',
            'images.*.file' => 'Each portfolio image must be a file.',
            'images.*.image' => 'Each portfolio image must be an image file.',
            'images.*.max' => 'Each portfolio image cannot be larger than 3MB.',
            'title.required' => 'A title is required.',
            'title.max' => 'The title cannot be longer than 255 characters.',
            'site_address.url' => 'The site address must be a valid URL.'
        ];
    }
}
