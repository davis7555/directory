<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class InputWebsites extends Controller
{
    public function index()
    {
        $website_data = Website::get('url');
        $category_data = Category::get('type');
        $business_data = Business::get('name');
        return Inertia::render('Entryform/websites', [
            'website_data' => $website_data,
            'category_data' => $category_data,
            'business_data' => $business_data,
        ]);
    }

    public function create(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'url' => 'required|url|max:255',
            'business' => 'required|exists:businesses,name',
            'category' => 'required|exists:categories,type',
        ]);

        if ($validatedData->fails()) {
            return to_route('website')->withErrors($validatedData);
        }

        $get_business_data = Business::where('name', $request->business)->get();

        foreach ($get_business_data as $business) {
            $business_id = $business->id;
        }

        $get_category_data = Category::where('type', $request->category)->get();

        foreach ($get_category_data as $category) {
            $category_id = $category->id;
        }

        if ($request->isMethod('post')) {
            $website = new Website();
            $website->name = $request->name;
            $website->url = $request->url;
            $website->business_id = $business_id;
            $website->category_id = $category_id;
            $website->save();
        } elseif ($request->isMethod('put')) {
            $get_website_data = Website::where('name', $request->name)->get();
            foreach ($get_website_data as $website) {
                $id = $website->id;
            }
            $website = Website::find($id);
            $website->name = $request->name;
            $website->url = $request->url;
            $website->business_id = $business_id;
            $website->category_id = $category_id;
            $website->save();
        }
    }
}
