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
            'priceMax' => 'integer',
            'priceMin'=> 'integer',
            'keyword' => 'string',
            'selectedDesignations' => 'string',
            'selectesTastes' => 'string'
        ]);

        $allBrewers = $this->brewerRepository->findAll();
        $sakes = $this->sakeRepository->findAll($request->all());
        $tastes = $this->tasteRepository->findAll();
        $designations = $this->designationRepository->findAll();

        return view('App.Sakespage', compact('allBrewers', 'sakes', 'tastes', 'designations'));
    }
}
