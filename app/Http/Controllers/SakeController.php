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
            'selectedDesignations' => 'string',
            'selectesTastes' => 'string'
        ]);
        
        $params = [];

        $params['keyword'] = $request->has('keyword')
            ? $request->input('keyword')
            : null;

        $params['selectedPriceMax'] = $request->has('selectedPriceMax')
            ? (int)$request->input('selectedPriceMax')
            : null;

        $params['selectedPriceMin'] = $request->has('selectedPriceMin')
            ? (int)$request->input('selectedPriceMin')
            : null;

        $params['selectedDesignations'] = $request->has('selectedDesignations')
            ? explode(',', $request->input('selectedDesignations', ''))
            : null;

        $params['selectedTastes'] = $request->has('selectedTastes')
            ? explode(',', $request->input('selectesTastes', ''))
            : null;

        $allBrewers = $this->brewerRepository->findAll();
        $sakes = $this->sakeRepository->findAll(array_filter($params, function($param)
        {
            return $param !== null;
        }));

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

        if($params['selectedTastes'] !== null)
        {
            $selectedTastes = $tastes->filter(function($t) use($params)
            {
                return in_array($t->id, $params['selectedTastes']);
            });
        }
        else
        {
            $selectedTastes = collect([]);
        }

        $designations = $this->designationRepository->findAll();

        if($params['selectedDesignations'] !== null)
        {
            $selectedDesignations = $designations->filter(function($d) use($params)
            {
                return in_array($d->id, $params['selectedDesignations']);
            });
        }
        else
        {
            $selectedDesignations = collect([]);
        }

        return view('App.Sakespage', compact('allBrewers', 'sakes', 'tastes', 'designations', 'priceMax', 'priceMin') + $params);
    }
}
