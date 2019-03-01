<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    interface IPhotoRepository
    {
        public function getByBrewer(Models\Brewer $brewer, string $filename) : Models\Photo;
        public function getAllByBrewer(Models\Brewer $brewer) : Collection;
        public function getBySake(Models\Sake $sake, string $filename) : Models\Photo;
        public function getAllBySake(Models\Sake $sake) : Collection;
    }
}