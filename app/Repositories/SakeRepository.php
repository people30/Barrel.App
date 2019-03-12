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
        protected $sizeRepository;
        protected $photoRepository;

        public function __construct(IBrewerRepository $brw, ITasteRepository $tst, IDesignationRepository $dsn, ISizeRepository $siz, IPhotoRepository $pht)
        {
            $this->brewerRepository = $brw;
            $this->tasteRepository = $tst;
            $this->designationRepository = $dsn;
            $this->sizeRepository = $siz;
            $this->photoRepository = $pht;
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
                $query = $query->where('sakes.id', $params['id']);
            }

            if(array_key_exists('slug', $params) && is_int($params['slug']))
            {
                $query = $query->where('sakes.slug', $params['slug']);

                if(array_key_exists('designationSlug', $params) && is_int($params['designationSlug']))
                {
                    $query = $query->where('sakes.designation_slug', $params['designationSlug']);
                }
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
                $query = $query->where('sakes.name', 'like', '%' . $params['keyword'] . '%');
            }

            if(array_key_exists('selectedPriceMax', $params) && is_int($params['selectedPriceMax']))
            {
                $query = $query->where('sizes.price', '<=', $params['selectedPriceMax']);
            }

            if(array_key_exists('selectedPriceMin', $params) && is_int($params['selectedPriceMin']))
            {
                $query = $query->where('sizes.price', '>=', $params['selectedPriceMin']);
            }

            if(array_key_exists('selectedDesignations', $params) && is_array($params['selectedDesignations']))
            {
                $query = $query->where(function($query) use($params)
                {
                    foreach($params['selectedDesignations'] as $designationId)
                    {
                        $query = $query->orWhere('sakes.designation_id', $designationId);
                    }
                });
            }

            if(array_key_exists('selectedTastes', $params) && is_array($params['selectedTastes']))
            {
                foreach($params['selectedTastes'] as $tasteId)
                {
                    $query = $query->orWhere('sakes.taste_id', $tasteId);
                }
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
            $sakeIds = $items->map(function($i) { return $i->id; })->toArray();
            $sizes = $this->sizeRepository->getValiationsIn($sakeIds);

            $grouped = $items->map(function($i) use ($brewers, $tastes, $designations, $sizes)
            {
                $i->brewer = $brewers->first(function($b) use ($i) { return $b->id == $i->brewerId; });
                $i->taste = $tastes->first(function($b) use ($i) { return $b->id == $i->tasteId; });
                $i->designation = $designations->first(function($b) use ($i) { return $b->id == $i->designationId; });

                return $i;
            })
            ->groupBy(function($i)
            {
                return $i->id;
            })
            ->map(function($group)
            {
                $raw = $group->first();
                $sake = Factory::factory(Models\Sake::class, $raw);
                $sake->bottle = $this->photoRepository->getSakeAlbum($sake)->first(function($s) use($raw)
                {
                    return $s->filename == $raw->bottleFilename;
                });

                $sake->sizes = $group->map(function($i)
                {
                    return Factory::factory(Models\Size::class, $i);
                });

                return $sake;
            });

            return $grouped;
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
                ->join('designations', 'designations.id', '=', 'sakes.designation_id')
                ->join('sizes', 'sizes.sake_id', '=', 'sakes.id')
                ->select(
                    'sakes.id',
                    'sakes.slug',
                    'sakes.name',
                    'sakes.order',
                    'sakes.bottle_filename as bottleFilename',
                    'sakes.brewer_id as brewerId',
                    'sakes.designation_id as designationId',
                    'designations.slug as designationSlug',
                    'sakes.taste_id as tasteId',
                    'sakes.alcoholicity',
                    'sakes.raw_rice as rawRice',
                    'sakes.rice_polishing_ratio as ricePollishingRatio',
                    'sizes.content',
                    'sizes.price',
                    'sakes.text'
                )
                ->orderBy('order')
                ->orderBy('content');
            
            return $query;
        }
    }
}