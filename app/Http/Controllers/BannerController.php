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

        $banner =   Banner::orderBy('id','DESC')->paginate(10);
        return view('backend.banner.index')->with('banners',$banner);

    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function store(Request $request)
    {
        try {

            $this->validate($request,[
                'title'         =>  'string|required|max:50',
                'description'   =>  'string|nullable',
                'photo'         =>  'required|mimes:jpeg,jpg,png',  //'string|nullable',
                'status'        =>  'required|in:active,inactive',
//                'video'         =>  'nullable|file|mimes:mp4,avi,mov,wmv|max:100000',  //'string|nullable',
            ]);

            //$data               =   $request->all();

            $slug               =   Str::slug($request->title);

            $count              =   Banner::where('slug',$slug)->count();

            if($count>0){
                $slug           =   $slug.'-'.date('ymdis').'-'.rand(0,999);
            }

            /*
            $data['title']           =   $request->title;

            $data['slug']           =   $slug;

            if(isset($request->description))
                $data['description']    =   $request->description;
            else
                $data['description']    =   $slug;

            $data['photo']              =   null;
            if ($request->has('photo')) {
                try {
                    $data['photo'] = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
                } catch (\Exception $e) {
                    request()->session()->flash('error','Error in Saving Photo: ' . $e->getMessage());
                    return redirect()->back();
                }
            }

            $status         =   Banner::create($data);
            $lastInsertedId =   $status->id;
            if($status) {

                if ($request->has('video')) {
                    try {

                        $dataVideo = ImageUploadHelper::uploadFile($request->video, 'upload/videos/');
                        // Retrieve the Banner object based on the last inserted ID
                        $banner = Banner::find($lastInsertedId);
                        $banner->video  =   $dataVideo;
                        $banner->save();

                    } catch (\Exception $e) {

                        request()->session()->flash('error','Error in Saving Video: ' . $e->getMessage());

                        return redirect()->back();
                    }
                }

                request()->session()->flash('success','Banner successfully added');
            }
            else
            {
                request()->session()->flash('error','Error occurred while adding banner');
            }

            return redirect()->route('banner.index');

            */

            $banner                 = new Banner;

            $banner->title          = $request->title;
            $banner->slug           = $slug;
            $banner->description    = $request->description;

            if ($request->has('photo')) {
                $dataPhoto = ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');
                $banner->photo = $dataPhoto;
            }

            if ($request->has('video')) {
//                $dataVideo = ImageUploadHelper::uploadFile($request->video, 'upload/videos/');
                $dataVideo      =   $request->video;
                $banner->video  =   $dataVideo;
            }

            $banner->save();

            // Access the last inserted ID using $banner->id
            request()->session()->flash('success','Banner successfully added');
            return redirect()->route('banner.index');

        } catch (\Exception $e) {
            // Handle any exceptions that might occur during the process
            $errorMessage = 'Error: ' . $e->getMessage();
            request()->session()->flash('error', $errorMessage);
            return redirect()->back();
        }

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
        $banner     =   Banner::findOrFail($id);

        //dd($banner);

        $this->validate($request,[
            'title'         =>  'string|required|max:50',
            'description'   =>  'string|nullable',
            'photo'         =>  'sometimes|mimes:jpeg,jpg,png',  //'string|nullable',
            'status'        =>  'required|in:active,inactive',
//            'video'         =>  'nullable|file|mimes:mp4,avi,mov,wmv|max:100000',
        ]);

        $data   =   $request->all();

//        dd($data);
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;

        if ($request->has('photo')) {
            try
            {

                $data['photo']   =   ImageUploadHelper::uploadImage($request->photo, 'upload/photo/');

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


        $status  =  $banner->fill($data)->save();

        if($status) {
//            dd($status);
            if ($request->has('video')) {
                try {
//                    $dataVideo = ImageUploadHelper::uploadFile($request->video, 'upload/videos/');
                    $dataVideo      =   $request->video;
                    $banner->video  =   $dataVideo;
                    $banner->save();

                } catch (\Exception $e) {
                    request()->session()->flash('error','Error in Saving Video: ' . $e->getMessage());
                    return redirect()->back();
                }
            }

            request()->session()->flash('success','Banner successfully updated');
        } else {
            request()->session()->flash('error','Error occurred while updating banner');
        }

        return redirect()->route('banner.index');
    }


    public function destroy($id)
    {

        $banner     =   Banner::findOrFail($id);

        $status     =   $banner->delete();

        if ($status) {
            request()->session()->flash('success','Banner successfully deleted');
        } else {
            request()->session()->flash('error','Error occurred while deleting banner');
        }

        return redirect()->route('banner.index');
    }

}
