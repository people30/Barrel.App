<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IAreaRepository
    {
        public function get(string $key, string $value) : Models\Area;
        public function getRange(string $key, array $values) : Collection;
        public function getAll() : Collection;
    }
}