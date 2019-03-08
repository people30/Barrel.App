<?php

namespace App\Repositories
{
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;
    use GuzzleHttp\Client;

    class ArticleRepository implements IArticleRepository
    {
        public function getStories(Models\Brewer $brewer) : Collection
        {
            $catId = $this->getCategoryId($brewer);

            $client = new Client();

            $res = $client->request('GET', env('WP_URL') . '/wp-json/wp/v2/posts', ['categories' => $catId]);
            $body = (string)$res->getBody();
            $body = json_decode($body);

            return collect($body);
        }

        protected function getCategoryId(Models\Brewer $brewer) : int
        {
            $row = \DB::table('brewer_post_categories')
            ->select(
                'brewer_id as brewerId',
                'post_category_id as postCategoryId'
            )
            ->where('brewer_id', $brewer->id)
            ->get()
            ->first();

            return $row->postCategoryId;
        }
    }
}