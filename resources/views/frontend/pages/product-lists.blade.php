@extends('frontend.layouts.master')

@section('title','Ghousia || PRODUCT PAGE')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Shop List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
    @php
        if (isset($_GET['childCatId'])){ $req['childCatId']=$_GET['childCatId']; }
        if(isset($_GET['catId'])){ $req['catId']=$_GET['catId']; }
    @endphp
    <div id="offcanvasExample" class="offcanvas-bs4">
        <div class="offcanvas-bs4-header">
            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="offcanvas-bs4-body product-area shop-sidebar shop">
            <div class="shop-sidebar">
                <div class="single-widget category">
                    <h3 class="title">Categories</h3>
                    <ul class="categor-list">
                        @php
                            // $category = new Category();
                            $menu=App\Models\Category::getAllParentWithChild();
                        @endphp
                        @if($menu)
                            <li>
                            @foreach($menu as $cat_info)
                                @if($cat_info->child_cat->count() > 0)
                                    <li>
                                        <a href="{{ route('category', $cat_info->id) }}"
                                           class="d-flex justify-content-between align-items-center">
                                            <div>
                                                {{ $cat_info->title }}
                                            </div>
                                            <div>
                                                <span class="toggle-icon">+</span>
                                            </div>
                                        </a>
                                        <ul class="submenu">
                                            @foreach($cat_info->child_cat as $sub_menu)
                                                <li>
                                                    <a href="{{ route('product-lists', ['childCatId'=>$sub_menu->id]) }}">{{ $sub_menu->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('category', $cat_info->id) }}">{{ $cat_info->title }}</a>
                                    </li>
                                    @endif
                                    @endforeach
                                    </li>
                                @endif
                    </ul>
                </div>
                <!--/ End Single Widget -->
                <!-- Shop By Price -->
                <form action="{{route('product-lists')}}" method="GET">
                    <div class="single-widget range">
                        <h3 class="title">Filter by </h3>
                        <div>
                            <p class="h6 facet-title hidden-sm-down">Categories</p>
                            <ul class="pt-3">
                                @if($menu->count()>0)
                                    @foreach($menu as $cat)
                                        <li class="d-flex justify-content-between align-content-center">
                                            <label class="facet-label active ">
                                                <span class="custom-checkbox">
                                                    <input id="category{{$cat->id}}" name="category[]"
                                                           value="{{$cat->id}}"
                                                           {{isset($_GET['category'])?(in_array($cat->id,$_GET['category'])?'checked':''):''}}
                                                           type="checkbox"/>
                                                </span>
                                                <a href="{{route('category',$cat)}}" rel="nofollow" class="titlecat">
                                                    <span>{{$cat->title}}</span>
                                                </a>
                                            </label>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div>
                            <p class="h6 facet-title hidden-sm-down pt-3">Sizes</p>
                            <ul class="pt-3">
                                <li class="d-flex justify-content-between align-content-center">
                                    <label class="facet-label active ">
                                    <span class="custom-checkbox">
                                        <input id="facet_input" name="size[]" value="S"
                                               {{isset($_GET['size'])?(in_array("S",$_GET['size'])?'checked':''):''}} type="checkbox"/>
                                    </span>
                                        <a href="{{route('product-lists',['size[]'=>'S'])}}" rel="nofollow" class="titlecat">
                                            S
                                        </a>
                                    </label>
                                </li>
                                <li class="d-flex justify-content-between align-content-center">
                                    <label class="facet-label active ">
                                    <span class="custom-checkbox">
                                        <input id="facet_input" name="size[]" value="M"
                                               {{isset($_GET['size'])?(in_array("M",$_GET['size'])?'checked':''):''}} type="checkbox"/>
                                    </span>
                                        <a href="{{route('product-lists',['size[]'=>'M'])}}" rel="nofollow" class="titlecat">
                                            M
                                        </a>
                                    </label>
                                </li>
                                <li class="d-flex justify-content-between align-content-center">
                                    <label class="facet-label active ">
                                    <span class="custom-checkbox">
                                        <input id="facet_input" name="size[]" value="L"
                                               {{isset($_GET['size'])?(in_array("L",$_GET['size'])?'checked':''):''}} type="checkbox"/>
                                    </span>
                                        <a href="{{route('product-lists',['size[]'=>'L'])}}" rel="nofollow" class="titlecat">
                                            L
                                        </a>
                                    </label>
                                </li>
                                <li class="d-flex justify-content-between align-content-center">
                                    <label class="facet-label active ">
                                    <span class="custom-checkbox">
                                        <input id="facet_input" name="size[]" value="XL"
                                               {{isset($_GET['size'])?(in_array("XL",$_GET['size'])?'checked':''):''}} type="checkbox"/>
                                    </span>
                                        <a href="{{route('product-lists',['size[]'=>'XL'])}}" rel="nofollow" class="titlecat">
                                            XL
                                        </a>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        @isset($colors)
                        <div class="color pt-3">

                            <p class="h6 facet-title hidden-sm-down pt-3">Color</p>
                            <ul class="pt-3 d-flex flex-column">
<!--                                <li class="d-flex justify-content-between align-content-center mb-3">
                                    <div class="custom-color colors-red">
                                        <input id="facet_input1" name="color[]" value="red"
                                               {{isset($_GET['color'])?(in_array("red",$_GET['color'])?'checked':''):''}} type="checkbox"/>
                                        <label for="facet_input1">Red</label>
                                    </div>
                                </li>-->

                                @foreach($colors as $color)
                                    <li class="d-flex justify-content-between align-content-center mb-3">
                                        <div class="custom-color colors-{{strtolower($color->name)}}" style="">
                                            <input id="facet_input{{$color->id}}" name="color[]" value="{{strtolower($color->name)}}"
                                                   {{isset($_GET['color'])?(in_array("red",$_GET['color'])?'checked':''):''}} type="checkbox"/>
                                            <label for="facet_input{{$color->id}}" >{{$color->name}}</label>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        @endisset
                        <div class="price-filter">
                            <p class="h6 facet-title hidden-sm-down mb-0">Price</p>
                            <div class="label-input mb-3">
                                <span>Range:</span>
                                <input style="" type="text" id="amount" readonly/>
                                <input type="hidden" name="price_range" id="price_range"
                                       value="@if(!empty($_GET['price_range'])){{$_GET['price_range']}}@endif"/>
                            </div>
                            <div class="price-filter-inner">

                                <div id="slider-range" data-min="0" data-max="{{$max}}"></div>
                                <div class="product_filter">
                                    <button type="submit" class="filter_button">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="offcanvas-overlay"></div>
    <form action="{{route('shop.filter')}}" method="POST">
    @csrf
        @php
            $oldSearch = "";
            if(request()->has('catId')){
                $oldSearch = "catId=".request()->get('catId');
            } else if(request()->has('childCatId')){
                $oldSearch = "childCatId=".request()->get('childCatId');
            }
        @endphp
        <input type="hidden" value="{{$oldSearch}}" name="old_search">
    <!-- Product Style 1 -->
        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12 p-0">
                            <!-- Shop Top -->
                            <div class="shop-top d-lg-flex justify-content-lg-between align-items-lg-center">
                                <div class="d-flex">
                                    <button class="btn btn-primary btntoggle" type="button" id="offcanvasToggle">
                                        <i class="ti-menu"></i>
                                    </button>
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show:</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="8"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='8') selected @endif>
                                                    08
                                                </option>
                                                <option value="16"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='16') selected @endif>
                                                    16
                                                </option>
                                                <option value="24"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='24') selected @endif>
                                                    24
                                                </option>
                                                <option value="32"
                                                        @if(!empty($_GET['show']) && $_GET['show']=='32') selected @endif>
                                                    32
                                                </option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort:</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title"
                                                        @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>
                                                    Name
                                                </option>
                                                <option value="price"
                                                        @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>
                                                    Price
                                                </option>
                                                <option value="category"
                                                        @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>
                                                    Category
                                                </option>
                                                <option value="brand"
                                                        @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>
                                                    Brand
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <ul class="view-mode">
                                    @php
                                        $url    =  "/product-grids";
                                        if(request()->getQueryString() && (request()->getQueryString() != null))
                                            $url    =  "/product-grids?".request()->getQueryString();
                                    @endphp

                                    <li><a href="{{url($url)}}"><i class="fa fa-th-large"></i></a></li>
{{--                                    <li><a href="{{route('product-grids')}}"><i class="fa fa-th-large"></i></a></li>--}}
                                    <li class="active mt-1 ml-1"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <!--/ End Shop Top -->
                        </div>
                    </div>
                    <div class="row">
                    @if(count($products))
                        @foreach($products as $product)
                            {{-- {{$product}} --}}
                            <!-- Start Single List -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="single-product">
                                                <div class="product-img">
                                                    <a href="{{route('product-detail',$product->id)}}">
                                                        @php
                                                            $photos = explode(',', $product->photo);
                                                            $defaultImg = $photos[0];
                                                            $hoverImg = $photos[1] ?? $defaultImg; // Use the default image if no hover image is available
                                                        @endphp
                                                        <img class="default-img" src="{{ $defaultImg }}"
                                                             alt="{{ $product->title }}">
                                                        <img class="hover-img" src="{{ $hoverImg }}"
                                                             alt="{{ $product->title }}">
                                                    </a>
                                                    <div class="button-head">
                                                        <div class="product-action product-action-3 ">
                                                            <a data-toggle="modal" data-target="#{{$product->id}}"
                                                               title="Quick View" href="#">
                                                                <i class=" ti-eye"></i>
                                                                <span>Quick Shop</span>
                                                            </a>
                                                        </div>
                                                        <div class="product-action">
                                                            <a title="Wishlist"
                                                               href="{{route('add-to-wishlist',$product->slug)}}"
                                                               class="wishlist" data-id="{{$product->id}}">
                                                                <i class=" ti-heart "></i>
                                                                <span>Add to Wishlist</span>
                                                            </a>
                                                        </div>
                                                        <div class="product-action-2">
                                                            <a title="Add to Cart"
                                                               href="{{route('add-to-cart',$product->slug)}}">
                                                                Add to Cart
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-6 col-12">
                                            <div class="list-content">
                                                <div class="product-content">
                                                    <div class="product-price">
                                                        @php
                                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                                        @endphp
                                                        <span>Rs{{number_format($after_discount,2)}}</span>
                                                        <del>Rs{{number_format($product->price,2)}}</del>
                                                    </div>
                                                    <h3 class="title">
                                                        <a href="{{route('product-detail',$product->id)}}">{{$product->title}}</a>
                                                    </h3>
                                                </div>
                                                <p class="des pt-2">{!! html_entity_decode($product->summary) !!}</p>
                                                <a href="{{route('add-to-cart',$product->slug)}}" class="btn cart text-white"
                                                   data-id="{{$product->id}}">Buy Now!</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single List -->
                            @endforeach
                        @else
                            <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Product Style 1  -->
    </form>
    <!-- Modal -->
    @if($products)
        @foreach($products as $key=>$product)
            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active owl-carousel owl-theme">
                                            @php
                                                $photo=explode(',',$product->photo);
                                            @endphp
                                            @foreach($photo as $data)
                                                <div class="item">
                                                    <img src="{{$data}}" alt="{{$data}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->title}}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    @php
                                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                    @endphp
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($rate>=$i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{$rate_count}} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock >0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <h3><small>
                                                <del class="text-muted">Rs{{number_format($product->price,2)}}</del>
                                            </small> Rs{{number_format($after_discount,2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                            @if($product->size)
                                            <div class="size">
                                                <h4>Size</h4>
                                                <ul>
                                                    @php
                                                        $sizes=explode(',',$product->size);
                                                    @endphp

                                                    @foreach($sizes as $size)
                                                        <li>
                                                            <div class="dashbaord-rb-wrapper">
                                                                <input type="radio" id="sizeFilter_0{{$loop->iteration}}" name="size" value="{{$size}}" @if($loop->first) checked @endif class="SizeformRadioInputsBtn">
                                                                <label for="sizeFilter_0{{$loop->iteration}}" class="SizeformRadioLabelBtn">
                                                                    <span>{{$size}}</span>
                                                                </label>
                                                            </div>
                                                        </li>
{{--                                                                    <li><a href="#" class="one">{{$size}}</a></li>--}}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                            </div>

                                            <div class="col-lg-6">
                                            <div class="color">

                                            <h4 class="pt-4">
        <span>Color</span>
    </h4>
    @php

        $pcolors = [];

        $product_detail=DB::table('products')->where('id',$product->id)->first();
        //dd($product_detail);
        if(isset($product_detail) && isset($product_detail->color)){
            $colorNames = explode(',', $product_detail->color);
            $pcolors = DB::table('colors')->whereIn('name', $colorNames)->get();
        }

    @endphp
    <ul class="checkout-list-wrapper">
        @if(isset($pcolors))
            @foreach($pcolors as $color)
                <li>
                    <div class="dashbaord-rc-wrapper">
                        <input type="radio" id="dashboardCheckBox_0{{$loop->iteration}}" name="color" value="{{$color->name}}" @if($loop->first) checked @endif class="formRadioInputsBtn">
                        <label for="dashboardCheckBox_0{{$loop->iteration}}" class="formRadioLabelBtn">
                            <div class="dashboardCheckBox-content-wrapper">
                                <div class="dashboardCheckBox_color">
                                    <div class="dashboardCheckBox_color-placeholder">
                                        <span style="background-color:{{$color->val}} !important"><img src="{{asset('frontend/img/check.png')}}"></span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>

    </div>

                                            </div>

                                        </div>





                                        <form action="{{route('single-add-to-cart')}}" method="POST">
                                            @csrf
                                            <div class="quantity"><!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                                    <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                           data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div> <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to Cart</button>
                                                <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </div>
                                        </form>
                                        <div class="default-social"> <!-- ShareThis BEGIN -->
                                            <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection
@push ('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

        .filter_button {
            /* height:20px; */
            text-align: center;
            background: #F7941D;
            padding: 8px 16px;
            margin-top: 10px;
            color: white;
        }

        .offcanvas-bs4 {
            position: fixed;
            top: 0;
            bottom: 0;
            left: -100%;
            padding: 1rem;
            background: white;
            transition: left 0.3s ease-in-out;
            z-index: 1040;
            width: 25%;
            overflow: scroll;
        }

        .offcanvas-bs4-header {
            display: flex;
            justify-content: end;
            align-items: center;
            padding-bottom: 10px;
        }

        .offcanvas-bs4.show {
            left: 0;
        }

        .btntoggle {
            width: 43px !important;
            height: 32px;
            background: transparent;
            border: 1px solid #77777775;
            color: #888;
            border-radius: 0px;
            text-align: center;
            padding: 10px !important;
            display: block;
            margin-right: 10px !important;
        }

        .btntoggle:hover {
            border: 1px solid #F7941D !important;

        }

        .btntoggle:focus {
            box-shadow: none !important;
        }

        .close:focus, .close:hover, .close:focus-visible {
            border: none !important;
            outline: none !important;
        }

        .offcanvas-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1030;
        }

        .offcanvas-overlay.show {
            display: block;
        }

        .offcanvas-bs4::-webkit-scrollbar {
            width: 5px;
        }

        .offcanvas-bs4::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .offcanvas-bs4::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 2px;
        }

        .offcanvas-bs4::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .offcanvas-bs4 {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        .shop .shop-top {
            padding: 20px !important;
        }

        .single-product .product-img{
            height: unset !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
	</script> --}}
    <script>
        $(document).ready(function () {
            /*----------------------------------------------------*/
            /*  Jquery Ui slider js
            /*----------------------------------------------------*/
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;
                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function (event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }
            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
    <script>
        $(document).ready(function () {

            $('.toggle-icon').click(function (event) {
                event.preventDefault();

                $(this).text(function (i, text) {
                    return text === '+' ? '-' : '+';
                });


                $(this).closest('li').find('.submenu').slideToggle();
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#offcanvasToggle').click(function () {
                $('#offcanvasExample').toggleClass('show');
                $('.offcanvas-overlay').toggleClass('show');
            });

            $('.offcanvas-bs4 .close').click(function () {
                $('#offcanvasExample').removeClass('show');
                $('.offcanvas-overlay').removeClass('show');
            });

            // Optional: Close offcanvas when clicking on the overlay
            $('.offcanvas-overlay').click(function () {
                $('#offcanvasExample').removeClass('show');
                $(this).removeClass('show');
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Initialize Owl Carousel
        $('.quickview-slider-active').each(function () {
            $(this).owlCarousel({
                items: 1,
                loop: true,
                dots: true,
                nav: false,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true
            });
        });

        // Reinitialize Owl Carousel when the modal is opened
        $('.modal').on('shown.bs.modal', function (e) {
            $('.quickview-slider-active').trigger('refresh.owl.carousel');
        });
    });
</script>

@endpush
