<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class SakeRepository implements ISakeRepository
    {
        protected $brewerRepository;
        protected $tasteRepository;
        protected $designationRepository;

        public function __construct(IBrewerRepository $brw, ITasteRepository $tst, IDesignationRepository $dsn)
        {
            $this->brewerRepository = $brw;
            $this->tasteRepository = $tst;
            $this->designationRepository = $dsn;
        }

        public function find(array $params = []) : ?Models\Sake
        {
            $params['limit'] = 1;

            $items =
                $this->findInternal($params)
                ->get();
            $items =
                $this->factory($items)
                ->first();

            return $items;
        }

        public function findAll(array $params = []) : Collection
        {
            $items =
                $this->findInternal($params)
                ->get();
            $items = $this->factory($items);

            return $items;
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

            if(array_key_exists('keyword', $params) && is_string($params['keyword']))
            {
                $query = $query->where('name', 'like', '%' . $params['keyword'] . '%');
            }

            return $query;
        }
        
        public function getIn(array $ids) : Collection
        {
            $items =
                $this->select()
                ->whereIn('id', $ids)
                ->get();

            $items = $this->factory($items);

            return $items;
        }

        protected function factory(Collection $items) : Collection
        {
            $brewerIds = $items->map(function($i) { return $i->brewerId; })->toArray();
            $brewers = $this->brewerRepository->getIn($brewerIds);
            
            $tasteIds = $items->map(function($i) { return $i->tasteId; })->toArray();
            $tastes = $this->tasteRepository->getIn($tasteIds);
            
            $designationIds = $items->map(function($i) { return $i->designationId; })->toArray();
            $designations = $this->designationRepository->getIn($designationIds);
            
            $items = $items->map(function($i) use ($brewers, $tastes, $designations)
            {
                $i->brewer = $brewers->first(function($b) use ($i) { return $b->id == $i->brewerId; });
                $i->taste = $tastes->first(function($b) use ($i) { return $b->id == $i->tasteId; });
                $i->designation = $designations->first(function($b) use ($i) { return $b->id == $i->designationId; });

                return Factory::factory(Models\Sake::class, $i);
            });

            return $items;
        }
        
        public function getProducts(Models\Brewer $brewer) : Collection
        {
            $items = 
                $this->select()
                ->where('brewer_id', $brewer->id)
                ->get();
            
            $items = $this->factory($items);

            return $items;
        }

        protected function select()
        {
            $query = \DB::table('sakes')
                ->select(
                    'id',
                    'slug',
                    'name',
                    'order',
                    'bottle_filename as bottleFilename',
                    'brewer_id as brewerId',
                    'designation_id as designationId',
                    'taste_id as tasteId',
                    'alcoholicity',
                    'raw_rice as rawRice',
                    'text'
                )
                ->orderBy('order');
            
            return $query;
        }
    }
}