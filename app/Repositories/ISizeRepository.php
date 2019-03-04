<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ISizeRepository
    {
        public function find(array $params = []) : Models\Size;
        public function findAll(array $params = []) : Collection;
        public function getRange(array $ids) : Collection;
        public function getVariation(Models\Sake $sake) : Collection;
    }
}