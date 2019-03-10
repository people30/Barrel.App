<?php

namespace App\Exceptions
{
    use App\Models;

    class WpUrlUnregisterdException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('.env に WordPress の URL が設定されていません。');
        }
    }
}