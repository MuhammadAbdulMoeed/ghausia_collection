<?php

namespace App\Http\Controllers;

use App\Helper\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Models\Product;
use Notification;
use App\Notifications\StatusNotification;
use App\User;
use App\Models\ProductReview;
use Illuminate\Support\Str;
class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews=ProductReview::getAllReview();

        return view('backend.review.index')->with('reviews',$reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'rate'=>'required|numeric|min:1',
            'photo.*' => 'nullable|file|mimes:jpeg,jpg,png,pdf,doc|max:10048',  //'string|required',
        ]);

        $product_info       =   Product::getProductBySlug($request->slug);
        //  return $product_info;
        // return $request->all();
        $data               =   $request->all();
        $data['product_id'] =   $product_info->id;
        $data['user_id']    =   $request->user()->id;
        $data['status']     =   'active';
        $status             =   ProductReview::create($data);

        $id                 =   $status->id;
        $data['photo']      =   null;
        if ($request->has('photo')) {
            try {
                $photo_strings = '';
                foreach ($request->photo as $photo) {
//                    $photo_strings .= ',' . ImageUploadHelper::uploadImage($photo, 'upload/review_images/');
                    $photo_strings .= ',' . ImageUploadHelper::uploadFile($photo, 'upload/review_images/');
                }

                $reviewData         =   ProductReview::find($id);
                $data_photo         =   ltrim($photo_strings, ',');
                $reviewData->photo  =   $data_photo;
                $reviewData->save();

            } catch (\Exception $e) {
                request()->session()->flash('error', 'Error in Saving Images: ' . $e->getMessage());
//                return redirect()->back();
            }
        }

//        $status             =   ProductReview::create($data);

        $user               =   User::where('role','admin')->get();

        $details            =   [
            'title'     =>  'New Product Rating!',
            'actionURL' =>   route('product-detail',$product_info->id),
            'fas'       =>  'fa-star'
        ];

        Notification::send($user,new StatusNotification($details));

        if($status) {
            request()->session()->flash('success','Thank you for your feedback');
        } else {
            request()->session()->flash('error','Something went wrong! Please try again!!');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('backend.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            // $product_info=Product::getProductBySlug($request->slug);
            //  return $product_info;
            // return $request->all();
            $data=$request->all();
            $status=$review->fill($data)->update();

            // $user=User::where('role','admin')->get();
            // return $user;
            // $details=[
            //     'title'=>'Update Product Rating!',
            //     'actionURL'=>route('product-detail',$product_info->id),
            //     'fas'=>'fa-star'
            // ];
            // Notification::send($user,new StatusNotification($details));
            if($status){
                request()->session()->flash('success','Review Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('review.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('review.index');
    }
}
