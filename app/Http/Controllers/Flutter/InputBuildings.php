<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Http\Requests\QueryRequest;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputBuildings extends Controller
{
    public function index(Request $request, QueryRequest $validate)
    {
        $validate->validated();
        $query = $request->input('query');
        $get_building_data = Building::where('name', 'LIKE', "%$query%")->get();
        $all_building_data = Building::latest()->get();
        return response()->json([
            'buildings' => $get_building_data,
            'all_buildings' => $all_building_data,
        ]);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|max:255',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors(),
            ], 422);
        }

        if ($request->isMethod('post')) {
            $building = new Building();
            $building->name = $data['name'];
            $building->location = $data['location'];
            $building->save();
        } elseif ($request->isMethod('put')) {
            $get_building_data = Building::where('name', $data['name'])->where('location', $data['location'])->get();
            foreach ($get_building_data as $building) {
                $id = $building->id;
            }
            $building = Building::find($id);
            $building->name = $data['name'];
            $building->location = $data['location'];
            $building->save();
        }
    }
}
