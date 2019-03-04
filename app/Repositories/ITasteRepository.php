<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ITasteRepository
    {
        public function find(array $params = []) : ?Models\Taste;
        public function findAll(array $params = []) : Collection;
        public function getRange(array $ids) : Collection;
    }
}