<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class BrewerRepository implements IBrewerRepository
    {
        protected $photoRepository;
        protected $areaRepository;
        protected $linkRepository;

        public function __construct(IPhotoRepository $pht, IAreaRepository $ara, ILinkRepository $lnk)
        {
            $this->photoRepository = $pht;
            $this->areaRepository = $ara;
            $this->linkRepository = $lnk;
        }

        public function find(array $params = []) : ?Models\Brewer
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

            return $query;
        }
        
        public function getAreal(Models\Area $area) : Collection
        {
            $items =
                $this->select()
                ->where('area_id', $area->id)
                ->get();

            $items = $this->factory($items);

            return $items;
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
        
        public function getRandom() : Models\Brewer
        {
            $items =
                $this->select()
                ->orderByRaw('rand()')
                ->limit(1)
                ->get();

            $item = $this->factory($items)->first();

            return $item;
        }

        protected function factory(Collection $items) : Collection
        {
            $brewerIds = $items->map(function($i) { return $i->id; })->unique()->toArray();
            $areaIds = $items->map(function($i) { return $i->areaId; })->unique()->toArray();

            $links = $this->linkRepository->getRelatedLinksIn($brewerIds);
            $areas = $this->areaRepository->getIn($areaIds);

            $items = $items->map(function($i) use ($areas, $links)
            {
                $i->area = $areas->first(function($a) use ($i) { return $a->id == $i->areaId; });
                $i->address = $i->prefecture . $i->city . $i->town;
                $i->isBackstageSeeable = (bool)$i->isBackstageSeeable;
                $i->links = $links->filter(function($l) use ($i) { return $l->brewerId === $i->id; });

                $brewer = Factory::factory(Models\Brewer::class, $i);

                if($i->keyVisualFilename != null)
                    $brewer->keyVisual = $this->photoRepository->getByBrewer($brewer, $i->keyVisualFilename);

                return $brewer;
            });

            return $items;
        }

        protected function select()
        {
            $query = \DB::table('brewers')
                ->join('cities', 'cities.city_code', '=', 'brewers.city_code')
                ->join('prefectures', 'prefectures.code', '=', 'cities.prefecture_code')
                ->select(
                    'brewers.id',
                    'brewers.slug',
                    'brewers.name',
                    'brewers.order',
                    'brewers.phone_number as phoneNumber',
                    'brewers.fax_number as faxNumber',
                    'brewers.email',
                    'prefectures.name as prefecture',
                    'cities.area_id as areaId',
                    'cities.name as city',
                    'brewers.town',
                    'brewers.lat',
                    'brewers.lon',
                    'brewers.owner',
                    'brewers.toji',
                    'brewers.buisiness_day as buisinessDay',
                    'brewers.opening_time as openingTime',
                    'brewers.closing_time as closingTime',
                    'brewers.is_backstage_seeable as isBackstageSeeable',
                    'brewers.key_visual_filename as keyVisualFilename',
                    'brewers.text'
                )
                ->orderBy('order');
            
            return $query;
        }
    }
}