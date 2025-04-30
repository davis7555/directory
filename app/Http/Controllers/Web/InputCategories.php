<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class InputCategories extends Controller
{
    public function index()
    {
        $get_type_data = Category::get('type');
        return Inertia::render('Entryform/Category', ['type_data' => $get_type_data]);
    }

    public function create(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'description' => 'max:255',
            'type' => 'required|max:255',
        ]);

        if ($validatedData->fails()) {
            return to_route('category')->withErrors($validatedData);
        }

        if ($request->isMethod('post')) {
            $category = new Category();
            $category->type = $request->type;
            $category->description = $request->description;
            $category->save();
        } elseif ($request->isMethod('put')) {
            $get_category_data = Category::where('type', $request->type)->get();
            foreach ($get_category_data as $category) {
                $id = $category->id;
            }
            $category = Category::find($id);
            $category->type = $request->type;
            $category->description = $request->description;
            $category->save();
        }
        return to_route('category');
    }
}
