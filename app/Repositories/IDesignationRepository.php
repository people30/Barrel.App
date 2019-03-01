<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IDesignationRepository
    {
        public function get(string $key, string $value) : Models\Designation;
        public function getRange(string $key, array $values) : Collection;
        public function getAll() : Collection;
    }
}