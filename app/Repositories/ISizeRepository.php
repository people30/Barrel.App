<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ISizeRepository
    {
        public function find(array $where) : Models\Size;
        public function findAll(array $where) : Collection;
        public function getRange(string $key, array $values) : Collection;
        public function getVariation(Models\Sake $sake) : Collection;
        public function getAll() : Collection;
    }
}