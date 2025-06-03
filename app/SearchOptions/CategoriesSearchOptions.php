<?php

namespace App\SearchOptions;

use Amirhosseinabd\LaravelEasySearch\Concerns\MultipleSearchOptions;

class CategoriesSearchOptions implements MultipleSearchOptions
{
    public function columns(): array
    {
        return [
            'name',
            'slug',
        ];
    }

    public function inputNames(): array
    {
        return [
            'name' => 'name',
            'slug' => 'slug',
        ];
    }
}
