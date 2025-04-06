<?php
namespace App\Base\traits;

trait HasRules
{

    public static function rules(array $appends = [])
    {
        return array_merge(self::$rules, $appends);
    }

}
