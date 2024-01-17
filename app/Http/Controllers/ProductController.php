<?php

namespace App\Http\Controllers;

use App\Helper\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::getAllProduct();
        // return $products;
        return view('backend.product.index')->with('products', $products);
    }

    public function create()
    {
        $brand = Brand::get();
        $category = Category::where('is_parent', 1)->get();
        // return $category;
        return view('backend.product.create')->with('categories', $category)->with('brands', $brand);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo.*' => 'required|mimes:jpeg,jpg,png',  //'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'demo_video' => 'nullable',
            'color.*' => 'nullable',
            'product_guide' => 'nullable'
        ]);

        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        $color = $request->input('color');
        if ($color) {
            $data['color'] = implode(',', $color);
        } else {
            $data['color'] = '';
        }
        $data['photo'] = null;
        if ($request->has('photo')) {
            try {
                $photo_strings = '';
                foreach ($request->photo as $photo) {
                    $photo_strings .= ',' . ImageUploadHelper::uploadImage($photo, 'upload/photo/');
                }
                $data['photo'] = ltrim($photo_strings, ',');
            } catch (\Exception $e) {
                request()->session()->flash('error', 'Error in Saving Photo: ' . $e->getMessage());
//                return redirect()->back();
            }
        }
        if ($request->has('demo_video')) {
            $data['demo_video'] = ImageUploadHelper::uploadFile($request->demo_video, 'upload/demo_video/');
        }
        if ($request->has('product_guide')) {
            $data['product_guide'] = ImageUploadHelper::uploadFile($request->product_guide, 'upload/product_guide/');
        }
        // return $size;
        // return $data;
        $status = Product::create($data);
        if ($status) {
            request()->session()->flash('success', 'Product Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();
        // return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)->with('items', $items);
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo.*' => 'required|mimes:jpeg,jpg,png',  //'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'demo_video' => 'nullable',
            'color.*' => 'nullable',
            'product_guide' => 'nullable'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        $color = $request->input('color');
        if ($color) {
            $data['color'] = implode(',', $color);
        } else {
            $data['color'] = '';
        }
        if ($request->has('photo')) {
            try {
                $photo_array = explode(',', $product->photo);
                $key = 0;
                foreach ($request->photo as $photo) {
                    if (isset($photo_array[$key])) {
                        if (file_exists(public_path($photo_array[$key]))) {
                            unlink(public_path($photo_array[$key]));
                        }
                    }
                    $photo_array[$key] = ImageUploadHelper::uploadImage($photo, 'upload/photo/');
                    $key++;
                }
                $data['photo'] = implode(',', $photo_array);
            } catch (\Exception $e) {
                request()->session()->flash('error', 'Error in Saving Photo: ' . $e->getMessage());
//                return redirect()->back();
            }
        }
        if ($request->has('demo_video')) {
            if (isset($product->demo_video)) {
                if (file_exists(public_path($product->demo_video))) {
                    unlink(public_path($product->demo_video));
                }
            }
            $data['demo_video'] = ImageUploadHelper::uploadFile($request->demo_video, 'upload/demo_video/');
        }
        if ($request->has('product_guide')) {
            if (isset($product->product_guide)) {
                if (file_exists(public_path($product->product_guide))) {
                    unlink(public_path($product->product_guide));
                }
            }
            $data['product_guide'] = ImageUploadHelper::uploadFile($request->product_guide, 'upload/product_guide/');
        }

        $data['condition'] = $request->condition;
        $data['stock'] = $request->stock;
        $data['status'] = $request->status;
//        dd($data);
        $status = $product->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Product Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
