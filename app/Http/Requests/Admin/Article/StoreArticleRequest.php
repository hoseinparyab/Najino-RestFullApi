<?php

namespace App\Http\Requests\Admin\Article;

class StoreArticleRequest extends BaseArticleRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            // Additional rules specific to storing articles can be added here
        ]);
    }
}
