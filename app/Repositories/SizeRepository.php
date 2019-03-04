<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class SizeRepository implements ISizeRepository
    {
        public function find(array $params = []) : ?Models\Size
        {
            $params['limit'] = 1;

            return
                $this->findInternal($params)
                ->get()
               ->map(function($i) { return Factory::factory(Models\Size::class, $i); })
                ->first();
        }

        public function findAll(array $params = []) : Collection
        {
            return
                $this->findInternal($params)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Size::class, $i); });
        }

        protected function findInternal(array $params)
        {
            $query = $this->select();

            if(array_key_exists('id', $params) && is_int($params['id']))
            {
                $query = $query->where('id', $params['id']);
            }

            if(array_key_exists('slug', $params) && is_int($params['slug']))
            {
                $query = $query->where('slug', $params['slug']);
            }

            if(array_key_exists('limit', $params) && is_int($params['limit']))
            {
                $query = $query->limit($params['limit']);
            }

            if(array_key_exists('offset', $params) && is_int($params['offset']))
            {
                $query = $query->limit($params['offset']);
            }

            if(
                array_key_exists('priceMax', $params) &&
                array_key_exists('priceMin', $params) &&
                is_int($params['priceMax']) &&
                is_int($params['priceMin'])
            )
            {
                $query->where('price', '<=', $params['priceMax']);
                $query->where('price', '>=', $params['priceMin']);
            }

            return $query;
        }
        
        public function getIn(array $ids) : Collection
        {
            $items =
                $this->select()
                ->whereIn('id', $ids)
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