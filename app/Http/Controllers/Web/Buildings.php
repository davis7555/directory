<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Buildings extends Controller
{
    public function index()
    {
        $building_data = Building::get();
        return Inertia::render('Entryform/Buildinglist', ['building_data' => $building_data]);
    }
}
