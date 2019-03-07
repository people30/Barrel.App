<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    class PhotoRepository implements IPhotoRepository
    {
        public function getBrewerAlbum(Models\Brewer $brewer) : Collection
        {
            $files = $this->getFiles('/brewer/' . $brewer->slug);
            return $this->factory($files);
        }

        public function getBrewerAlbumsIn(Collection $brewers) : Collection
        {
            return $brewers->map(function($b)
            {
                return $this->getBrewerAlbum($b);
            });
        }
        
        public function getSakeAlbum(Models\Sake $sake) : Collection
        {
            $files = $this->getFiles('/sake/' . $sake->slug . '/' . $sake->designation->slug);
            return $this->factory($files);
        }
        
        public function getSakeAlbumsIn(Collection $sakes) : Collection
        {
            return $sakes->map(function($s)
            {
                return $this->getSakeAlbum($s);
            });
        }

        protected function factory(array $files) : Collection
        {
            $items = collect([]);

            foreach($files as $filename => $sizes)
            {
                $photo = new Models\Photo();
                $photo->filename = $filename;
                $photo->files = collect([]);

                foreach($sizes as $filepath)
                {
                    $imageFile = new Models\ImageFile();
                    $imageFile->filepath = $filepath;

                    $size = explode('.', basename($filepath))[1];

                    list($width, $height) = explode('x', $size);

                    $imageFile->width = (int)$width;
                    $imageFile->height = (int)$height;

                    $photo->files->push($imageFile);

                    unset($width, $height);
                }

                $items->push($photo);
            }

            return $items;
        }

        protected function getFiles(string $directory) : array
        {
            $grouped = [];
            $files = [];

            if(!env('APP_DEBUG') && ($cache = \Cache::get($directory)) !== null)
            {
                $files = explode("\n", $cache);
            }
            else
            {
                $files = \Storage::disk('public')->files($directory);
                if(count($files) > 0 ) \Cache::put($directory, implode("\n", $files), now()->addSeconds(3600 * 5));
            }

            foreach($files as $filepath)
            {
                $exploded = explode('.', basename($filepath));

                // 名前・サイズ・拡張子の 3 個に分割で聞いていなければ不正なファイルとして扱う
                if(count($exploded) != 3) throw new \Exception($filepath . ' は不正なファイル名です。命名規則を確認してください。');

                list($filename, $size, $extension) = $exploded;

                $grouped[$filename][$size] = '/storage/' . $filepath;

                unset($filename, $size, $extension);
            }

            return $grouped;
        }
    }
}