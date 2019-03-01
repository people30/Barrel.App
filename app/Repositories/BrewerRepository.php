<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class BrewerRepository implements IBrewerRepository
    {
        public function __construction()
        {

        }

        public function find(array $where) : Models\Brewer
        {

        }

        public function findAll(array $where) : Collection
        {

        }
        
        public function getAreal(Models\Area $area): Models\Brewer
        {

        }
        
        public function getRange(string $key, array $values) : Collection
        {

        }
        
        public function getRandom() : Models\Brewer
        {

        }
        
        public function getAll() : Collection
        {
            $items =
                $this->select()
                ->get()
                ->map(function($i) { return Factory::factory(Models\Brewer::class, $i); });

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
                    'cities.name as city',
                    'brewers.town',
                    'brewers.lat',
                    'brewers.lon',
                    'brewers.owner',
                    'brewers.toji',
                    'brewers.buisiness_day as buisinessDays',
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