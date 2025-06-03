<?php

namespace App\SearchOptions;

use Amirhosseinabd\LaravelEasySearch\Concerns\SingleSearchOptions;
use Amirhosseinabd\LaravelEasySearch\Eloquent\Concerns\WithRelation;

class ArticleAuthorSearchOptions implements SingleSearchOptions, WithRelation
{
    /**
     * @return string[]
     */
    public function columns(): array
    {
        return ['email'];
    }

    public function inputName(): string
    {
        return 'query';
    }

    public function relation(): string
    {
        return 'user';
    }
}
