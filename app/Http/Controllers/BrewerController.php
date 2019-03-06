<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;

class BrewerController extends Controller
{
    protected $brewerRepository;
    protected $areaRepository;
    protected $photoRepository;
    protected $sakeRepository;

    public function __construct(Repositories\IBrewerRepository $brw, Repositories\IAreaRepository $ara, Repositories\IPhotoRepository $pht, Repositories\ISakeRepository $sak)
    {
        $this->brewerRepository = $brw;
        $this->areaRepository = $ara;
        $this->photoRepository = $pht;
        $this->sakeRepository = $sak;
    }

    public function index(Request $request)
    {
        $request->validate([
            'selectedArea' => 'integer',
            'backstageSeeableStatus' => 'in:seeable,unseeable'
        ]);

        $params = $request->all();
        $areas = $this->areaRepository->findAll();
        $allBrewers = $this->brewerRepository->findAll();
        $brewers = $allBrewers->filter(function($b) use($params) {
            // エリアに一致
            $areaMatched = true;
            
            if(array_key_exists('selectedAreaId', $params))
                $areaMatched = $b->area->id == (int)$params['selectedAreaId'];

            // 蔵の見学ができるかどうか
            $backstageSeeableStatusMatched = true;

            if(array_key_exists('backstageSeeableStatus', $params))
            {
                $check = $params['backstageSeeableStatus'] == 'seeable';
                $backstageSeeableStatusMatched = $b->isBackstageSeeable == $check;
            }
            
            return $areaMatched && $backstageSeeableStatusMatched;
        });

        return view('App.BrewersPage', compact('allBrewers', 'areas', 'brewers'));
    }

    public function show(Request $request, string $slug)
    {
        $allBrewers = $this->brewerRepository->findAll();
        $brewer = $allBrewers->first(function($b) use($slug) { return $b->slug == $slug; });
        $photos = $this->photoRepository->getBrewerAlbum($brewer);
        $stories = collect([]);
        $products = $this->sakeRepository->getProducts($brewer);

        return view('App.BrewerDetailsPage', compact('allBrewers', 'brewer', 'photos', 'stories', 'products'));
    }
}
