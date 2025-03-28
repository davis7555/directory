<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Http\Requests\QueryRequest;
use App\Models\Building;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputBusinesses extends Controller
{
    public function index(Request $request, QueryRequest $validate)
    {
        $validate->validated();
        $query = $request->input('query');
        $get_business_data = Business::where('name', 'LIKE', "%$query%")->get();
        $get_building_data = Building::where('name', 'LIKE', "%$query%")->get();
        $get_category_data = Category::where('type', 'LIKE', "%$query%")->get();
        $all_businessess = Business::latest()->get()->groupBy(function ($business) {
            return $business->category->type;
        });
        $business_location = Business::latest()->get()->groupBy('location');
        $alphabet_business = Business::latest()->get()->groupBy(function ($business) {
            return strtoupper(substr($business->name, 0, 1));
        })->sortKeys();
        return response()->json([
            'businesses' => $get_business_data,
            'buildings' => $get_building_data,
            'categories' => $get_category_data,
            'allBusinesses' => $all_businessess,
            'businessLocation' => $business_location,
            'alphabetBusiness' => $alphabet_business,
        ]);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'building' => 'required|exists:buildings,name',
            'location' => 'max:255',
            'icon' => 'max:255',
            'email' => 'email|max:255',
            'phone' => 'regex:/^[0-9]{10}$/',
            'category' => 'required|exists:categories,type',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors(),
            ], 422);
        }

        $get_building_data = Building::where('name', $data['building'])->where('location', $data['location'])->get();

        foreach ($get_building_data as $building) {
            $building_id = $building->id;
        }

        $get_category_data = Category::where('type', $data['category'])->get();

        foreach ($get_category_data as $category) {
            $category_id = $category->id;
        }

        if ($request->isMethod('post')) {
            $business = new Business();
            $business->name = $data['name'];
            $business->building_id = $building_id;
            $business->location = $data['location'];
            $business->icon = $data['icon'];
            $business->email = $data['email'];
            $business->phone = $data['phone'];
            $business->category_id = $category_id;
            $business->save();
        } elseif ($request->isMethod('put')) {
            $get_business_data = Business::where('name', $data['name'])->where('location', $data['location'])->get();
            foreach ($get_business_data as $business) {
                $id = $business->id;
            }
            $business = Business::find($id);
            $business->name = $data['name'];
            $business->building_id = $building_id;
            $business->location = $data['location'];
            $business->icon = $data['icon'];
            $business->email = $data['email'];
            $business->phone = $data['phone'];
            $business->category_id = $category_id;
            $business->save();
        }
    }
}
