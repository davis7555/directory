<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class InputBuildings extends Controller
{
    public function index()
    {
        $business_data = Building::get('name');
        return Inertia::render('Entryform/Buildings', ['business_data' => $business_data]);
    }

    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|max:255',
        ]);

        if ($validatedData->fails()) {
            return to_route('building')->withErrors($validatedData);
        }

        if ($request->isMethod('post')) {
            $building = new Building();
            $building->name = $request->name;
            $building->location = $request->location;
            $building->save();
        } elseif ($request->isMethod('put')) {
            $get_building_data = Building::where('name', $request->name)->get();
            foreach ($get_building_data as $building) {
                $id = $building->id;
            }
            $building = Building::find($id);
            $building->name = $request->name;
            $building->location = $request->location;
            $building->save();
        }
    }
}
