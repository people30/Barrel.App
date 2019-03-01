<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ITasteRepository
    {
        public function get(string $key, string $value) : Models\Taste;
        public function getRange(string $key, array $values) : Collection;
        public function getAll() : Collection;
    }
}