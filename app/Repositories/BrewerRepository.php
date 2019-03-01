<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class BrewerRepository implements IBrewerRepository
    {
        protected $areaRepository;

        public function __construct(IAreaRepository $ara)
        {
            $this->areaRepository = $ara;
        }

        public function find(array $where) : Models\Brewer
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

            $items = $query->get();
            $items = $this->factory($items);

            return $items;
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
        
        public function getRange(string $key, array $values) : Collection
        {
            if(!($key == 'id' || $key == 'slug')) throw new \InvalidArgumentException('key');
            
            $items =
                $this->select()
                ->whereIn($key, $values)
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
        
        public function getAll() : Collection
        {
            $items =
                $this->select()
                ->get();

            $items = $this->factory($items);

            return $items;
        }

        protected function factory(Collection $items) : Collection
        {
            $areaIds = $items->map(function($i) { return $i->areaId; })->unique()->toArray();
            $areas = $this->areaRepository->getRange('id', $areaIds);
            $items = $items->map(function($i) use ($areas)
            {
                $i->area = $areas->first(function($a) use ($i) { return $a->id == $i->areaId; });
                $i->address = $i->prefecture . $i->city . $i->town;

                return Factory::factory(Models\Brewer::class, $i);
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