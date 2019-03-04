<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class DesignationRepository implements IDesignationRepository
    {
        public function find(array $params = []) : ?Models\Designation
        {
            $params['limit'] = 1;

            return
                $this->findInternal($params)
                ->get()
               ->map(function($i) { return Factory::factory(Models\Designation::class, $i); })
                ->first();
        }

        public function findAll(array $params = []) : Collection
        {
            return
                $this->findInternal($params)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Designation::class, $i); });
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
        
        public function getRange(array $ids) : Collection
        {
            $items =
                $this->select()
                ->whereIn('id', $ids)
                ->get()
                ->map(function($i) { return Factory::factory(Models\Designation::class, $i); });

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