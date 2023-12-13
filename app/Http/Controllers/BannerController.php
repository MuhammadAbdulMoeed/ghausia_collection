<?php

namespace App\Http\Controllers;

use App\Helper\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
class BannerController extends Controller
{

    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->paginate(10);
        return view('backend.banner.index')->with('banners',$banner);
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo' => 'required|mimes:jpeg,jpg,png',  //'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['photo'] = null;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status=Banner::create($data);
        if($status){
            request()->session()->flash('success','Banner successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('banner.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $banner=Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner',$banner);
    }

    public function update(Request $request, $id)
    {
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo' => 'sometimes|mimes:jpeg,jpg,png',  //'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        if ($request->has('photo')) {
            try {
                $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
                if (isset($banner->photo)) {
                    if (file_exists(public_path($banner->photo))) {
                        unlink(public_path($banner->photo));
                    }
                }
            } catch (\Exception $e) {
                request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('banner.index');
    }

    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
