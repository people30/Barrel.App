<?php

namespace App\Repositories
{
    use App\Exceptions;
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;
    use GuzzleHttp\Client;

    class ArticleRepository implements IArticleRepository
    {
        protected $wpUrl;

        public function __construct()
        {
            $this->wpUrl = env('WP_URL');

            if(empty($this->wpUrl)) throw new Exceptions\WpUrlUnregisterdException();
        }

        public function getStories(Models\Brewer $brewer) : Collection
        {
            try
            {
                $catId = $this->getCategoryId($brewer);
                $client = new Client();

                $res = $client->request('GET', $this->wpUrl . '/wp-json/wp/v2/posts', ['categories' => $catId]);
                $body = (string)$res->getBody();
                $body = json_decode($body);

                return collect($body);
            }
            catch(\Throwable $th)
            {
                return collect([]);
            }
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

            if($row === null) throw new Exceptions\BrewerPostCategoryUnregisteredException($brewer);

            return $row->postCategoryId;
        }
    }
}