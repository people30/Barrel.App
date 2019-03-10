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
                $posts = collect($this->getPostsCacheByCategory($catId));

                if(count($posts) < 1)
                {
                    $posts = collect($this->getPostsByCategory($catId));
                }

                $postIds = $posts->map(function($post) { return $post->id; })->toArray();
                $categories = $this->getCategoriesInPosts($postIds);
                $tags = $this->getTagsInPosts($postIds);

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

        protected function putPostsCacheByCategory(int $catId, string $raw) : void
        {
            \Cache::put('stories.category.' . $catId . '.posts', $raw, now()->addSeconds(300));
        }

        protected function getPostsCacheByCategory(int $catId) : array
        {
            $cache = \Cache::get('stories.category.' . $catId . '.posts');

            if($cache == null) return [];

            return json_decode($cache);
        }

        protected function getPostsByCategory(int $catId) : array
        {
            $client = new Client();

            $res = $client->request(
                'GET',
                $this->wpUrl . '/wp-json/wp/v2/posts',
                [
                    'query' => [
                        'categories' => $catId,
                        'per_page' => 3
                    ]
                ]
            );

            $body = $res->getBody();
            $this->putPostsCacheByCategory($catId, $body);
            $body = json_decode($body);

            return $body;
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

        #region category
        
        protected function getCategoriesInPosts(array $postIds) : Collection
        {
            $promises = [];
            $caches = $this->getCategoriesCacheInPosts($postIds);
            
            // キャッシュが存在すれば新規取得をしないために投稿 ID リストから削除する
            foreach($caches as $postId => $cache)
            {
                $raws[$postId] = $cache;
                unset($postIds[$postId]);
            }

            $postRaw = collect($caches + $this->getCategoryRawsInPosts($postIds));
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

        protected function getCategoryRawsInPosts(array $postIds) : array
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
                    $this->putCategoriesCacheByPost($postId, $raw);

                return [ $postId => json_decode($raw) ];
            })
            ->toArray();

            return $raws;
        }

        protected function putCategoriesCacheByPost(int $postId, string $raw) : void
        {
            \Cache::put('stories.post.' . $postId . '.categories', $raw, now()->addSeconds(300));
        }

        protected function getCategoriesCacheInPosts(array $postIds) : array
        {
            $caches = [];

            foreach($postIds as $postId)
            {
                $cache = json_decode(\Cache::get('stories.post.' . $postId . '.categories'));

                if($cache != null)
                {
                    $caches[$postId] = $cache;
                }
            }

            return $caches;
        }
        
        #endregion

        #region Tags
        
        protected function getTagsInPosts(array $postIds) : Collection
        {
            $promises = [];
            $caches = $this->getTagsCacheInPosts($postIds);
            
            // キャッシュが存在すれば新規取得をしないために投稿 ID リストから削除する
            foreach($caches as $postId => $cache)
            {
                $raws[$postId] = $cache;
                unset($postIds[$postId]);
            }

            $postRaw = collect($caches + $this->getTagsRawInPosts($postIds));
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

        protected function getTagsRawInPosts(array $postIds) : array
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
                    $this->putTagsCahceInPost($postId, $raw);

                return [ $postId => json_decode($raw) ];
            })
            ->toArray();

            return $raws;
        }

        protected function putTagsCahceInPost(int $postId, string $raw) : void
        {
            \Cache::put('stories.post.' . $postId . '.tags', $raw, now()->addSeconds(300));
        }

        protected function getTagsCacheInPosts(array $postIds) : array
        {
            $caches = [];

            foreach($postIds as $postId)
            {
                $cache = json_decode(\Cache::get('stories.post.' . $postId . '.tags'));

                if($cache != null)
                {
                    $caches[$postId] = $cache;
                }
            }

            return $caches;
        }

        #endregion
    }
}