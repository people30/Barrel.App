<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class AreaRepository implements IAreaRepository
    {
        public function get(string $key, string $value) : Models\Area
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');

            $items =
                $this->select()
                ->where($key, $value)
               ->get()
               ->map(function($i) { return Factory::factory(Models\Area::class, $i); })
                ->first();

            return $items;
        }
        
        public function getRange(string $key, array $values) : Collection
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');

            $items =
                $this->select()
                ->whereIn($key, $values)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Area::class, $i); });

            return $items;
        }

        public function getAll() : Collection
        {
            $items =
                $this->select()
                ->get()
                ->map(function($i) { return Factory::factory(Models\Area::class, $i); });

            return $items;
        }

        protected function select()
        {
            $query = \DB::table('areas')
                ->join(
                    'prefectures',
                    'prefectures.code',
                    '=',
                    'areas.prefecture_code'
                )
                ->select(
                    'areas.id',
                    'prefectures.name as prefecture',
                    'areas.name',
                    'areas.order'
                )
                ->orderBy('order');
            
            return $query;
        }
    }
}