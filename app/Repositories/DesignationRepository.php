<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class DesignationRepository implements IDesignationRepository
    {
        public function get(string $key, string $value) : Models\Designation
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');

            $items =
                $this->select()
                ->where($key, $value)
                ->get();

            $item =
                $items->map(function($i) { return Factory::factory(Models\Designation::class, $i); })
                ->first();

            return $item;
        }

        public function getRange(string $key, array $values) : Collection
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');

            $items =
                $this->select()
                ->whereIn($key, $values)
                ->get();

            $items =
                $items->map(function($i) { return Factory::factory(Models\Designation::class, $i); });

            return $items;
        }

        public function getAll() : Collection
        {
            $items =
                $this->select()
                ->get();

            $items =
                $items->map(function($i) { return Factory::factory(Models\Designation::class, $i); });

            return $items;
        }

        protected function select()
        {
            $query = \DB::table('designations')
                ->select(
                    'id',
                    'slug',
                    'name',
                    'order'
                )
                ->orderBy('order');
            
            return $query;
        }
    }
}