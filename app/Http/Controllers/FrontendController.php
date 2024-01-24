<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Brand;
use App\Models\Color;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Newsletter;
use DB;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home()
    {
        $featured = Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();
        // return $banner;
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();
//        $top_bar_category = Category::with('child_cat')->where('status', 'active')->where('is_parent', 1)->where('top_bar',1)->orderBy('title', 'ASC')->get();
        $slider_category = Category::where('status', 'active')->where('is_parent', 1)->where('slider',1)->orderBy('title', 'ASC')->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();
        $hot_products = Product::where('status', 'active')->where('condition','hot')->orderBy('id', 'DESC')->limit(8)->get();
        //dd($hot_products);
//        dd($top_bar_category,$slider_category,$category);
        return view('frontend.index')
            ->with('featured', $featured)
            ->with('posts', $posts)
            ->with('banners', $banners)
            ->with('product_lists', $products)
            ->with('hot_products', $hot_products)
            ->with('category_lists', $category)
//            ->with('top_bar_category', $top_bar_category)
            ->with('slider_category', $slider_category);
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function fqaPage()
    {
        return view('frontend.pages.fqa');
    }

    public function termConditions()
    {
        return view('frontend.pages.term-conditions');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function category(Category $category)
    {
        $subCategory = $category->subCategory();
        if ($subCategory->count() > 0) {
            return view('frontend.pages.catwomen', compact('subCategory'));
        } else {
            return redirect()->route('product-grids', ['catId' => $category->id]);
        }
    }

    public function paymentMethod()
    {
        return view('frontend.pages.payment-method');
    }

    public function shipping()
    {
        return view('frontend.pages.shipping');
    }

    public function privacyPolicy()
    {
        return view('frontend.pages.privacy-policy');
    }

    public function ExchangeRefunds()
    {
        return view('frontend.pages.exhange-refund');
    }

    public function productDetail(Product $product)//$slug
    {
        $pcolors = [];
        // $product_detail = Product::getProductBySlug($slug);
        $product_detail = $product;
        if(isset($product_detail) && isset($product_detail->color)){
            $colorNames = explode(',', $product_detail->color);
            $pcolors = Color::whereIn('name', $colorNames)->get();
        }
        //dd($pcolors);
        return view('frontend.pages.product_detail')->with(compact('product_detail','pcolors'));
    }

    public function productGrids(Request $request)
    {

        if ($request->has('catId')) {
            $type = Product::where('cat_id', $request->catId)->distinct('brand_id')->pluck('brand_id');
        } elseif($request->has('childCatId')) {
            $type = Product::where('child_cat_id', $request->childCatId)->distinct('brand_id')->pluck('brand_id');
        }else{
            $type = Product::distinct('brand_id')->pluck('brand_id');
        }
        $types = Brand::whereIn('id', $type)->get();

        if (!$request->has('type_id')) {
            if ($types->count() > 0) {
                foreach ($types as $type) {
                    if ($type) {
                        if ($request->catId) {
                            $type_count = Product::where('cat_id', $request->catId)->where('brand_id', $type->id)->count();
                        } else {
                            $type_count = Product::where('child_cat_id', $request->childCatId)->where('brand_id', $type->id)->count();
                        }
                        if ($type_count > 0) {
                            $request->type_id = $type->id;
                            break;
                        }
                    }
                }
            }
        }

        if(isset($request->search)){
            $search      = $request->search;

            $products         =   Product::orWhere('title', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('summary', 'like', '%' . $request->search . '%')
                ->orWhere('price', 'like', '%' . $request->search . '%');

        } else {
            $search    = false;
            $products       = Product::query();
        }
//        $products = Product::query();


        if (!empty($_GET['category'])) {
//            $slug = explode(',', $_GET['category']);
//            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            $products = $products->whereIn('cat_id', $_GET['category']);
        }
        if ($request->has('type_id')&&($request->has('catId')||$request->has('childCatId'))) {
            $products = $products->where('brand_id', $request->type_id);
        }
        if ($request->has('size')) {
            $sizes = $request->size;
            $products = $products->where(function($query) use ($sizes) {
                foreach ($sizes as $value) {
                    $query->orWhereRaw("FIND_IN_SET('$value', size) > 0");
                }
            });
        }
        if ($request->has('color')) {
            $colors = $request->color;
            $products = $products->where(function($query) use ($colors) {
                foreach ($colors as $value) {
                    $query->orWhereRaw("FIND_IN_SET('$value', color) > 0");
                }
            });
        }

//        if (!empty($_GET['brand'])) {
//            $slugs = explode(',', $_GET['brand']);
//            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
////            return $brand_ids;
//            $products->whereIn('brand_id', $brand_ids);
//        }

        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }


        if ($request->has('price_range') && $request->price_range!=null) {
            $price = explode('-', $_GET['price_range']);
            $products = $products->whereBetween('price', $price);
        }

        /*if (!empty($_GET['price_range'])) {
            $price = explode('-', $_GET['price_range']);
            $products->whereBetween('price', $price);
        }*/

        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(8);
        }

        $colors = Color::all();

        $max    =   Product::max('price');

        return view('frontend.pages.product-grids', compact('products', 'types','colors','max','search'));
        //return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }

    public function productLists(Request $request)
    {

        if(isset($request->search)) {
            $search      = $request->search;

            $products           =   Product::orWhere('title', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('summary', 'like', '%' . $request->search . '%')
                ->orWhere('price', 'like', '%' . $request->search . '%');

        } else {
            $search    = false;
            $products       = Product::query();
        }

        if (!empty($_GET['category'])) {
            $products = $products->whereIn('cat_id', $_GET['category']);
//            $slug = explode(',', $_GET['category']);
//            // dd($slug);
//            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
//            // dd($cat_ids);
//            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }

//        if (!empty($_GET['brand'])) {
//            $slugs = explode(',', $_GET['brand']);
//            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
//            return $brand_ids;
//            // $products->whereIn('brand_id', $brand_ids);
//        }

        if ($request->has('size')) {
            $sizes = $request->size;
            $products = $products->where(function($query) use ($sizes) {
                foreach ($sizes as $value) {
                    $query->orWhereRaw("FIND_IN_SET('$value', size) > 0");
                }
            });
        }

        if ($request->has('color')) {
            $colors = $request->color;
            $products = $products->where(function($query) use ($colors) {
                foreach ($colors as $value) {
                    $query->orWhereRaw("FIND_IN_SET('$value', color) > 0");
                }
            });
        }

        if (!empty($_GET['sortBy'])) {

            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }

        }

        if (!empty($_GET['price_range'])) {
            $price = explode('-', $_GET['price_range']);
            $products = $products->whereBetween('price', $price);
        }
//        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products   = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products   = $products->where('status', 'active')->paginate(6);
        }

        $colors         = Color::all();

        $max            =  Product::max('price');



        return view('frontend.pages.product-lists', compact('products','colors','max','search'));/*->with('recent_products', $recent_products)*/
    }

    public function productFilter(Request $request)
    {

        $data           = $request->all();

        $oldValue       = "";
        if (!empty($data['old_search'])) {
            $oldValue   .=  $data['old_search'];
        }

        $showURL        = "";
        if (!empty($data['show'])) {
            $showURL    .= '&show=' . $data['show'];
        }
        $sortByURL      = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }
        $catURL         = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $brandURL       = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandURL)) {
                    $brandURL .= '&brand=' . $brand;
                } else {
                    $brandURL .= ',' . $brand;
                }
            }
        }
        // return $brandURL;
        $priceRangeURL          = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL      .= '&price=' . $data['price_range'];
        }

        return redirect()->route('product-lists', $oldValue.$catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);

        /*

        if (request()->is('e-shop.loc/product-grids')) {
            return redirect()->route('product-grids', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        } else {
            return redirect()->route('product-lists', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        }
        */

    }

    public function productGridFilter(Request $request)
    {
        $data = $request->all();
        //dd($data);
        // return $data;
        $oldValue = "";
        if (!empty($data['old_search'])) {
            $oldValue .=  $data['old_search'];
        }
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }
        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $brandURL = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandURL)) {
                    $brandURL .= '&brand=' . $brand;
                } else {
                    $brandURL .= ',' . $brand;
                }
            }
        }
        // return $brandURL;
        $priceRangeURL = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }

        return redirect()->route('product-grids', $oldValue. $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);


    }

    public function productSearch(Request $request)
    {
        //dd($request->all());
        if ($request->has('catId')) {

            $type   =   Product::where('cat_id', $request->category_id)->distinct('brand_id')->pluck('brand_id');

        } elseif ($request->has('childCatId')) {

            $type   =   Product::where('child_cat_id', $request->childCatId)->distinct('brand_id')->pluck('brand_id');

        } else {

            $type   =   Product::distinct('brand_id')->pluck('brand_id');
        }

        $types              =   Brand::whereIn('id', $type)->get();

        $colors             =   Color::all();

        $max                =   Product::max('price');

        //$recent_products    =   Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        $products = Product::query();

        if (!empty($_GET['search'])) {
            $products->orWhere('title', 'like', '%' . $request->search . '%')
                ->orWhere('slug', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('summary', 'like', '%' . $request->search . '%')
                ->orWhere('price', 'like', '%' . $request->search . '%');
        }
        if (!empty($_GET['category_id'])) {
            $products->where('cat_id', $_GET['category_id']);
        }

        $products = $products->where('status', 'active')
            ->orderBy('title', 'ASC')
            ->paginate(8);

        if(isset($request->search)){
            $search  =  $request->search;
        }else{
            $search  = false;
        }

        return view('frontend.pages.product-grids', compact('products', 'types','colors','max','search'));
    }

    public function productBrand(Request $request)
    {

        $products           = Brand::getProductByBrand($request->slug);

        $recent_products    = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }

    }

    public function productCat(Request $request)
    {
        $products           = Category::getProductByCat($request->slug);
        // return $request->slug;
        $recent_products    = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }
    }

    public function productSubCat(Request $request)
    {
        $products           = Category::getProductBySubCat($request->sub_slug);
        // return $products;
        $recent_products    = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        }

    }

    public function blog()
    {
        $post       = Post::query();

        if (!empty($_GET['category'])) {
            $slug   = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }

        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);

    }

    public function blogDetail($slug)
    {

        $post           = Post::getPostBySlug($slug);

        $rcnt_post      = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);

    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post  = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        $posts      = Post::orwhere('title', 'like', '%' . $request->search . '%')
                        ->orwhere('quote', 'like', '%' . $request->search . '%')
                        ->orwhere('summary', 'like', '%' . $request->search . '%')
                        ->orwhere('description', 'like', '%' . $request->search . '%')
                        ->orwhere('slug', 'like', '%' . $request->search . '%')
                        ->orderBy('id', 'DESC')
                        ->paginate(8);

        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }
        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }

    public function loginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully login');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid email and password please try again!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');
        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }

    public function registerSubmit(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:1|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
        Session::put('user', $data['email']);
        if ($check) {
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }

    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request)
    {
        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribePending($request->email);
            if (Newsletter::lastActionSucceeded()) {
                request()->session()->flash('success', 'Subscribed! Please check your email');
                return redirect()->route('home');
            } else {
                Newsletter::getLastError();
                return back()->with('error', 'Something went wrong! please try again');
            }
        } else {
            request()->session()->flash('error', 'Already Subscribed');
            return back();
        }
    }

}
