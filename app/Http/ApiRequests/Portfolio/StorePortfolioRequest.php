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
            'cover_image' => 'required|image|max:3000|mimes:jpeg,png,jpg,gif,svg',
            'images' => 'required|image|max:3000|mimes:jpeg,png,jpg,gif,svg',
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
            'cover_image.image' => 'The cover image must be an image file.',
            'cover_image.max' => 'The cover image cannot be larger than 3MB.',
            'cover_image.mimes' => 'The cover image must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.required' => 'Portfolio image is required.',
            'images.image' => 'The portfolio image must be an image file.',
            'images.max' => 'The portfolio image cannot be larger than 3MB.',
            'images.mimes' => 'The portfolio image must be a file of type: jpeg, png, jpg, gif, svg.',
            'title.required' => 'A title is required.',
            'title.max' => 'The title cannot be longer than 255 characters.',
            'site_address.url' => 'The site address must be a valid URL.'
        ];
    }
}
