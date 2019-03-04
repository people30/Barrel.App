<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IDesignationRepository
    {
        public function find(array $params = []) : ?Models\Designation;
        public function findAll(array $params = []) : Collection;
        public function getRange(array $ids) : Collection;
    }
}