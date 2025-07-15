<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Events\BidPlaced;

class ProductController extends Controller
{
    public function Product($id)
    {
        $data = Category::find($id);
        $item = Product::where('category_id', $id)->get();
        return view('admin.product.addproduct', compact('data', 'item'));
    }

    public function Create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stream_url' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'start_time' => 'required|date',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hours = $request->duration_hours ?? 0;
        $minutes = $request->duration_minutes ?? 0;
        $seconds = $request->duration_seconds ?? 0;

        $duration_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

        if ($duration_seconds <= 0) {
            return back()->withErrors([
                'auction_duration' => 'Auction duration must be greater than zero.'
            ])->withInput();
        }

        $file = $request->file('image');
        $path = $file ? Storage::disk('uploads')->put('Product', $file) : null;

        Product::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stream_url' => $request->stream_url,
            'image' => $path,
            'start_time' => $request->start_time,
            'duration_seconds' => $duration_seconds,
        ]);
        return redirect()->back()->with('success', 'Record created successfully.');
    }

    public function Edit($id)
    {
        $data = Product::find($id);

        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        if (isset($data) && $data->duration_seconds) {
            $hours = floor($data->duration_seconds / 3600);
            $remaining = $data->duration_seconds % 3600;
            $minutes = floor($remaining / 60);
            $seconds = $remaining % 60;
        }
        return view('admin.product.editproduct', compact('data', 'hours', 'minutes', 'seconds'));
    }

    public function Update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stream_url' => 'nullable|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'start_time' => 'required|date',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hours = $request->duration_hours ?? 0;
        $minutes = $request->duration_minutes ?? 0;
        $seconds = $request->duration_seconds ?? 0;

        $duration_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

        if ($duration_seconds <= 0) {
            return back()->withErrors([
                'auction_duration' => 'Auction duration must be greater than zero.'
            ])->withInput();
        }

        $data = Product::find($id);
        $file = $request->file('image');
        if ($file) {
            if ($data->image) {
                Storage::disk('uploads')->delete($data->image);
            }
            $path = Storage::disk('uploads')->put('Product', $request->image);
        } else {
            $path = $data->image;
        }

        $data->Update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stream_url' => $request->stream_url,
            'image' => $path,
            'start_time' => $request->start_time,
            'duration_seconds' => $duration_seconds,
        ]);
        return redirect(route('Product', $data->category_id))->with('success', 'Record updated successfully.');
    }

    public function Delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'product record not found');
        }

        if ($product->image) {
            Storage::disk('uploads')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'product record deleted successfully.');
    }

    public function bid(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Increment price by 0.10
        $product->current_price += 0.10;
        $product->last_bid_user = $request->username;
        $product->save();

        // Broadcast event
        broadcast(new BidPlaced($product))->toOthers();

        return response()->json([
            'success' => true,
            'current_price' => $product->current_price,
            'username' => $product->last_bid_user,
            'product_id' => $product->id
        ]);
    }
}
