<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // server-side pagination Laravel
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle multiple file uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('uploads/products', 'public');
            }
            $data['images'] = $images;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'delete_images' => 'nullable|array',
        ]);

        // Handle deletion of existing images
        if ($request->has('delete_images')) {
            $currentImages = $product->images ?? [];
            foreach ($request->delete_images as $imageToDelete) {
                if (in_array($imageToDelete, $currentImages)) {
                    Storage::disk('public')->delete($imageToDelete);
                    $currentImages = array_diff($currentImages, [$imageToDelete]);
                }
            }
            $data['images'] = array_values($currentImages);
        } else {
            // Keep existing images if no deletion requested
            $data['images'] = $product->images ?? [];
        }

        // Handle new file uploads
        if ($request->hasFile('images')) {
            $newImages = $data['images'] ?? [];
            foreach ($request->file('images') as $file) {
                $newImages[] = $file->store('uploads/products', 'public');
            }
            $data['images'] = $newImages;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}