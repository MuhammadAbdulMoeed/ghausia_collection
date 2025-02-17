@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{$product_detail->summary}}">
    <meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$product_detail->title}}">
    <meta property="og:image" content="{{$product_detail->photo}}">
    <meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','E-SHOP || PRODUCT DETAIL')
@section('main-content')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Shop Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shop Single -->
    <section class="shop single section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{route('single-add-to-cart')}}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-lg-6 col-12">

                            <div class="single-product-gallery-wrapper">
                                <div class="swiper singleBannerImageSwiper">
                                    <div class="swiper-wrapper">
                                        @php
                                        $photos = explode(',', $product_detail->photo);
                                        @endphp
                                        @foreach($photos as $key => $data)
                                        <div class="swiper-slide" >
                                            <div class="desktop-version d-lg-block d-md-none d-none">
                                                <div class="img-magnifier-container" rel="adjustX:10, adjustY:">
                                                    <img id="magnify-image-{{ $key }}" class="banner-images img-fluid" src="{{ asset($data) }}"
                                                    alt="Image {{ $key }}">
                                                </div>    
                                            </div>
                                            <div class="mobile-version d-lg-none d-md-block d-block">
                                                    <img class="banner-images img-fluid" src="{{ asset($data) }}"
                                                    alt="Image {{ $key }}">
                                            </div>
                                        </div>
                                        @endforeach
                                        @if($product_detail->demo_video)
                                        <div class="swiper-slide">
                                            <video id="player" playsinline controls data-poster="{{ asset('play.png') }}">
                                                <source src="{{asset($product_detail->demo_video)}}" type="video/mp4" />
                                            </video>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="swiper-button-next"><i class="ti-arrow-right"></i></span></div>
                                    <div class="swiper-button-prev"><i class="ti-arrow-left"></i></span></div>
                                </div>
                                <div thumbsSlider="" class="swiper gallerImageSwiper mt-4">
                                    <div class="swiper-wrapper">

                                        @php
                                        $photos = explode(',', $product_detail->photo);
                                        @endphp
                                        @foreach($photos as $key => $data)
                                        <div class="swiper-slide">
                                            <img src="{{ asset($data) }}" alt="Image {{ $key }}">
                                        </div>
                                        @endforeach
                                        @if($product_detail->demo_video)
                                        <div class="swiper-slide">
                                            <img src="{{ asset('play.png') }}" alt="Video">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>




                            <style type="text/css">
                                .singleBannerImageSwiper .banner-images{
                                  height: 550px !important;
                                  object-fit: cover;
                                  width: 100%;
                                  object-position: top;
                                }
                                .singleBannerImageSwiper video{
                                  height: 550px !important;
                                }
                                .singleBannerImageSwiper .swiper-slide{
                                    text-align: center;
                                    background-color: rgba(0, 0, 0, 0.04);
                                }
                                .gallerImageSwiper .swiper-slide img{
                                    height: 100px;
                                    width: 100%;
                                    object-fit: cover;
                                    object-position: top;
                                }
                            </style>

                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="product-des"><!-- Description -->
                                <div class="short">
                                    <div class="d-flex align-items-center ">
                                        <h4>{{$product_detail->title}}</h4>
                                    </div>
                                    <div class="rating-main">
                                        <ul class="rating">
                                            @php
                                                $rate=ceil($product_detail->getReview->avg('rate'))
                                            @endphp
                                            @for($i=1; $i<=5; $i++)
                                                @if($rate>=$i)
                                                    <li><i class="fa fa-star"></i></li>
                                                @else
                                                    <li><i class="fa fa-star-o"></i></li>
                                                @endif
                                            @endfor
                                        </ul>
                                        <a href="#" class="total-review">({{$product_detail['getReview']->count()}})
                                            Review</a>
                                    </div>
                                    @php
                                        $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                    @endphp
                                    <p class="price">
                                        <span class="discount">
                                            Rs{{number_format($after_discount,2)}}
                                        </span>
                                        <s>
                                            Rs{{number_format($product_detail->price,2)}}
                                        </s>
                                    </p>

                                    <div class="description">
                                        {!!($product_detail->summary)!!}
                                    </div>
                                </div><!--/ End Description --><!-- Color -->
                                <div class="color"><!-- <h4>Available Options</h4> -->
                                    <h4 class="">
                                        <span>Color</span>
                                    </h4>
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
                                <!--/ End Color --><!-- Size -->
                                @if($product_detail->size)
                                    <div class="size mt-4">
                                        <h4>Size</h4>
                                        <ul class="checkout-list-wrapper">
                                            @php
                                                $sizes=explode(',',$product_detail->size);
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
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!--/ End Size -->
                                @if($product_detail->product_guide)
                                <div class="size-chart mt-4">
                                    <a href="{{asset($product_detail->product_guide)}}" target="_blank" class="size-chart-btn">
                                        View Size Chart
                                    </a>
                                </div> <!-- Product Buy -->
                                @endif
                                <div class="product-buy">

                                        <div class="quantity">
                                            <h6>Quantity :</h6>
                                            <!-- Input Order -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                                <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                       data-max="1000" value="1" id="quantity">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>  <!--/ End Input Order -->
                                        </div>
                                        <div class="add-to-cart mt-4">
                                            <button type="submit" class="btn">Add to Cart</button>
                                            <a href="{{route('add-to-wishlist',$product_detail->slug)}}"
                                               class="btn min"><i class="ti-heart"></i></a>
                                        </div>

                                    @if(isset($product_detail->cat_info['slug']))
                                    <p class="cat">
                                        Category :
                                        <a href="#"> {{$product_detail->cat_info['title']}}</a>
<!--                                        <a href="{{route('product-cat',$product_detail->cat_info['slug'])}}"> {{$product_detail->cat_info['title']}}</a>-->
                                    </p>
                                    @endif
                                    @if($product_detail->sub_cat_info)
                                        @if(isset($product_detail->cat_info['slug']) && isset($product_detail->sub_cat_info['slug']))
                                        <p class="cat mt-1">Sub Category :
                                            <a href="#">{{$product_detail->sub_cat_info['title']}}</a>
<!--                                            <a href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>-->
                                        </p>
                                        @endif
                                    @endif
                                    <p class="availability">Stock :
                                        @if($product_detail->stock>0)
                                            <span class="badge badge-success">{{$product_detail->stock}}</span>
                                        @else
                                            <span class="badge badge-danger">{{$product_detail->stock}}</span>
                                        @endif
                                    </p>
                                </div>
                                <!--/ End Product Buy -->
                            </div>
                        </div>
                    </div>

                    </form>

                    <div class="row">
                        <div class="col-12">
                            <div class="product-info">
                                <div class="nav-main">
                                    <!-- Tab Nav -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">
                                                Description
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">
                                                Reviews
                                            </a>
                                        </li>
                                    </ul> <!--/ End Tab Nav -->
                                </div>
                                <div class="tab-content" id="myTabContent"> <!-- Description Tab -->
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="tab-single">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="single-des">
                                                        <p>{!! ($product_detail->description) !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Description Tab -->
                                    <!-- Reviews Tab -->
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                                        <div class="tab-single review-panel">
                                            <div class="row">
                                                <div class="col-12"> <!-- Review -->
                                                    <div class="comment-review">
                                                        <div class="add-review">
                                                            <h5>Add A Review</h5>
                                                            <p>Your email address will not be published. Required fields
                                                                are marked</p>
                                                        </div>
                                                        <h4>Your Rating <span class="text-danger">*</span></h4>
                                                        <div class="review-inner">
                                                            <!-- Form -->
                                                            @auth
                                                                <form class="form" method="post"
                                                                      action="{{route('review.store',$product_detail->slug)}}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="rating_box">
                                                                                <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-5"
                                                                                            type="radio" name="rate"
                                                                                            value="5">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-5"
                                                                                            title="5 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-4"
                                                                                            type="radio" name="rate"
                                                                                            value="4">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-4"
                                                                                            title="4 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-3"
                                                                                            type="radio" name="rate"
                                                                                            value="3">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-3"
                                                                                            title="3 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-2"
                                                                                            type="radio" name="rate"
                                                                                            value="2">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-2"
                                                                                            title="2 out of 5 stars"></label>
                                                                                        <input
                                                                                            class="star-rating__input"
                                                                                            id="star-rating-1"
                                                                                            type="radio" name="rate"
                                                                                            value="1">
                                                                                        <label
                                                                                            class="star-rating__ico fa fa-star-o"
                                                                                            for="star-rating-1"
                                                                                            title="1 out of 5 stars"></label>
                                                                                        @error('rate')
                                                                                        <span class="text-danger">
                                                                                            {{$message}}
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group">
                                                                                <label>Write a review</label>
                                                                                <textarea name="review" rows="6"
                                                                                          placeholder=""></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group">
                                                                                <label>Upload Files</label>
                                                                                <input id="thumbnail" class="form-control" type="file" name="files[]" multiple accept="image/*">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group button5">
                                                                                <button type="submit" class="btn">
                                                                                    Submit
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <p class="text-center p-5">
                                                                    You need to
                                                                    <a href="{{route('login.form')}}"
                                                                       style="color:rgb(54, 54, 204)">
                                                                        Login
                                                                    </a>
                                                                    OR
                                                                    <a style="color:blue"
                                                                       href="{{route('register.form')}}">
                                                                        Register
                                                                    </a>
                                                                </p>
                                                                <!--/ End Form -->
                                                            @endauth
                                                        </div>
                                                    </div>

                                                    <div class="ratting-main">
                                                        <div class="avg-ratting">
                                                            {{-- @php
                                                                $rate=0;
                                                                foreach($product_detail->rate as $key=>$rate){
                                                                    $rate +=$rate
                                                                }
                                                            @endphp --}}
                                                            <h4>{{ceil($product_detail->getReview->avg('rate'))}} <span>(Overall)</span>
                                                            </h4>
                                                            <span>Based on {{$product_detail->getReview->count()}} Comments</span>
                                                        </div>
                                                    @foreach($product_detail['getReview'] as $data)
                                                        <!-- Single Rating -->
                                                            <div class="single-rating">
                                                                <div class="rating-author">
                                                                    @if(isset($data->user_info['photo']))
                                                                        <img src="{{$data->user_info['photo']}}"
                                                                             alt="{{$data->user_info['photo']}}">
                                                                    @else
                                                                        <img src="{{asset('backend/img/avatar.png')}}"
                                                                             alt="Profile.jpg">
                                                                    @endif
                                                                </div>
                                                                <div class="rating-des">
                                                                    <h6>{{isset($data->user_info['name'])?$data->user_info['name']:'N/A'}}</h6>
                                                                    <div class="ratings">

                                                                        <ul class="rating">
                                                                            @for($i=1; $i<=5; $i++)
                                                                                @if($data->rate>=$i)
                                                                                    <li><i class="fa fa-star"></i></li>
                                                                                @else
                                                                                    <li><i class="fa fa-star-o"></i>
                                                                                    </li>
                                                                                @endif
                                                                            @endfor
                                                                        </ul>
                                                                        <div class="rate-count">
                                                                            (<span>{{$data->rate}}</span>)
                                                                        </div>
                                                                    </div>
                                                                    <p>{{$data->review}}</p>
                                                                </div>
                                                            </div>
                                                            <!--/ End Single Rating -->
                                                        @endforeach
                                                    </div>
                                                    <!--/ End Review -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ End Reviews Tab -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Shop Single -->

    <!-- Start Most Popular -->
    <div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="top-sellings-slider position-relative">
                        <div class="swiper relatedProductsSlider">
                            <div class="swiper-wrapper">
                                 @foreach($product_detail->rel_prods as $data)
                                @if($data->id !==$product_detail->id)
                                <div class="swiper-slide">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{route('product-detail',$data)}}">
                                                @php
                                                $photo=explode(',',$data->photo);
                                                @endphp
                                                @foreach($photo as $key=>$pic)
                                                <img class="{{$key==0?'default-img':'hover-img'}}" src="{{asset($pic)}}"
                                                alt="{{$pic}}">
                                                @if($key>0)@break @endif
                                                @endforeach
                                                <span class="price-dec">{{$data->discount}} % Off</span>
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action product-action-3">
                                                    <a data-toggle="modal" data-target="#{{$data->id}}"
                                                        title="Quick View" href="#"><i

                                                        class=" ti-eye"></i><span>Quick Shop</span></a>
                                                    </div>
                                                    <div class="product-action ">
                                                        <a title="Wishlist" href="{{route('add-to-wishlist',$data->slug)}}">
                                                    <i class=" ti-heart "></i>
                                                    <span>Add to Wishlist</span>
                                                </a>
                                                    </div>
                                                    <div class="product-action-2">
                                                         <a title="Add to Cart" href="{{route('product-detail',$data->id)}}">Add to Cart </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{route('product-detail',$data)}}">{{$data->title}}</a></h3>
                                        <div class="product-price">
                                            @php
                                                $after_discount=($data->price-(($data->discount*$data->price)/100));
                                            @endphp

                                            <span>Rs{{number_format($data->price,2)}}</span>
                                                    <del style="padding-left:4%;">
                                                        Rs{{number_format($after_discount,2)}}</del>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="swiper-paginations"></div>
                            </div>

                            <div class="swiper-navigation-controller">
                                <div class="swiper-button-next"><span><i class="ti-arrow-right"></i></span></div>
                                <div class="swiper-button-prev"><span><i class="ti-arrow-left"></i></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Most Popular Area -->
    <!-- Modal -->
    @if($product_detail->rel_prods)
        @php //dd($product_detail->rel_prods);@endphp
        @foreach($product_detail->rel_prods as $key=>$product)
            @if($product->id !== $product_detail->id && isset($product->photo))



            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body position-relative">
                            <div class="close-btn-wrapper">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">

                                        <div class="swiper QuickViewSlider">
                                            <div class="swiper-wrapper">
                                                @php
                                                $photo=explode(',',$product->photo);
                                            @endphp
                                            @if(count($photo) > 1)
                                                @foreach($photo as $data)
                                                <div class="swiper-slide">
                                                    <img src="{{asset($data)}}" alt="{{$data}}">
                                                </div>
                                                @endforeach
                                            @elseif(count($photo) == 1 && isset($photo[0]))
                                                <div class="swiper-slide">
                                                    <img src="{{asset($photo[0])}}" alt="{{$photo[0]}}">
                                                </div>
                                            @else
                                                @foreach($photo as $data)
                                                    <div class="swiper-slide">
                                                        <img src="{{asset($data)}}" alt="{{$data}}">
                                                    </div>
                                                @endforeach
                                            @endif
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
                                    <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-3">
                                        @csrf
                                        @if($product->size)
                                            <div class="size mb-0 mt-0">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        @if($product->size)
                                                            <div class="size mb-0 mt-0">
                                                                <h4 class="mb-3">Size</h4>
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
                                                        <div class="color">
                                                            <h4 class="mb-3">
                                                                <span>Color</span>
                                                            </h4>
                                                            <ul class="checkout-list-wrapper">
                                                                @foreach($pcolors as $color)
                                                                <li class="mr-2">
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

                                        <div class="size-chart mt-3 mb-3">
                                            @if(isset($product->product_guide))
                                            <a href="{{asset($product->product_guide)}}" target="_blank" class="size-chart-btn">
                                                View Size Chart
                                            </a>
                                            @endif
                                        </div>

                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group mb-3">
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

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            
            @endif
        @endforeach
    @endif
    <!-- Modal end -->






@endsection
@push('styles')
    <style>
        /* Rating */
        .rating_box {
            display: inline-flex;
        }

        .star-rating {
            font-size: 0;
            padding-left: 10px;
            padding-right: 10px;
        }

        .star-rating__wrap {
            display: inline-block;
            font-size: 1rem;
        }

        .star-rating__wrap:after {
            content: "";
            display: table;
            clear: both;
        }

        .star-rating__ico {
            float: right;
            padding-left: 2px;
            cursor: pointer;
            color: #F7941D;
            font-size: 16px;
            margin-top: 5px;
        }

        .star-rating__ico:last-child {
            padding-left: 0;
        }

        .star-rating__input {
            display: none;
        }

        .star-rating__ico:hover:before,
        .star-rating__ico:hover ~ .star-rating__ico:before,
        .star-rating__input:checked ~ .star-rating__ico:before {
            content: "\F005";
        }

        .img-magnifier-container {
            position: relative;
        }

        .img-magnifier-glass {
            position: absolute;
            border: 3px solid #000;
            border-radius: 50%;
            cursor: none;
            width: 170px;
            height: 170px;
        }

        .flex-viewport {
            height: auto;
            transition: height 0.5s ease;
        }

        .video-height {
            width: 100% !important;
        }

        .modal-slide {
            display: none;
            position: fixed;
            z-index: 99999;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);


        }

        .modal-content-slide {
            padding: 0px;
            width: 40%; /* Adjust width as needed */
            position: absolute;
            left: 50%; /* Center horizontally */
            top: 50%; /* Center vertically */
            transform: translate(-50%, -50%);
        }


        video {
            width: 100% !important
        }


    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            $('#exampleModal').on('shown.bs.modal', function (e) {
                var video   =   $('#demoVideo')[0];
                video.play();
            });
        });
        $(document).ready(function() {
            // When the modal is closed
            $('#exampleModal').on('hidden.bs.modal', function (e) {
                var video = $('#demoVideo')[0];
                video.pause();
                video.currentTime = 0;
            });
        });
    </script>
<!--     <script>
        var modal = document.getElementById("videoPopup");
        var btn = document.getElementById("playButton");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script> -->
    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
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
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        function changeQuantity(action, id) {
            var input = document.getElementById(id);
            var currentValue = parseInt(input.value);

            if (action == 'plus') {
                input.value = currentValue + 1;
            } else if (action == 'minus' && currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>


    <script>
        function magnify(imgID, zoom) {
            var img, glass, w, h, bw;
            img = document.getElementById(imgID);
            glass = document.createElement("DIV");
            glass.setAttribute("class", "img-magnifier-glass");
            img.parentElement.insertBefore(glass, img);

            glass.style.backgroundImage = "url('" + img.src + "')";
            glass.style.backgroundRepeat = "no-repeat";
            glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
            bw = 3;
            w = glass.offsetWidth / 2;
            h = glass.offsetHeight / 2;

            glass.style.display = 'none';


            function showMagnifier() {
                glass.style.display = 'block';
            }

            function hideMagnifier() {
                glass.style.display = 'none';
            }

            img.addEventListener("mouseenter", showMagnifier);
            img.addEventListener("mouseleave", hideMagnifier);
            glass.addEventListener("mouseenter", showMagnifier);
            glass.addEventListener("mouseleave", hideMagnifier);

            glass.addEventListener("mousemove", moveMagnifier);
            img.addEventListener("mousemove", moveMagnifier);

            glass.addEventListener("touchmove", moveMagnifier);
            img.addEventListener("touchmove", moveMagnifier);


            function moveMagnifier(e) {
                var pos, x, y;
                e.preventDefault();
                pos = getCursorPos(e);
                x = pos.x;
                y = pos.y;

                if (x > img.width - (w / zoom)) {
                    x = img.width - (w / zoom);
                }
                if (x < w / zoom) {
                    x = w / zoom;
                }
                if (y > img.height - (h / zoom)) {
                    y = img.height - (h / zoom);
                }
                if (y < h / zoom) {
                    y = h / zoom;
                }
                glass.style.left = (x - w) + "px";
                glass.style.top = (y - h) + "px";
                glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
            }

            function getCursorPos(e) {
                var a, x = 0, y = 0;
                e = e || window.event;
                a = img.getBoundingClientRect();
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {x: x, y: y};
            }
        }

        document.addEventListener("DOMContentLoaded", function () {

            @foreach($photos as $key => $data)
            magnify("magnify-image-{{ $key }}", 1.5);
            @endforeach
        });
    </script>
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script>
  const player = new Plyr('#player');
</script>
<script>
    var swiper = new Swiper(".gallerImageSwiper", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 6,
        freeMode: true,
        watchSlidesProgress: true,
    });

    var swiper2 = new Swiper(".singleBannerImageSwiper", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });


    swiper2.on('slideChange', function () {
        handleVideoOnSlideChange();
    });
    function handleVideoOnSlideChange() {
        var currentSlideNumber = swiper2.realIndex + 1;
        var hasVideoTag = $(".singleBannerImageSwiper .swiper-slide").eq(currentSlideNumber).find('video').length > 0;
        if (!hasVideoTag) {
            var video = $('#player')[0];
            video.pause();
            video.currentTime = 0;
        }
    }
    $(".singleBannerImageSwiper .swiper-button-prev").on("click",function(){
        var video = $('#player')[0];
        video.pause();
        video.currentTime = 0;
    });
</script>


<script>
    var swiper = new Swiper(".QuickViewSlider", {
        loop:true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        slidesPerView:1,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
 


      <script>
        var swiper = new Swiper(".relatedProductsSlider", {
            slidesPerView:1,
            centeredSlides: false,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-paginations",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    // pagination: {
                    //     el: ".swiper-pagination",
                    //     clickable: true,
                    // },
                },
                768: {
                    slidesPerView: 4,
                    // pagination:false
                },
                1024: {
                    slidesPerView: 4,
                    // pagination:false
                },
            },
        });
    </script>

@endpush
