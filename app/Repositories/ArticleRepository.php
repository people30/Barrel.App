<?php

namespace App\Repositories
{
    use App\Exceptions;
    use App\Models;
    use App\Factories\Factory;
    use Illuminate\Support\Collection;
    use GuzzleHttp\Client;
    use GuzzleHttp\Promise;

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

                $res = $client->request(
                    'GET',
                    $this->wpUrl . '/wp-json/wp/v2/posts',
                    [
                        'query' => ['categories' => $catId]
                    ]
                );
                $body = (string)$res->getBody();
                $posts = collect(json_decode($body));

                $postIds = $posts->map(function($post) { return $post->id; })->toArray();
                $categories = $this->getPostCategoriesIn($postIds);
                $tags = $this->getPostTagsIn($postIds);

                $posts = $posts->map(function($raw) use($categories, $tags)
                {
                    $article = new Models\Article();
                    $article->publishedAt = new \DateTIme($raw->date);
                    $article->id = $raw->id;
                    $article->link = $raw->link;
                    $article->slug = $raw->slug;
                    $article->title = $raw->title->rendered;
                    $article->text = trim(strip_tags($raw->content->rendered));
                    $article->html = $raw->content->rendered;
                    $article->categories = $categories[$raw->id];
                    $article->tags = $tags[$raw->id];

                    return $article;
                });

                return $posts;
            }
            catch(\Throwable $th)
            {
                throw $th;
                // return collect([]);
            }
        }
        
        protected function getPostCategoriesIn(array $postIds) : Collection
        {
            $promises = [];
            $caches = $this->getPostCategoryCaches($postIds);
            
            // キャッシュが存在すれば新規取得をしないために投稿 ID リストから削除する
            foreach($caches as $postId => $cache)
            {
                $raws[$postId] = $cache;
                unset($postIds[$postId]);
            }

            $postRaw = collect($caches + $this->getPostCategoryRaws($postIds));
            $grouped = collect([]);

            foreach($postRaw as $postId => $catsRaw)
            {
                $categories = collect([]);

                foreach($catsRaw as $catRaw)
                {
                    $c = new Models\ArticleCategory();
                    $c->id = $catRaw->id;
                    $c->link = $catRaw->link;
                    $c->name = $catRaw->name;
                    $c->slug = $catRaw->slug;

                    $categories->push($c);
                }

                $grouped[$postId] = $categories;
            }

            return $grouped;
        }

        protected function getPostCategoryRaws(array $postIds) : array
        {
            $client = new Client();
            $promises = [];

            foreach($postIds as $postId)
            {
                $promises[$postId] = $client->getAsync(
                    $this->wpUrl . '/wp-json/wp/v2/categories',
                    [
                        'query' => [
                            'post' => $postId
                        ]
                    ]
                );
            }

            $responses = collect(Promise\settle($promises)->wait());
            $raws = $responses->mapWithKeys(function($response, $postId)
            {
                $raw = $response['value']->getBody();

                if(!env('APP_DEBUG'))
                    $this->putPostCategoryCache($postId, $raw);

                return [ $postId => json_decode($raw) ];
            })
            ->toArray();

            return $raws;
        }

        protected function putPostCategoryCache(int $postId, string $raw) : void
        {
            \Cache::put('stories.' . $postId . '.categories', $raw, now()->addSeconds(300));
        }

        protected function getPostCategoryCaches(array $postIds) : array
        {
            $caches = [];

            foreach($postIds as $postId)
            {
                $cache = json_decode(\Cache::get('stories.' . $postId . '.categories'));

                if($cache != null)
                {
                    $caches[$postId] = $cache;
                }
            }

            return $caches;
        }

        #region Tags
        
        protected function getPostTagsIn(array $postIds) : Collection
        {
            $promises = [];
            $caches = $this->getPostTagCaches($postIds);
            
            // キャッシュが存在すれば新規取得をしないために投稿 ID リストから削除する
            foreach($caches as $postId => $cache)
            {
                $raws[$postId] = $cache;
                unset($postIds[$postId]);
            }

            $postRaw = collect($caches + $this->getPostTagRaws($postIds));
            $grouped = collect([]);

            foreach($postRaw as $postId => $catsRaw)
            {
                $tags = collect([]);

                foreach($catsRaw as $catRaw)
                {
                    $c = new Models\ArticleTag();
                    $c->id = $catRaw->id;
                    $c->link = $catRaw->link;
                    $c->name = $catRaw->name;
                    $c->slug = $catRaw->slug;

                    $tags->push($c);
                }

                $grouped[$postId] = $tags;
            }

            return $grouped;
        }

        protected function getPostTagRaws(array $postIds) : array
        {
            $client = new Client();
            $promises = [];

            foreach($postIds as $postId)
            {
                $promises[$postId] = $client->getAsync(
                    $this->wpUrl . '/wp-json/wp/v2/tags',
                    [
                        'query' => [
                            'post' => $postId
                        ]
                    ]
                );
            }

            $responses = collect(Promise\settle($promises)->wait());
            $raws = $responses->mapWithKeys(function($response, $postId)
            {
                $raw = $response['value']->getBody();

                if(!env('APP_DEBUG'))
                    $this->putPostTagCache($postId, $raw);

                return [ $postId => json_decode($raw) ];
            })
            ->toArray();

            return $raws;
        }

        protected function putPostTagCache(int $postId, string $raw) : void
        {
            \Cache::put('stories.' . $postId . '.tags', $raw, now()->addSeconds(300));
        }

        protected function getPostTagCaches(array $postIds) : array
        {
            $caches = [];

            foreach($postIds as $postId)
            {
                $cache = json_decode(\Cache::get('stories.' . $postId . '.tags'));

                if($cache != null)
                {
                    $caches[$postId] = $cache;
                }
            }

            return $caches;
        }

        #endregion
        
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