<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class CategoryController extends Controller
{
    // Get all categories
    public function getAllCategories()
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            foreach ($category->albums as $album) {
                $album->songs;
            }
            $category->albums;
        }

        if (REQ::is('api/*'))
            return response()->json([
                'categories' => $categories
            ], 200, [], JSON_NUMERIC_CHECK);

        return view('turaath/audios/all_categories')->with('categories', $categories);
    }

    // Get a single category
    public function getSingleCategory($categoryId)
    {
        $albumSize=0;
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'error' => "Category not found"
            ], 404);
        }
        
        if (REQ::is('api/*'))

            return response()->json([
                'category' => $category
            ], 200);
        return view('turaath/audios/category')->with(['category' => $category]);
    }

    // Post category
    public function postCategory(Request $request)
    {

        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',

        ]);

        // If validator fails
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');

        $category->save();
        if (REQ::is('api/*'))
            return response()->json([
                'category' => $category
            ], 201);
        return back()->with('success', 'Category added successfully');
    }

    // Edit category
    public function putCategory(Request $request, $categoryId)
    {

        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'error' => "Category not found"
            ], 404);
        }

        $category->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $category->save();
        if (REQ::is('api/*'))
            return response()->json([
                'category' => $category
            ], 206);
        return back()->with('success', 'Category edited successfully');
    }

    // Delete category
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'error' => 'Category does not exist'
            ], 204);
        }

        $category->delete();
        if (REQ::is('api/*'))
            return response()->json([
                'category' => 'Category deleted successfully'
            ], 200);
        return back()->with('success', 'Category deleted successfully');
    }
}
