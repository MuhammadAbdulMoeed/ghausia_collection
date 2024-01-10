@extends('frontend.layouts.master')
@section('title','Ghousia|| HOME PAGE')
@section('main-content')
    <!-- Slider Area -->
    @if(count($banners)>0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($banners as $key=>$banner)
                    <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach($banners as $key=>$banner)
                    <div class="carousel-item custom-carousel-item {{(($key==0)? 'active' : '')}}">
                        <img class="first-slide" src="{{asset($banner->photo)}}" alt="First slide">
                        {{--                    <div class="carousel-caption d-none d-md-block text-left">
                                                <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                                                <p class="text-white">{!! html_entity_decode($banner->description) !!}</p>
                                                <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Shop Now
                                                <i class="far fa-arrow-alt-circle-right"></i></i></a>
                                            </div>--}}
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <div class="prev-btn">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </div>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <div class="next-btn">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </div>
            </a>
        </section>
    @endif
    <!--/ End Slider Area -->
    

  

    <!-- Start Small Banner  -->
    <section class="small-banner section">
        <div class="container">
            <div class="row">
                @if(isset($slider_category) && !empty($slider_category))
                    @foreach($slider_category as $category)
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-banner">
                                <a href="{{route('category',[$category->id])}}" class="image-zoom-link">
                                    <img src="{{asset($category->photo?:'storage/photos/1/Category/mini-banner1.jpg')}}"
                                         alt="" class="cat-img">
                                </a>
                                <div class="content">
                                    <h3><a href="{{route('category',[$category->id])}}"
                                           class="mt-0 pb-2 pt-1">{{$category->title}}</a></h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!-- End Small Banner -->

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>New Arrivals</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row product-info">
                        <!-- Start Single Tab -->
                        @if($product_lists)
                            @foreach($product_lists as $key=>$product)
                                <div class="col-lg-3 col-md-6 p-b-35 isotope-item {{$product->cat_id}}">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{route('product-detail',$product)}}">
                                                @php
                                                    $photo=explode(',',$product->photo);
                                                // dd($photo);
                                                @endphp
                                                @foreach($photo as $key=>$pic)
                                                <img class="{{$key==0?'default-img':'hover-img'}}" src="{{$pic}}" alt="{{$photo[0]}}">
                                                @if($key>=1) @break @endif
                                                @endforeach

                                                @if($product->stock<=0)
                                                    <span class="out-of-stock">Sale out</span>
                                                @elseif($product->condition=='new')
                                                    <span class="new">New</span
                                                @elseif($product->condition=='hot')
                                                    <span class="hot">Hot</span>
                                                @else
                                                    <span class="price-dec">{{$product->discount}}% Off</span>
                                                @endif
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action product-action-3 ">
                                                    <a data-toggle="modal" data-target="#{{$product->id}}"
                                                       title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Add to Cart"
                                                       href="{{route('add-to-cart',$product->slug)}}">Add to Cart</a>
                                                </div>
                                                <div class="product-action ">
                                                    <a title="Wishlist"
                                                       href="{{route('add-to-wishlist',$product->slug)}}"><i
                                                            class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3>
                                                <a href="{{route('product-detail',$product)}}">{{$product->title}}</a>
                                            </h3>
                                            <div class="product-price">
                                                @php
                                                    $after_discount=($product->price-($product->price*$product->discount)/100);
                                                @endphp
                                                <span>Rs{{number_format($after_discount,2)}}</span>
                                                <del style="padding-left:4%;">
                                                    Rs{{number_format($product->price,2)}}</del>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <!--/ End Single Tab -->
                    @endif
                    <!--/ End Single Tab -->
                    </div>
                    <div class="d-flex justify-content-center pt-5">
                        <a class="btn btn-lg ws-btn wow fadeInUpBig text-white" href="{{route('product-grids')}}"
                           role="button">View More<i class="far fa-arrow-alt-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Area -->

    <!-- Start Product Area -->
    <div class="product-area section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Item</h2>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                            {{--  @php
                                $categories=DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                                @endphp--}}
                            @if(isset($category_lists) && $category_lists->count()>0)
                                <button class="btn tab-link" data-filter="*">All Products</button>
                                @foreach($category_lists as $key => $cat)
                                    <button class="btn tab-link" data-filter=".{{$cat->id}}">{{$cat->title}}</button>
                                @endforeach
                            @endif
                        </ul> <!--/ End Tab Nav -->
                    </div>
                    <div class="tab-content isotope-grid mt-5" id="myTabContent">
                        <div class="row"> <!-- Start Single Tab -->
                            @if($product_lists)
                                @foreach($product_lists as $key=>$product)
                                    <div class="col-lg-3 col-md-6 p-b-35 isotope-item {{$product->cat_id}}">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product-detail',$product)}}">
                                                    @php
                                                        $photo=explode(',',$product->photo);
                                                    @endphp
                                                    @foreach($photo as $key=>$pic)
                                                <img class="{{$key==0?'default-img':'hover-img'}}" src="{{$pic}}" alt="{{$pic}}">
                                                @if($key>=1) @break @endif
                                                @endforeach

                                                    @if($product->stock<=0)
                                                        <span class="out-of-stock">Sale out</span>
                                                    @elseif($product->condition=='new')
                                                        <span class="new">New</span
                                                    @elseif($product->condition=='hot')
                                                        <span class="hot">Hot</span>
                                                    @else
                                                        <span class="price-dec">{{$product->discount}}% Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action product-action-3 ">
                                                        <a data-toggle="modal" data-target="#{{$product->id}}"
                                                           title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                    </div>
                                                    <div class="product-action">
                                                        <a title="Wishlist"
                                                           href="{{route('add-to-wishlist',$product->slug)}}"><i
                                                                class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to Cart"
                                                           href="{{route('add-to-cart',$product->slug)}}">Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3>
                                                    <a href="{{route('product-detail',$product)}}">{{$product->title}}</a>
                                                </h3>
                                                <div class="product-price">
                                                    @php
                                                        $after_discount=($product->price-($product->price*$product->discount)/100);
                                                    @endphp
                                                    <span>Rs{{number_format($after_discount,2)}}</span>
                                                    <del style="padding-left:4%;">
                                                        Rs{{number_format($product->price,2)}}</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach <!--/ End Single Tab -->
                            @endif
                        </div> <!--/ End Single Tab -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Product Area -->
    <!-- Start Most Popular -->
    <div class="product-area most-popular section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Top Sellings Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                    @foreach($product_lists as $product)
                        @if($product->condition=='hot')
                            <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$product)}}">
                                            @php
                                                $photo=explode(',',$product->photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <img class="hover-img" src="{{$photo[1]}}" alt="{{$photo[1]}}">
                                            {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action product-action-3">
                                                <a data-toggle="modal" data-target="#{{$product->id}}"
                                                   title="Quick View" href="#"><i
                                                        class=" ti-eye"></i><span>Quick Shop</span></a>
                                            </div>
                                            <div class="product-action ">
                                                <a title="Wishlist"
                                                   href="{{route('add-to-wishlist',$product->slug)}}"><i
                                                        class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a href="{{route('add-to-cart',$product->slug)}}">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$product)}}">{{$product->title}}</a>
                                        </h3>
                                        <div class="product-price">
                                            <span class="old">Rs{{number_format($product->price,2)}}</span>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100)
                                            @endphp
                                            <span>Rs{{number_format($after_discount,2)}}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 7 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')

    <!-- Modal -->
    @if($product_lists)
        @foreach($product_lists as $key=>$product)
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
                                        <div class="quickview-slider-active  owl-carousel owl-theme">
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
                                    <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                        @csrf
                                        @if($product->size)
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        @if($product->size)
                                                            <div class="size">
                                                                <h4>Size</h4>
                                                                <ul class="checkout-list-wrapper">
                                                                    @php
                                                                        $sizes=explode(',',$product->size);
                                                                    @endphp
                                                                    @foreach($sizes as $size)
                                                                        <li>
                                                                            <div class="dashbaord-rb-wrapper">
                                                                                <input type="radio" id="size{{$product->title}}_0{{$loop->iteration}}" name="size" value="{{$size}}" @if($loop->first) checked @endif class="SizeformRadioInputsBtn">
                                                                                <label for="size{{$product->title}}_0{{$loop->iteration}}" class="SizeformRadioLabelBtn">
                                                                                    <span>{{$size}}</span>
                                                                                </label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @php
                                                        $pcolors      = [];
                                                        if(isset($product->color)){
                                                            $colors   =  explode(',',$product->color);
                                                            $pcolors  =  DB::table('colors')->whereIn('name', $colors)->get();
                                                        }
                                                    @endphp

                                                    <div class="col-lg-6 col-12">
                                                        @if(isset($pcolors))
                                                        <div class="color pt-3">
                                                            <h4 class="">
                                                                <span>Color</span>
                                                            </h4>
                                                            <ul class="checkout-list-wrapper">
                                                                @foreach($pcolors as $color)
                                                                <li>
                                                                    <div class="dashbaord-rc-wrapper">
                                                                        <input type="radio" id="{{$product->title}}_0{{$loop->iteration}}" name="color" value="{{$color->name}}" @if($loop->first) checked @endif class="formRadioInputsBtn">
                                                                        <label for="{{$product->title}}_0{{$loop->iteration}}" class="formRadioLabelBtn">
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
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="size-chart mt-4 mb-4">
                                            <a href="{{asset('files/1/sizechart.jpg')}}" target="_blank" class="size-chart-btn">
                                                View Size Chart
                                            </a>
                                        </div>

                                            <div class="quantity">
                                                <!-- Input Order -->
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
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to Cart</button>
                                                <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                            <!-- ShareThis BEGIN -->
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

@push('styles')
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
            async='async'></script>
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons'
            async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
            background: #000000;
            color: black;
        }

        /* #Gslider .carousel-inner{
        height: 400px !important;
        } */
        #Gslider .carousel-inner img {
            width: 100% !important;
            opacity: .8;
            object-fit: cover !important;
        }

        #Gslider .carousel-inner .carousel-caption {
            bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 100%;
            color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 70px;
        }


    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');
        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });
        });
        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });
        var isotopeButton = $('.filter-tope-group button');
        $(isotopeButton).each(function () {
            $(this).on('click', function () {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }
                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;
            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
    <script>
        $(document).ready(function () {
            var $grid = $('.tab-content').isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows'
            });
            $('.tab-link').on('click', function () {
                $('.tab-link').removeClass('active');
                $(this).addClass('active');
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({filter: filterValue});
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.tab-link').first().addClass('active');
            $('.tab-link').on('click', function () {
                $('.tab-link').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            $('#Gslider').on('slide.bs.carousel', function () {

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
