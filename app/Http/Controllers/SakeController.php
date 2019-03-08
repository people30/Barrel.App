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
            'keyword' => 'string',
            'selectedPriceMax' => 'integer',
            'selectedPriceMin'=> 'integer',
            'selectedDesignations' => 'array',
            'selectesTastes' => 'array'
        ]);
        
        $params = [];

        $keyword = $request->has('keyword', null);

        $selectedPriceMax = $request->has('selectedPriceMax')
            ? (int)$request->input('selectedPriceMax')
            : null;

        $selectedPriceMin = $request->has('selectedPriceMin')
            ? (int)$request->input('selectedPriceMin')
            : null;

        $selectedDesignations = $request->has('selectedDesignations')
            ? $request->input('selectedDesignations')
            : null;

        $selectedTastes = $request->has('selectedTastes')
            ? $request->input('selectesTastes')
            : null;

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

        $prices = [];

        $sakes->each(function($sake) use(&$prices)
        {
            $sake->sizes->each(function($size) use(&$prices)
            {
                $prices[] = $size->price;
            });
        });

        if(count($prices) > 0)
        {
            $priceMax = max($prices);
            $priceMin = min($prices);
        }
        else
        {
            $priceMax = null;
            $priceMin = null;
        }

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
                'selectedTastes'));
    }
}
