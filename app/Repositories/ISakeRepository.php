<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ISakeRepository
    {
        public function find(array $params = []) : Models\Sake;
        public function findAll(array $params = []) : Collection;
        public function getRange(array $ids) : Collection;
        public function getProducts(Models\Brewer $brewer) : Collection;
    }
}