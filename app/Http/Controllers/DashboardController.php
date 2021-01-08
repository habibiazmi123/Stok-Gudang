<?php

namespace App\Http\Controllers;

use TCG\Voyager\Facades\Voyager;

class DashboardController extends \TCG\Voyager\Http\Controllers\VoyagerController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Voyager::view("voyager::dashboard.index");
    }
}
