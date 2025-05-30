<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class InputBusinesses extends Controller
{
    public function index()
    {
        $business_data = Business::get('name');
        $building_data = Building::get('name');
        $category_data = Category::get('type');
        return Inertia::render('Entryform/Business', [
            'business_data' => $business_data,
            'building_data' => $building_data,
            'category_data' => $category_data,
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'building' => 'required|exists:buildings,name',
            'location' => 'max:255',
            'icon' => 'max:255',
            'email' => 'max:255',
            'phone' => 'regex:/^[0-9]{10}$/',
            'category' => 'required|exists:categories,type',
        ]);

        if ($validatedData->fails()) {
            return to_route('business')->withErrors($validatedData)->withInput();
        }

        $get_building_data = Building::where('name', $request->building)->where('location', $request->location)->get();

        foreach ($get_building_data as $building) {
            $building_id = $building->id;
        }

        $get_category_data = Category::where('type', $request->category)->get();

        foreach ($get_category_data as $category) {
            $category_id = $category->id;
        }

        if ($request->isMethod('post')) {
            $business = new Business();
            $business->name = $request->name;
            $business->building_id = $building_id;
            $business->location = $request->location;
            $business->icon = $request->icon;
            $business->email = $request->email;
            $business->phone = $request->phone;
            $business->category_id = $category_id;
            $business->save();
        } elseif ($request->isMethod('put')) {
            $get_business_data = Business::where('name', $request->name)->where('location', $request->location)->get();
            foreach ($get_business_data as $business) {
                $id = $business->id;
            }
            $business = Business::find($id);
            $business->name = $request->name;
            $business->building_id = $building_id;
            $business->location = $request->location;
            $business->icon = $request->icon;
            $business->email = $request->email;
            $business->phone = $request->phone;
            $business->category_id = $category_id;
            $business->save();
        }
    }
}
