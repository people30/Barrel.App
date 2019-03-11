<?php

namespace App\Http\Controllers;

use App\Repositories;
use App\Exceptions;
use Illuminate\Http\Request;

class BrewerController extends Controller
{
    protected $brewerRepository;
    protected $areaRepository;
    protected $photoRepository;
    protected $sakeRepository;
    protected $articleRepository;

    public function __construct(Repositories\IBrewerRepository $brw, Repositories\IAreaRepository $ara, Repositories\IPhotoRepository $pht, Repositories\ISakeRepository $sak, Repositories\IArticleRepository $art)
    {
        $this->brewerRepository = $brw;
        $this->areaRepository = $ara;
        $this->photoRepository = $pht;
        $this->sakeRepository = $sak;
        $this->articleRepository = $art;
    }

    public function index(Request $request)
    {
        $request->validate([
            'selectedArea' => 'integer|nullable',
            'backstageTour' => 'in:available,unavailable|nullable'
        ]);

        $areas = $this->areaRepository->findAll();
        $allBrewers = $this->brewerRepository->findAll();

        $selectedAreaId = 
            $request->has('selectedArea')
            ? (int)$request->input('selectedArea', null)
            : null;
        $selectedArea = $areas->first(function($a) use($selectedAreaId)
        {
            return $a->id == $selectedAreaId;
        });

        $backstageTour = $request->input('backstageTour', null);

        $brewers = $allBrewers->filter(function($b) use($selectedArea, $backstageTour)
        {
            // エリアが選択された時
            if($selectedArea !== null)
            {
                $areaMatched = $b->area->id == $selectedArea->id;
            }
            // エリアが未指定の時
            else
            {
                $areaMatched = true;
            }

            // 蔵見学の指定がある時
            if($backstageTour !== null)
            {
                $check = $backstageTour == 'available';
                $backstageTourMatched = $b->isBackstageSeeable == $check;
            }
            // 蔵見学の指定がない時
            else
            {
                $backstageTourMatched = true;
            }
            
            return $areaMatched && $backstageTourMatched;
        })
        ->values();

        return view('App.BrewersPage', compact('allBrewers', 'areas', 'brewers', 'selectedArea', 'backstageTour'));
    }

    public function show(Request $request, string $slug)
    {
        $allBrewers = $this->brewerRepository->findAll();
        $brewer = $allBrewers->first(function($b) use($slug) { return $b->slug == $slug; });
        $errors = collect([]);

        if($brewer == null) abort(404);

        $photos = $this->photoRepository->getBrewerAlbum($brewer);
        $products = $this->sakeRepository->getProducts($brewer);

        try
        {
            $stories = $this->articleRepository->getStories($brewer);
        }
        catch(Exceptions\BrewerPostCategoryUnregisteredException $th)
        {
            $stories = collect([]);
        }
        catch(\Throwable $th)
        {
            if(env('APP_DEBUG'))
            {
                throw $th;
            }
            else
            {
                \Log::error($th->getMessage());
                $stories = collect([]);
            }
        }

        return view('App.BrewerDetailsPage', compact('allBrewers', 'brewer', 'photos', 'stories', 'products'));
    }
}
