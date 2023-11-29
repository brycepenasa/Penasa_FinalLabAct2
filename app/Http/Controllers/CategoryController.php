<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::all();
        $users = User::all();
        return view("categories",compact("categories","users"));
    }

    public function create()
    {
        return view('addCategory');
    }

    public function edit(Category $category)
    {
        return view('editCategory', compact('category'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the authenticated user's ID
        $user_id = Auth::id();

        // Add the user_id to the validated data
        $validatedData['user_id'] = $user_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            $validatedData['image'] = $imagePath;
        }
        // Create and save the new category
        Category::create($validatedData);

        return redirect()->route('categories')->with('success', 'Category created successfully');
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'category_name.required' => 'The content field is required.',
            'category_name.string' => 'Please enter a valid content.',
            'image.image' => 'Please upload a valid image file.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
    
            // Custom error messages for each rule
            $errorMessage = [];
            foreach ($validator->failed() as $field => $rules) {
                $errorMessage[] = $errors->first($field);
            }
    
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
    
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
    
            $imagePath = $request->file('image')->store('category_images', 'public');
            $data['image'] = $imagePath;
        }
    
        $category->update($data);
    
        return redirect()->route('categories')->with('success', 'Category updated successfully');
    }
        

    public function destroy(Category $category)
    {
        

        $category->delete();

        return redirect()->route('categories')->with('success', 'Category deleted successfully');
    }


    public function restore(Request $request) 
    {
        Category::withTrashed()->where('id', $request['id'])->restore();

        return redirect()->route('categories')->with('success', 'Category restored successfully');
    }

}