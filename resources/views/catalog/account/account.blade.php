@extends('catalog.common.base')

@push('setTitle')
    Account
@endpush

@section('content')

<section class="container-fluid py-5">
    <div class="row g-4">
        <div class="col-lg-10">
            <div class="row g-4">
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ $route_profile }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-solid fa-user"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">Profile</p>
                            </div>
                        </a>
                    </div>
                </div>
    
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ route('catalog.order') }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-brands fa-jedi-order"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">My Order</p>
                            </div>
                        </a>
                    </div>
                </div>
    
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ route('catalog.wishlist') }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-solid fa-heart"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">Wishlist</p>
                            </div>
                        </a>
                    </div>
                </div>
    
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ $route_cart }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">Cart</p>
                            </div>
                        </a>
                    </div>
                </div>
    
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ $route_address }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-solid fa-address-book"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">Address</p>
                            </div>
                        </a>
                    </div>
                </div>
    
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ $route_change_password }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-solid fa-lock"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">Change Password</p>
                            </div>
                        </a>
                    </div>
                </div>
    
                <div class="col-6 col-sm-2 col-md-4 col-lg-3 ">
                    <div class="card shadow-lg rounded-3" style="background-color: #f8f9fa;">
                        <a href="{{ route('catalog.logout') }}">
                            <div class="card-body text-center">
                                <h2 class="text-secondary" style="font-size: 6rem; margin-bottom: 20px;">
                                    <i class="fa-solid fa-power-off text-danger"></i>
                                </h2>
                                <p class="fs-4 fw-bold text-dark" style="font-family: 'Roboto', sans-serif;">Logout</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            @include('catalog.common.right-navbar')
        </div>

    </div>
</section>

@endsection