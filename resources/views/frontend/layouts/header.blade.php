<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $settings=DB::table('settings')->get();
                            @endphp
                            <li><i class="ti-headphone-alt"></i><a href="tel:03023945180">0302 3945180</a></li>
                            <li><i class="ti-email"></i><a href="mailto: arshadgsh@gmail.com">arshadgsh@gmail.com</a>
                            </li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="marquee">
                        <div class="marquee-content">
                            Dear Customers, Free Shipping on Orders Above PKR.2000 in Pakistan
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                        <!-- <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">Track Order</a></li> -->
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}"
                                                                   target="_blank">Dashboard</a></li>
                                @else
                                    <li><i class="ti-user"></i> <a href="{{route('user')}}"
                                                                   target="_blank">Dashboard</a></li>
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
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-8 col-sm-8 d-flex justify-content-lg-center align-items-center">
                    <!-- Logo -->
                    <div class="logo pb-0 mt-0 ">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach"
                                                         alt="logo" width="100" class="logoimag"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->

                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 d-flex justify-content-end ">
                    <div class="right-bar">
                        <!-- Search Icon -->
                        <div class="search-area">
                            <div class="top-search pr-4">
                                <a href="javascript:void(0);" id="search-icon" class="icon-toggle"><i
                                        class="ti-search single-icon"></i></a>
                            </div>
                            <!-- Search Form -->
                            <div class="search-top" id="search-form" style="display: block;">
                                <div class="search-bar-top">
                                    <div class="search-bar">
                                        <select>
                                            <option>All</option>
                                            @foreach(Helper::getAllCategory() as $cat)
                                                <option>{{$cat->title}}</option>
                                            @endforeach
                                        </select>
                                        <form method="POST" action="{{route('product.search')}}">
                                            @csrf
                                            <input name="search" placeholder="Search Products Here....." type="search">
                                            <button class="btnn" type="submit"><i class="ti-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search Form -->
                        <!-- track order -->
                    {{--                            <div class="truck-icon"><a href="{{route('order.track')}}"><i class="ti-truck single-icon"></i> </a></div>--}}
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
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                                                  alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                       target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span
                                                        class="amount">${{number_format($data->price,2)}}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span
                                                class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                        @endauth
                        <!--/ End Shopping Item -->
                        </div>
                        {{-- <div class="sinlge-bar">
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div> --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span
                                    class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
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
                                                <a href="{{route('cart-delete',$data->id)}}" class="remove"
                                                   title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                                                  alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                       target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span
                                                        class="amount">${{number_format($data->price,2)}}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span
                                                class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                        @endauth
                        <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner  shadow ">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 d-flex justify-content-lg-center align-items-center">
                        <!-- Logo -->
                        <div class="logo pb-0 mt-0" id="sticky-logo">
                            @php
                                $settings=DB::table('settings')->get();
                            @endphp
                            <a href="{{route('home')}}"><img
                                    src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo"
                                    width="120"></a>
                        </div>
                        <!--/ End Logo -->
                        <!-- Search Form -->
                        <!--/ End Search Form -->
                        <div class="mobile-nav"></div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-10 d-flex   align-items-center">
                        <div class="menu-area">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}">
                                                <a href="{{route('home')}}">Home</a>
                                            </li>
                                            @if(isset($top_bar_category) && $top_bar_category->count()>0)
                                                @foreach($top_bar_category as $cat)
                                                    <li>
                                                        <a href="{{route('category',$cat)}}">
                                                            {{$cat->title}}
                                                            <i class="ti-angle-down"></i>
                                                        </a>
                                                        @if(isset($cat->child_cat) && $cat->child_cat->count()>0)
                                                            <ul class="dropdown border-0 shadow">
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
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif">
                                                <a href="{{route('product-grids')}}">Products</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <div class="right-bar" id="sticky-right-bar">
                            <!-- track order -->
                        <!-- <div class="truck-icon"><a href="{{route('order.track')}}"><i class="ti-truck single-icon"></i> </a></div> -->
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
                                                    <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                                                      alt="{{$photo[0]}}"></a>
                                                    <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                           target="_blank">{{$data->product['title']}}</a></h4>
                                                    <p class="quantity">{{$data->quantity}} x - <span
                                                            class="amount">${{number_format($data->price,2)}}</span></p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span
                                                    class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                            </div>
                                            <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                        </div>
                                    </div>
                            @endauth
                            <!--/ End Shopping Item -->
                            </div>
                            {{-- <div class="sinlge-bar">
                                <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            </div> --}}
                            <div class="sinlge-bar shopping">
                                <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span
                                        class="total-count">{{Helper::cartCount()}}</span></a>
                                <!-- Shopping Item -->
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
                                                    <a href="{{route('cart-delete',$data->id)}}" class="remove"
                                                       title="Remove this item"><i class="fa fa-remove"></i></a>
                                                    <a class="cart-img" href="#"><img src="{{$photo[0]}}"
                                                                                      alt="{{$photo[0]}}"></a>
                                                    <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                           target="_blank">{{$data->product['title']}}</a></h4>
                                                    <p class="quantity">{{$data->quantity}} x - <span
                                                            class="amount">${{number_format($data->price,2)}}</span></p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span
                                                    class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                            </div>
                                            <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                        </div>
                                    </div>
                            @endauth
                            <!--/ End Shopping Item -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>

<script>
    document.getElementById('search-icon').addEventListener('click', function () {
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
    window.onscroll = function () {
        var headerInner = document.querySelector('.header-inner');
        var rightBar = document.getElementById('sticky-right-bar');
        var sticky = headerInner.offsetTop;

        if (window.pageYOffset > sticky) {
            headerInner.classList.add("sticky");
            rightBar.style.display = 'block'; // Show the right bar
        } else {
            headerInner.classList.remove("sticky");
            rightBar.style.display = 'none'; // Hide the right bar
        }
    };
</script>

