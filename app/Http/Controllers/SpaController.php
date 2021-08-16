<?php

namespace App\Http\Controllers;

/**
 * Class SpaController
 *
 * @package App\Http\Controllers
 */
class SpaController extends Controller
{
    /**
     * Entry point for Spa Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('spa');
    }
}
