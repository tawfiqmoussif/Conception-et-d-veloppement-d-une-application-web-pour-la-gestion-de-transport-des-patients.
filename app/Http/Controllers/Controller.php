<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function brancardier()
    {
        return view('pages.brancardier');
    }
    public function demandeur()
    {
        return view('pages.demandeur');
    }
    public function major()
    {
        return view('pages.major');
    }
    public function coordinateur()
    {
        return view('pages.coordinateur');
    }
    public function admin()
    {
        return view('pages.admin');
    }
    public function not_active()
    {
        return view('pages.not_active');
    }
}
