<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    class LinkRepository implements ILinkRepository
    {
        public function getRelatedLinks(Models\Brewer $brewer) : Collection
        {
            return
                $this->select()
                ->where('brewer_id', $brewer->id)
                ->get()
                ->map(function($l) {
                    return Factory::factory(Models\Link::class, $l);
                });
        }

        public function getRelatedLinksIn(array $ids) : Collection
        {
            return
                $this->select()
                ->whereIn('id', $ids)
                ->get()
                ->map(function($l) {
                    return Factory::factory(Models\Link::class, $l);
                });
        }

        protected function select()
        {
            $query = \DB::table('links')
                ->select(
                    'id',
                    'brewer_id as brewerId',
                    'service',
                    'url'
                )
                ->orderBy('service');
            
            return $query;
        }
    }
}