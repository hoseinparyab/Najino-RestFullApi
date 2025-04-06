<?php
namespace App\SearchOptions;

use App\Base\SearchOptions;

class CategoriesSearchOptions extends SearchOptions
{
    public function __construct()
    {
        $this->searchableFields = [
            'name',
            'slug'
        ];

        $this->sortableFields = [
            'id',
            'name',
            'created_at',
            'updated_at'
        ];

        $this->filterableFields = [
            'parent_id'
        ];
    }
}
