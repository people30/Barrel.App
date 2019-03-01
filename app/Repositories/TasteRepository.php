<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class TasteRepository implements ITasteRepository
    {
        public function get(string $key, string $value) : Models\Taste
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');

            $items =
                $this->select()
                ->where($key, $value)
                ->get();

            $items =
                $items->map(function($i) { return Factory::factory(Models\Taste::class, $i); })
                ->first();

            return $items;
        }

        public function getRange(string $key, array $values) : Collection
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');

            $items =
                $this->select()
                ->whereIn($key, $values)
                ->get();

            $items =
                $items->map(function($i) { return Factory::factory(Models\Taste::class, $i); });

            return $items;
        }
        
        public function getAll() : Collection
        {
            $items =
                $this->select()
                ->get();

            $items =
                $items->map(function($i) { return Factory::factory(Models\Taste::class, $i); });

            return $items;
        }

        protected function select()
        {
            $query = \DB::table('tastes')
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