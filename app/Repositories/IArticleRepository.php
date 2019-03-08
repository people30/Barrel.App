<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;

    interface IArticleRepository
    {
        public function getStories(Models\Brewer $brewer) : Collection;
    }
}