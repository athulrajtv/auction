<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function Category()
    {
        $data = Category::all();
        return view('admin.category.addcategory', compact('data'));
    }

    public function Create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Category::create([
            'category' => $request->category,
        ]);
        return redirect()->back()->with('success', 'Record created successfully.');
    }

    public function Edit(Request $request, $id)
    {
        $data = Category::find($id);
        return view('admin.category.editcategory', compact('data'));
    }

    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Category::find($id);

        $data->Update([
            'category' => $request->category,
        ]);
        return redirect(route('Category'))->with('success', ' updated successfully.');
    }

    public function Delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Record not found');
        }

        $product = Product::where('category_id', $id)->get();
        foreach ($product as $products) {
            if ($products->image) {
                Storage::disk('uploads')->delete($products->image);
            }
            $products->delete();
        }

        $category->delete();

        return redirect()->back()->with('success', 'Record deleted successfully.');
    }
}
