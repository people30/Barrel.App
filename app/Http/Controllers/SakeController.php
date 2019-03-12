<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;

class SakeController extends Controller
{
    protected $brewerRepository;
    protected $sakeRepository;
    protected $tasteRepository;
    protected $designationRepository;

    public function __construct(Repositories\IBrewerRepository $brw, Repositories\ISakeRepository $sak, Repositories\ITasteRepository $tst, Repositories\DesignationRepository $des)
    {
        $this->brewerRepository = $brw;
        $this->sakeRepository = $sak;
        $this->tasteRepository = $tst;
        $this->designationRepository = $des;
    }

    //
    public function index(Request $request)
    {
        $request->validate([
            'keyword' => 'string|nullable',
            'selectedPriceMax' => 'integer|nullable',
            'selectedPriceMin'=> 'integer|nullable',
            'selectedDesignations' => 'array|nullable',
            'selectedTastes' => 'array|nullable'
        ]);
        
        $params = [];

        $keyword = $request->has('keyword', null);

        $selectedPriceMax = $request->input('selectedPriceMax', null);
        if($selectedPriceMax !== null) $selectedPriceMax = (int)$selectedPriceMax;

        $selectedPriceMin = $request->input('selectedPriceMin', null);
        if($selectedPriceMin !== null) $selectedPriceMin = (int)$selectedPriceMin;

        $selectedDesignations = $request->input('selectedDesignations', null);

        $selectedTastes = $request->input('selectedTastes', null);

        $allBrewers = $this->brewerRepository->findAll();
        $sakes = $this->sakeRepository->findAll(
            array_filter(
                compact('keyword', 'selectedPriceMax', 'selectedPriceMin', 'selectedDesignations', 'selectedTastes'),
                function($param)
                {
                    return $param !== null;
                }
            )
        );

        $price = $this->sakeRepository->getPriceRange();
        $priceMax = $price['max'];
        $priceMin = $price['min'];

        $tastes = $this->tasteRepository->findAll();

        if($selectedTastes !== null)
        {
            $selectedTastes = $tastes->filter(function($t) use($selectedTastes)
            {
                return in_array($t->id, $selectedTastes);
            });
        }
        else
        {
            $selectedTastes = collect([]);
        }

        $designations = $this->designationRepository->findAll();

        if($selectedDesignations !== null)
        {
            $selectedDesignations = $designations->filter(function($d) use($selectedDesignations)
            {
                return in_array($d->id, $selectedDesignations);
            });
        }
        else
        {
            $selectedDesignations = collect([]);
        }

        return view('App.Sakespage',
            compact(
                'allBrewers',
                'sakes',
                'tastes',
                'designations',
                'priceMax',
                'priceMin',
                'keyword',
                'selectedPriceMax',
                'selectedPriceMin',
                'selectedDesignations',
                'selectedTastes')
            );
    }
}
