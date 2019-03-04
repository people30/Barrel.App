<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class AreaRepository implements IAreaRepository
    {
        public function find(array $params = []) : ?Models\Area
        {
            $params['limit'] = 1;

            return
                $this->findInternal($params)
                ->get()
               ->map(function($i) { return Factory::factory(Models\Area::class, $i); })
                ->first();
        }

        public function findAll(array $params = []) : Collection
        {
            return
                $this->findInternal($params)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Area::class, $i); });
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

            return $query;
        }
        
        public function getIn(array $ids) : Collection
        {
            $items =
                $this->select()
                ->whereIn('id', $ids)
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