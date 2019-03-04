<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IBrewerRepository
    {
        public function find(array $where = []) : ?Models\Brewer;
        public function findAll(array $where = []) : Collection;
        public function getAreal(Models\Area $area) : Collection;
        public function getRange(array $ids) : Collection;
        public function getRandom() : Models\Brewer;
    }
}