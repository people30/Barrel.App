<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IPhotoRepository
    {
        public function getBrewerAlbum(Models\Brewer $brewer) : Collection;
        public function getBrewerAlbumsIn(Collection $brewers) : Collection;
        public function getSakeAlbum(Models\Sake $sake) : Collection;
        public function getSakeAlbumsIn(Collection $sakes) : Collection;
    }
}