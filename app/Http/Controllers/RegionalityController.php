<?php

namespace App\Http\Controllers;

use App\Repositories;
use Illuminate\Http\Request;

class RegionalityController extends Controller
{
    protected $brewerRepository;

    public function __construct(Repositories\IBrewerRepository $brw)
    {
        $this->brewerRepository = $brw;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $allBrewers = $this->brewerRepository->findAll();

        //
        return view('App.RegionalityPage', compact('allBrewers'));
    }
}
