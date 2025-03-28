<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputWebsites extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $get_website_data = Website::where('url', 'LIKE', "%$query%")->get();
        $get_category_data = Category::where('type', 'LIKE', "%$query%")->get();
        $get_business_data = Business::where('name', 'LIKE', "%$query%")->get();
        return response()->json([
            'websites' => $get_website_data,
            'categories' => $get_category_data,
            'businesses' => $get_business_data,
        ]);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'business' => 'required|exists:businesses,name',
            'category' => 'required|exists:categories,type',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors(),
            ], 422);
        }

        $get_business_data = Business::where('name', $data['business'])->get();

        foreach ($get_business_data as $business) {
            $business_id = $business->id;
        }

        $get_category_data = Category::where('type', $data['category'])->get();

        foreach ($get_category_data as $category) {
            $category_id = $category->id;
        }

        if ($request->isMethod('post')) {
            $website = new Website();
            $website->name = $data['name'];
            $website->url = $data['url'];
            $website->business_id = $business_id;
            $website->category_id = $category_id;
            $website->save();
        } elseif ($request->isMethod('put')) {
            $get_website_data = Website::where('name', $data['name'])->get();
            foreach ($get_website_data as $website) {
                $id = $website->id;
            }
            $website = Website::find($id);
            $website->name = $data['name'];
            $website->url = $data['url'];
            $website->business_id = $business_id;
            $website->category_id = $category_id;
            $website->save();
        }
    }
}
