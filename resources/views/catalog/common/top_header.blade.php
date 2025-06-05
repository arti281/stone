<style>
    .user-dropdown{
        margin-top: 15px !important;
    }

    /* .user-dropdown::before{
        position: absolute;
        content: ''; 
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        top: -10px;
        left: 116px;
        border-bottom: 10px solid #ddd;
    } */

</style>

<header class="bg-light py-2">
    <div class="container">
        <div class="row">
           <div class="col-12 col-md-12 col-lg-4 col-xl-3 only_desktop_view">
            @if (app('settings') && isset(app('settings')['desktop_logo']))
                <a href="/"><img height="80" width="150" src="{{ URL::asset('image/setting/site') .'/'. app('settings')['desktop_logo'] }}" alt="ez lifestyle"></a>
            @endif
           </div>
           <div class="col-12 col-md-12 col-lg-4 col-xl-6 only_desktop_view">
                @include('catalog.product.search')
           </div>
           <div class="col-12 col-md-12 col-lg-4 col-xl-3">
                <ul class="h-100 d-flex align-items-center mx-3 list-unstyled justify-content-end">
                    <li class="mx-2 only_mobile_view">
                        <button class="btn btn-outline-secondary rounded-circle" id="toggle-search" style="background-color: #ff6666; transition: background-color 0.3s;width:52px;height:52px">
                            <i class="fa fa-search text-white"></i>
                        </button>
                    </li>
                    <li class="mx-2">
                        <a href="{{ route('catalog.wishlist') }}" class="text-decoration-none text-white position-relative">
                            <i class="fa-regular fa-heart p-3 rounded-circle" style="background-color: #ff6666; transition: background-color 0.3s;"></i>
                            <span class="fs-6 fw-bold text-white position-absolute rounded-circle" style="top:-27px; left:50%; background:#ff5722; padding:0px 11px">{{ $getWishlist }}</span>
                        </a>
                    </li>
                    <li class="mx-2">
                        <a href="{{ route('catalog.cart') }}" class="text-decoration-none text-white position-relative">
                            <i class="fa-solid fa-cart-shopping p-3 rounded-circle" style="background-color: #ff6666; transition: background-color 0.3s;"></i>
                            <span class="fs-6 fw-bold text-white position-absolute rounded-circle" style="top:-27px; left:50%; background:#ff5722; padding:0px 11px">{{$getCart}}</span>
                        </a>
                    </li>
                    <li class="dropdown mx-2" style="margin-top: -8px">
                        <a href="#" class="text-decoration-none text-white " data-bs-toggle="dropdown" aria-expanded="false" style="width:52px;height:52px">
                            @if (session('isUser'))
                                <span class="rounded-circle px-3 py-2 fs-4 fw-bold text-uppercase" style="background-color: #ff6666; transition: background-color 0.3s;">{{ substr(session('user_name'), 0, 1) }}</span>
                            @else
                                <i class="fa-solid fa-user p-3 rounded-circle" style="background-color: #ff6666; transition: background-color 0.3s;"></i>
                            @endif

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end user-dropdown" style="z-index: 1500; line-height: 25px;">
                            @if (session('isUser'))
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.front-user-account') }}"><i class="fa-solid fa-dashboard"></i> My Account</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.profile') }}"><i class="fa-solid fa-user"></i> Profile</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.order') }}"><i class="fa-brands fa-jedi-order"></i> My Order</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.cart') }}"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.wishlist') }}"><i class="fa-solid fa-heart"></i> Wishlist</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.address') }}"><i class="fa-solid fa-address-book"></i> Address</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.viewChangePassword') }}"><i class="fa-solid fa-lock"></i> Change Password</a></li>
                                <li class="mb-0"><a class="dropdown-item" href="{{ route('catalog.logout') }}"><i class="fa-solid fa-power-off text-danger"></i> Logout</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('catalog.user-login') }}">Login Account</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Search box for mobile only -->
            <div class="d-flex align-items-center">
                <div class="col-12">
                    <form class="search-form d-none w-100" action="{{ route('catalog.product-all') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control p-2" placeholder="Search.." aria-label="Search.." value="{{ $search ?? '' }}" name="search">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <style>
            .search-form {
                transition: max-height 0.3s ease-in-out;
                overflow: hidden;
                max-height: 0;
            }
            .search-form.active {
                max-height: 100px;
            }
            </style>
            
            <script>
                document.getElementById('toggle-search').addEventListener('click', function() {
                    const searchForm = document.querySelector('.search-form');
                    searchForm.classList.toggle('d-none');
                    searchForm.classList.toggle('active');
                });
            </script>

            <!-- End search box -->

        </div>
    </div>
</header>