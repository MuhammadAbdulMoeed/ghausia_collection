<style>
.offcanvas-menu-wrapper {
    position: fixed;
    top: 0;
    left: -110%;
    width: 300px;
    z-index: 99999999;
    background-color: #fff;
    overflow-y: auto;
    transition: left 0.3s ease-in-out;
    height: 100vh;
}

.offcanvas-menu-wrapper.show {
    left: 0px;
    height: 100vh;


}

.offcanvas-menu {
    width: 250px;
    padding: 20px;
}
.offcanbars{
    margin-top: -15px !important;
}

.menu-button {
    background: transparent !important;
    border: none !important;
    font-size: 20px !important;
    height: 0px;


}

.close-offcanvas {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
}

.offcanvas-menu-wrapper .navbar-nav {


    display: flex !important;
    justify-content: space-between;
    flex-direction: column;
    align-items: start;
    line-height: 60px;
    padding: 5px;


}

.offcanvas-menu-wrapper .nav li a {
    padding: 0px 10px 0px 10px !important;
}
.navmiddle{
    display: flex !important;
    align-items: center !important;
}




</style>
<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                            //$settings=DB::table('settings')->get();
                            @endphp
                            <li><i class="ti-headphone-alt"></i><a href="tel:03023945180">0302 3945180</a></li>
                            <li><i class="ti-email"></i><a href="mailto: customercare@ghausia.com">customercare@ghausia.com</a>
                            </li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="marquee">
                        <div class="marquee-content">
                            Dear Customers, Free Shipping on Orders Above PKR.2000 in Pakistan
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main login-list">
                            <!-- <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">Track Order</a></li> -->
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth
                            @if(Auth::user()->role=='admin')
                            <li><i class="ti-user"></i> <a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                            @else
                            <li><i class="ti-user"></i> <a href="{{route('user')}}" target="_blank">Dashboard</a></li>
                            @endif
                            <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>

                            @else
                            <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a
                                    href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->


    <div class="middle-inner shadow ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-10 col-lg-10 col-md-8 col-sm-8 d-flex justify-content-lg-center align-items-center">

                    <!-- Button to toggle the Off-Canvas Menu (Visible on Mobile Only) -->
                <button class="menu-button d-block d-lg-none mr-3" type="button" onclick="toggleOffcanvas()">
                    <i class="fa fa-bars p-1 mb-1 offcanbars" aria-hidden="true"></i>
                </button>
                    <!-- Logo -->
                    <div class="logo pb-0 mt-0 ">
                        @php
                           // $settings=DB::table('settings')->first();
                        @endphp
                        <a href="{{route('home')}}"><img src="{{asset('upload/logo/logo.png')}}" alt="logo" width="100"
                                class="logoimag"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->

                    <!--/ End Search Form -->
                    <!-- <div class="mobile-nav"></div> -->
                </div>
                <div class="col-2 col-lg-2 col-md-4 col-sm-4 d-flex justify-content-end ">
                    <div class="right-bar">
<!--                         Search Icon  -->
                        <div class="search-area">
                            <div class="top-search pr-4">
                                <!-- <a href="javascript:void(0);" id="search-icon" class="icon-toggle searchSideBarBtn"></a> -->
                                        <button id="searchSideBarBtn" id="search-icon" class="single-icon"><i
                                        class="ti-search single-icon"></i></button>

                            </div>

                           <!--  <div class="search-top" id="search-form" style="display: block;">
                                <div class="search-bar-top">
                                    <div class="search-bar">
                                        <form method="POST" action="{{route('product.search')}}">
                                            <select name="category_id">
                                                <option>All</option>
                                                @foreach(Helper::getAllCategory() as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                @endforeach
                                            </select>

                                            @csrf
                                            <input name="search" placeholder="Search Products Here....." type="search">
                                            <button class="btnn" type="submit"><i class="ti-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                        </div>
{{--                         Search Form--}}
                        <!-- track order -->

                    <!-- track order end -->
                    <div class="sinlge-bar shopping">
                        @php
                        $total_prod=0;
                        $total_amount=0;
                        @endphp
                        @if(session('wishlist'))
                        @foreach(session('wishlist') as $wishlist_items)
                        @php
                        $total_prod+=$wishlist_items['quantity'];
                        $total_amount+=$wishlist_items['amount'];
                        @endphp
                        @endforeach
                        @endif
                        <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span
                                class="total-count">{{Helper::wishlistCount()}}</span></a>
                        <!-- Shopping Item -->
                        @auth
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                <a href="{{route('wishlist')}}">View Wishlist</a>
                            </div>
                            <ul class="shopping-list">
                                {{-- {{Helper::getAllProductFromCart()}} --}}
                                @foreach(Helper::getAllProductFromWishlist() as $data)
                                @php
                                $photo=explode(',',$data->product['photo']);
                                @endphp
                                <li>
                                    <a href="{{route('wishlist-delete',$data->id)}}" class="remove"
                                        title="Remove this item"><i class="fa fa-remove"></i></a>
                                    <a class="cart-img" href="#"><img src="{{asset($photo[0])}}" alt="{{$photo[0]}}"></a>
                                    <h4><a href="{{route('product-detail',$data->product['id'])}}"
                                            target="_blank">{{$data->product['title']}}</a></h4>
                                    <p class="quantity">{{$data->quantity}} x - <span
                                            class="amount">Rs {{number_format($data->price,2)}}</span></p>
                                </li>
                                @endforeach
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span class="total-amount">Rs {{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                </div>
                                <!-- <a href="cartSideBarBtn" class="btn animate">Cart</a> -->
                                <a href="{{route('cart')}}" class="btn animate">Cart</a>
                            </div>
                        </div>
                        @endauth
                        <!--/ End Shopping Item -->
                    </div>

                <div class="sinlge-bar shopping">
                    <button id="cartSideBarBtn" class="single-icon"><i class="ti-bag"></i> <span
                            class="total-count">{{Helper::cartCount()}}</span></button>
                    <!-- Shopping Item -->
                    <!-- @auth
                    <div class="shopping-item">
                        <div class="dropdown-cart-header">
                            <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                            <a href="{{route('cart')}}">View Cart</a>
                        </div>
                        <ul class="shopping-list">
                            {{-- {{Helper::getAllProductFromCart()}} --}}
                            @foreach(Helper::getAllProductFromCart() as $data)
                            @php
                                $photo=explode(',',$data->product['photo']);
                            @endphp
                            <li>
                                <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i
                                        class="fa fa-remove"></i></a>
                                <a class="cart-img" href="#"><img src="{{asset($photo[0])}}" alt="{{$photo[0]}}"></a>
                                <h4><a href="{{route('product-detail',$data->product['id'])}}"
                                        target="_blank">{{$data->product['title']}}</a></h4>
                                <p class="quantity">{{$data->quantity}} x - <span
                                        class="amount">Rs {{number_format($data->price,2)}}</span></p>
                            </li>
                            @endforeach
                        </ul>
                        <div class="bottom">
                            <div class="total">
                                <span>Total</span>
                                <span class="total-amount">Rs {{number_format(Helper::totalCartPrice(),2)}}</span>
                            </div>
                            <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                        </div>
                    </div>
                    @endauth -->
                    <!--/ End Shopping Item -->
                </div>


                <style type="text/css">
                    #sidebarCart,
                    #sidebarSearch {
                        background-color: #F6F7FB;
                    }
                    /*#sidebarSearch{

                    }
                    #sidebarSearch[data-sidebar-main-open="false"] {
                            right: -600px !important;
                    }
                    #sidebarSearch[data-sidebar-main-open="true"] {
                            right: 0px !important;
                            width: 600px !important;
                    }*/
                    #sidebarSearch .sidebar-content-wrapper{
                        padding: 20px;
                        overflow-y: auto;
                        overflow-x: hidden;
                    }
                    .sidebar-wrapper-cart {
                        overflow: hidden;
                        height: 100%;
                    }
                    #cartSideBarBtn{
                        background: transparent;
                        border: none;
                    }
                    #cartSideBarBtn:focus{
                        outline: none;
                    }
                    .sidebar-content-wrapper{
                        height: 100%;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }
                    .single-item-wrapper{
                        flex-grow: 1;
                        overflow-y: auto;
                        padding: 10px;
                    }
                    .sidebar-actionBtn{
                        flex: 0 0 130px;
                    }
                    .dropdown-cart-header{
                        display: flex;
                        justify-content: space-between;
                        padding-bottom: 5px;
                        margin-bottom: 15px;
                        border-bottom: 1px solid #e6e6e6;
                    }
                    .dropdown-cart-header a,
                    .dropdown-cart-header span{
                        font-weight: 600;
                        text-transform: uppercase;
                    }
                    .sidebar-actionBtn{
                        padding: 10px;

                    }
                    .sidebar-actionBtn .bottom .total{
                        display: flex;
                        justify-content: space-between;
                    }
                    .sidebar-actionBtn .bottom .total span{
                        font-weight: 600;
                        text-transform: uppercase;
                        margin-bottom: 10px;
                    }
                    .sidebarClose-header{
                        padding: 0px 10px;
                        background: var(--primaryColor);
                        cursor: pointer;
                    }
                    .sidebarClose-header span{
                        color: #fff;
                    }
                </style>

                <div id="sidebarCart">
                    <div class="sidebar-wrapper-cart">
                        <div class="sidebarClose-header">
                            <span class="quit-sidebarcart d-block w-100"><i class="ti-arrow-left"></i></span>
                        </div>
                        <div class="sidebar-content-wrapper">
                            <div class="single-item-wrapper">
                                @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @foreach(Helper::getAllProductFromCart() as $data)
                                        @php
                                        $photo=explode(',',$data->product['photo']);
                                        @endphp
                                        <li>
                                            <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i
                                                class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{asset($photo[0])}}" alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['id'])}}"
                                                    target="_blank">{{$data->product['title']}}</a></h4>
                                                    <p class="quantity">{{$data->quantity}} x - <span
                                                        class="amount">Rs {{number_format($data->price,2)}}</span></p>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endauth
                                        </div>
                                        <div class="sidebar-actionBtn">
                                            <div class="bottom">
                                                <div class="total">
                                                    <span>Total</span>
                                                    <span class="total-amount">Rs {{number_format(Helper::totalCartPrice(),2)}}</span>
                                                </div>
                                                <a href="{{route('checkout')}}" class="btn animate w-100 d-block text-center">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            <div id="sidebarSearch">
                                <div class="sidebar-wrapper-cart">
                                    <div class="sidebarClose-header">
                                        <span class="quit-sidebSearch d-block w-100"><i class="ti-arrow-left"></i> GO BACK</span>
                                    </div>
                                    <div class="sidebar-content-wrapper">
                                        <div class="search-content-wrapper">
                                            <div class="search-content mb-4">
                                                <label>Search Here</label>
                                            </div>
<!--                                            <form action="">-->
{{--                                                @csrf--}}
                                                <div class="position-relative">
                                                    <input name="search" id="search_id" placeholder="Search Products Here....." type="text">
                                                    <button class="btnn searchButton" onclick="searchProduct()" type="button"><i class="ti-search"></i></button>
                                                </div>
{{--                                            </form>--}}
                                            <!-- Search result Wrapper -->
                                            <div class="searched-product-wrapper mb-5">
                                                <div class="row searcheddProduct" id="searchResults">

<!--                                                <div class="col-lg-6">
                                                        <div class="single-product">
                                                            <div class="product-img">
                                                                <a href="#">
                                                                    <img class="default-img" src="{{asset('upload/photo/1703136637-2754.jpg')}}" alt="">
                                                                    <img class="hover-img" src="{{asset('upload/photo/1703136637-5922.jpg')}}" alt="">
                                                                    <span class="out-of-stock">Hot</span>
                                                                </a>
                                                            </div>
                                                            <div class="product-content">
                                                                <h3><a href="#">Velvat Prodduct</a>
                                                                </h3>
                                                                <div class="product-price">
                                                                    <span>Rs1000.00</span>
                                                                    <del style="padding-left:4%;">
                                                                    Rs2000.00</del>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>


                            <style type="text/css">
                                .searched-product-wrapper{
                                    overflow-y: auto;
                                    overflow-x: hidden;
                                }
                                .searcheddProduct .single-product .product-img a img{
                                    min-height: 350px !important;
                                }
                                .searcheddProduct .single-product .product-img{
                                    height: 350px !important;
                                }
                                .search-content-wrapper label{
                                    text-transform: uppercase;
                                    font-weight: 600;
                                    color: #000;
                                    font-size: 20px;
                                }
                                .search-content-wrapper select{
                                    width: 100% !important;
                                }
                                .search-content-wrapper .nice-select{
                                    display: block !important;
                                    width: 100% !important;
                                    background: var(--primaryColor) !important;
                                    float: unset !important;
                                    font-weight: 600 !important;
                                    color: #fff;
                                }
                                .search-content-wrapper input{
                                    width: 100% !important;
                                    border: none;
                                    padding: 10px;
                                    color: #000;
                                    font-weight: 600;
                                    background: rgba(0, 0, 0, 0.07);;
                                }
                                .search-content-wrapper input::placeholder{
                                    color: rgba(0, 0, 0, 0.2);
                                }
                                .search-content-wrapper .nice-select:after{
                                    border-bottom: 2px solid #fff !important;
                                    border-right: 2px solid #fff !important;
                                }
                                 .search-content-wrapper .nice-select .list{
                                    width: 100% !important;
                                    font-weight: 600;
                                    color: #000;
                                    margin-top: 0px;
                                 }
                                 .search-content-wrapper .nice-select .list li{
                                    font-weight: 600 !important;
                                    color: #000 !important;
                                 }
                                 .search-content-wrapper .nice-select .list li:hover{
                                    background: var(--primaryColor) !important;
                                    color: #fff !important;
                                 }
                                 .search-content-wrapper button{
                                    display: flex;
                                    width: 50px;
                                    padding: 11px;
                                    background: #000;
                                    color: #fff;
                                    font-weight: 600;
                                    font-size: 20px;
                                    transition: all 0.3s ease-in-out;
                                    justify-content: center;
                                    position: absolute;
                                    top: 0;
                                    right: 0;
                                }
                                .search-content-wrapper button:hover{
                                    background-color: var(--primaryColor) !important;
                                }
                            </style>









                <!-- Offcanvas Menu for Mobile -->
                <div class="offcanvas-menu-wrapper" id="offcanvasMenu">
                    <div class="offcanvas-menu">
                        <!-- Close Button -->
                        <span class="close-offcanvas" onclick="toggleOffcanvas()">&times;</span>
                        <!-- Navigation Menu -->
                        <nav class="navbar">
                            <ul class="nav main-menu menu navbar-nav">
                                <li class="{{ Request::path() == 'home' ? 'active' : '' }}">
                                    <a href="{{ route('home') }}" class="mt-3">Home</a>
                                </li>
                                <li class="{{ Request::path() == 'about' ? 'active' : '' }}">
                                    <a href="{{route('about-us')}}">About Us-{{Request::path()}}</a>
                                </li>

                                @php
                                $top_bar_category=App\Models\Category::with('child_cat')->where('status',
                                'active')->where('is_parent', 1)->where('top_bar',1)->orderBy('title', 'ASC')->get();
                                @endphp

                                @foreach($top_bar_category as $cat)
                                <li >
                                <a href="javascript:void(0);"
                                    onclick="toggleSubmenu('submenu-{{ $cat->id }}', '{{ route('category', $cat) }}')">
                                    {{ $cat->title }}
                                    @if($cat->child_cat->count() > 0)
                                    <i class="ti-angle-down"></i>
                                    @endif
                                </a>

                                </li>


                                @if($cat->child_cat->count() > 0)
                                <ul class="dropdown border-0 shadow" id="submenu-{{ $cat->id }}" style="display: none;">
                                    @foreach($cat->child_cat as $child_cat)
                                    <li>
                                        <a href="{{ route('product-grids', ['childCatId' => $child_cat->id]) }}">
                                            {{ $child_cat->title }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                                </li>
                                @endforeach

                                <li class="{{ Request::path() == 'products' ? 'active' : '' }}">
                                    <a href="{{ route('product-grids') }}">Products</a>
                                </li>
                                <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a href="{{route('contact')}}">Contact Us</a></li>
                                <li>
                                <ul class="login-offconvas">

                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth
                            @if(Auth::user()->role=='admin')
                            <li class="d-flex align-items-center p-0 signupbtn justify-content-center"><a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                            @else
                            <li class="d-flex align-items-center p-0 signupbtn justify-content-center"><a href="{{route('user')}}" target="_blank">Dashboard</a></li>
                            @endif
                            <li class="d-flex align-items-center p-0 signupbtn justify-content-center"><a href="{{route('user.logout')}}">Logout</a></li>
                            @else
                            <li class="d-flex align-items-center p-0 signupbtn justify-content-center"><a href="{{route('login.form')}}">Login</a></li>
                            @endauth


                        </ul>
                        <li class="border-0 d-flex align-items-center p-0 signupbtn justify-content-center login-offconvas" >
                            <a class="p-0" href="{{route('register.form')}}">Register</a>
                            </li>

                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
{{--</div>--}}
    <!-- Header Inner -->
    <div class="header-inner  shadow ">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <!-- <div class="col-lg-2 col-md-2 col-sm-2 d-flex justify-content-lg-center align-items-center">

                        <div class="logo pb-0 mt-0" id="sticky-logo">
                            @php
                           // $settings=DB::table('settings')->first();

                            @endphp
                            <a href="{{route('home')}}"><img src="{{asset('upload/logo/logo.png')}}" alt="logohello" width="120"></a>
                        </div>

                        <div class="mobile-nav"></div>
                    </div> -->

                    <div
                        class="col-lg-12 col-md-12 col-sm-12 col-10 d-flex  align-items-center justify-content-lg-center justify-content-md-center d-lg-block d-md-none navmiddle">
                        <div class="menu-area">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}">
                                                <a href="{{route('home')}}">Home</a>
                                            </li>
                                            <li><a href="{{route('about-us')}}">About Us</a></li>
                                            @php
                                            $top_bar_category=App\Models\Category::with('child_cat')->where('status',
                                            'active')->where('is_parent', 1)->where('top_bar',1)->orderBy('title',
                                            'ASC')->get();
                                            @endphp
                                            @if(isset($top_bar_category) && $top_bar_category->count()>0)
                                            @foreach($top_bar_category as $cat)
                                            <li>
                                                <a href="{{route('category',$cat)}}">
                                                    {{$cat->title}}
                                                    @if($cat->child_cat->count() > 0)
                                                        <i class="ti-angle-down"></i>
                                                    @endif
                                                </a>
                                                @if(isset($cat->child_cat) && $cat->child_cat->count()>0)
                                                <ul class="dropdown border-0 shadow InnerMenu">
                                                    @foreach($cat->child_cat as $child_cat)
                                                    <li>
                                                        <a href="{{route('product-grids',['childCatId'=>$child_cat->id])}}">{{$child_cat->title}}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                            @endif
                                            <li class="">
                                                <a href="{{route('product-grids')}}">Products</a>
                                            </li>
                                            <li><a href="{{route('contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>

<div class="soical-offcanvas">

    <div id="shareIcon" class="share-icon shadow-lg">
        <i class="ti-sharethis"></i>
    </div>
    <div id="offCanvas" class="off-canvas">
    <span id="closeOffCanvas" class="close-offcanvas text-center">&times;</span>
    <div class="soical-icons">
    <a href="https://www.facebook.com/" target="_blank"><i class="ti-facebook"></i></a>
        <a href="https://www.twitter.com/" target="_blank"><i class="ti-twitter"></i></a>
        <a href="https://www.instagram.com/" target="_blank"><i class="ti-instagram"></i></a>
        <a href="https://www.youtube.com/" target="_blank"><i class="ti-youtube"></i></a>
    </div>


    </div>


    </div>

<script>
document.getElementById('search-icon').addEventListener('click', function() {
    var searchForm = document.getElementById('search-form');
    var icon = this.getElementsByTagName('i')[0];

    if (searchForm.classList.contains('visible')) {
        searchForm.classList.remove('visible');
        icon.classList.remove('ti-close');
        icon.classList.add('ti-search');
    } else {
        searchForm.classList.add('visible');
        icon.classList.remove('ti-search');
        icon.classList.add('ti-close');
    }
});
</script>
<script>
function toggleOffcanvas() {
    var offcanvasMenu = document.getElementById('offcanvasMenu');
    offcanvasMenu.classList.toggle('show');
}

function toggleSubmenu(submenuId) {
    var submenu = document.getElementById(submenuId);
    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
}
</script>


<script>
function toggleSubmenu(submenuId, parentUrl) {
    var submenu = document.getElementById(submenuId);
    if (submenu) {
        // If submenu exists, toggle its visibility
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
    } else {
        // If submenu doesn't exist, redirect to the parent category URL
        window.location.href = parentUrl;
    }
}
</script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    var shareIcon = document.getElementById('shareIcon');
    var offCanvas = document.getElementById('offCanvas');
    var closeOffCanvas = document.getElementById('closeOffCanvas'); // Get the close button

    shareIcon.addEventListener('click', function() {
        offCanvas.classList.add('active');
    });

    closeOffCanvas.addEventListener('click', function() {
        offCanvas.classList.remove('active');
    });
});
    </script>



