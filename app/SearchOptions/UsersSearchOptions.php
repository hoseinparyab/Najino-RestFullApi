<?php
namespace App\SearchOptions;

use Amirhosseinabd\LaravelEasySearch\Concerns\MultipleSearchOptions;

class UsersSearchOptions implements MultipleSearchOptions
{
    /**
     * @return string[]
     */
    public function columns(): array
    {
        return ['first_name', 'email'];
    }

    /**
     * @return string[]
     */
    public function inputNames(): array
    {
        return [
            'first_name' => 'name',
            'email'      => 'email',
        ];
    }
}
