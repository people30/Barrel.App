<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IAreaRepository
    {
        public function find(array $params = []) : ?Models\Area;
        public function findAll(array $params = []) : Collection;
        public function getIn(array $ids) : Collection;
    }
}