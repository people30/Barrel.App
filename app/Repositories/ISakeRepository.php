<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ISakeRepository
    {
        public function find(array $where) : Models\Sake;
        public function findAll(array $where) : Collection;
        public function getRange(string $key, array $values) : Collection;
        public function getProducts(Models\Brewer $brewer) : Collection;
        public function getAll() : Collection;
    }
}