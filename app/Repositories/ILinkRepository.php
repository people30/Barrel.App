<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface ILinkRepository
    {
        public function getRelatedLinks(Models\Brewer $brewer) : Collection;
        public function getRelatedLinksIn(array $ids) : Collection;
    }
}