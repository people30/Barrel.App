<?php

namespace App\Repositories
{
    use App\Models;
    use Illuminate\Support\Collection;

    class PhotoRepository implements IPhotoRepository
    {
        public function getByBrewer(Models\Brewer $brewer, string $filename) : ?Models\Photo
        {
            return
                $this->getAllByBrewer($brewer)
                ->first(function($item) use($filename) { return $item->filename == $filename; });
        }

        public function getAllByBrewer(Models\Brewer $brewer) : Collection
        {
            $files = $this->getFiles('/brewer/' . $brewer->slug);
            return $this->factory($files);
        }
        
        public function getBySake(Models\Sake $sake, string $filename) : ?Models\Photo
        {

        }
        
        public function getAllBySake(Models\Sake $sake) : Collection
        {

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

            if(($cache = \Cache::get($directory)) !== null)
            {
                $files = explode("\n", $cache);
            }
            else
            {
                $files = \Storage::disk('public')->files($directory);
                \Cache::put($directory, implode("\n", $files,), now()->addSeconds(3600 * 5));
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