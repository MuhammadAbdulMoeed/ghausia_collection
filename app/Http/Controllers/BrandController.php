<?php

namespace App\Http\Controllers;

use App\Helper\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::orderBy('id', 'DESC')->paginate();
        return view('backend.brand.index')->with('brands', $brand);
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'photo' => 'required|mimes:jpeg,jpg,png',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        // return $data;
        $data['photo'] = null;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status = Brand::create($data);
        if ($status) {
            request()->session()->flash('success', 'Brand successfully created');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            request()->session()->flash('error', 'Brand not found');
        }
        return view('backend.brand.edit')->with('brand', $brand);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $this->validate($request, [
            'title' => 'string|required',
            'photo' => 'sometimes|mimes:jpeg,jpg,png',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $data['slug'] = $slug;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
                if (isset($brand->photo)) {
                    if (file_exists(public_path($brand->photo))) {
                        unlink(public_path($brand->photo));
                    }
                }
            } catch (\Exception $e) {
                request()->session()->flash('error', 'Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status = $brand->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Brand successfully updated');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $status = $brand->delete();
            if ($status) {
                request()->session()->flash('success', 'Brand successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('brand.index');
        } else {
            request()->session()->flash('error', 'Brand not found');
            return redirect()->back();
        }
    }
}
