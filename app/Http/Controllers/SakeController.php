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

        $keyword = $request->input('keyword', null);

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
        $designations = $this->designationRepository->findAll();

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

        // 現在のフィルタリング項目
        $filterContents = [];

        if($keyword !== null)
        {
            $filterContents[] = $keyword;
        }

        foreach($selectedTastes as $st)
        {
            $filterContents[] = $st->name;
        }

        foreach($selectedDesignations as $sd)
        {
            $filterContents[] = $sd->name;
        }

        if($selectedPriceMin !== null)
        {
            $filterContents[] = $selectedPriceMin . '円以上';
        }

        if($selectedPriceMax !== null)
        {
            $filterContents[] = $selectedPriceMax . '円以下';
        }
        
        return view('App.SakesPage',
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
                'selectedTastes',
                'filterContents')
            );
    }
}
