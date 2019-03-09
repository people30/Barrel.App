<?php

namespace App\Exceptions
{
    use App\Models;

    class BrewerPostCategoryUnregisteredException extends \Exception
    {
        public function __construct(Models\Brewer $brewer)
        {
            parent::__construct($brewer->name . 'の投稿カテゴリが登録されていません。');
        }
    }
}