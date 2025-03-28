<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Http\Requests\QueryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputCategories extends Controller
{
    public function index(Request $request, QueryRequest $validate)
    {
        $validate->validated();
        $query = $request->input('query');
        $get_category_data = Category::where('type', 'LIKE', "%$query%")->get();
        return response()->json($get_category_data);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validatedData = Validator::make($request->all(), [
            'description' => 'max:255',
            'type' => 'required|max:255',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors(),
            ], 422);
        }

        if ($request->isMethod('post')) {
            $category = new Category();
            $category->type = $data['type'];
            $category->description = $data['description'];
            $category->save();
        } elseif ($request->isMethod('put')) {
            $get_category_data = Category::where('type', $data['type'])->get();
            foreach ($get_category_data as $category) {
                $id = $category->id;
            }
            $category = Category::find($id);
            $category->type = $data['type'];
            $category->description = $data['description'];
            $category->save();
        }
        return response([
            'message' => 'Category created successfully',
        ], 201);
    }
}
