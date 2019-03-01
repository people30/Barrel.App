<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class SizeRepository implements ISizeRepository
    {
        public function find(array $where) : Models\Size
        {
            return $this->findAll($where)->first();
        }

        public function findAll(array $where) : Collection
        {
            $query = $this->select();

            if(array_key_exists('id') && is_int($where['id']))
            {
                $this->where('id', $where['id']);
            }

            if(
                array_key_exists('priceMax', $where) &&
                array_key_exists('priceMin', $where) &&
                is_int($where['priceMax']) &&
                is_int($where['priceMin'])
            )
            {
                $query->where('price', '<=', $where['priceMax']);
                $query->where('price', '>=', $where['priceMin']);
            }

            $items =
                $query->get()
                ->map(function($i) { return Factory::factory(Models\Size::class, $i); });

            return $items;
        }
        
        public function getRange(string $key, array $values) : Collection
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');
            
            $items =
                $this->select()
                ->whereIn($key, $values)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Size::class, $i); });

            return $items;
        }
        
        public function getVariation(Models\Sake $sake) : Collection
        {
            $items =
                $this->select()
                ->where('sake_id', $sake->id)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Size::class, $i); });

            return $items;
        }
        
        public function getAll() : Collection
        {
            $items =
                $this->select()
                ->get()
                ->map(function($i) { return Factory::factory(Models\Size::class, $i); });

            return $items;
        }

        protected function select()
        {
            $query = \DB::table('sizes')
                ->select(
                    'id',
                    'sake_id as sakeId',
                    'content',
                    'price'
                )
                ->orderBy('price');
            
            return $query;
        }
    }
}