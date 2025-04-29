<?php

namespace App\SearchOptions;

use Amirhosseinabd\LaravelEasySearch\Concerns\MultipleSearchOptions;

class ArticleSearchOptions implements MultipleSearchOptions
{
    public function columns(): array
    {
        return [
            'title',
            'body'
        ];
    }

    public function inputNames(): array
    {
        return [
            'title' => 'search',
            'body' => 'search'
        ];
    }
}
