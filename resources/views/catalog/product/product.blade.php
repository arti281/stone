@extends('catalog.common.base')

<!-- meta tags -->
@push('setTitle'){{ $product['product']?->product_name }} @if (app('settings') && isset(app('settings')['site_title']))| {{ app('settings')['site_title'] }}@endif @endpush
@push('setDescription'){{ $product['product']?->meta_description }}@endpush
@push('setKeyword'){{ $product['product']?->tag }}@endpush
@push('setCanonicalURL'){{ route('catalog.product-detail', ['product_id' => $product['product']->id, 'slug' => $product['product']?->slug]) }}@endpush

@push('addStyle')
    <style>
        .color-selected {
            background-color: #000;
            color: #fff !important;
        }
        .size-selected {
            background-color: #000;
            color: #fff !important;
        }
        
    .star-rating .fa-star { cursor: pointer; color: #ccc; }
    .star-rating .fa-star.checked { color: #ffc107; }

    </style>
@endpush

@section('content')
@if (null !== $product)
<section class="container-fluid py-3">
   <div class="container">

        <div class="row">
            <div class="col-12 col-sm-6 mb-3">
                <div class="product overflow-hidden border bg-white d-flex justify-content-center align-items-center">
                    <img class="mb-3 product_image h-100" src="{{ ($product['product']->image) ? asset("image/products").'/'.$product['product']->id .'/'. $product['product']->image : asset('not-image-available.png')}}" style="max-height: 550px">
                </div>
                <div class="d-flex flex-wrap">
                    @if ($product['images'])
                        <div class="text-center pe-2">
                            <img class="product_side_image border p-1" data-id="1" width="70" height="70" src="{{ asset("image/products").'/'.$product['product']->id .'/'. $product['product']->image }}" data-src="{{ asset("image/products").'/'. $product['product']->id .'/'. $product['product']->image }}">
                        </div>
                        @foreach ($product['images'] as $image)
                        <div class="text-center pe-2">
                            <img class="product_side_image border p-1" data-id="1" height="70" src="{{ asset("image/cache/products").'/'.($product['product']->id .'/'. str_replace(".jpg",'',$image->image) .'_100x100.jpg') }}" data-src="{{ asset("image/products").'/'. $product['product']->id .'/'. $image->image  }}">
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Alert message -->
                @include('catalog.common.ajax_alert')

                <div class="header">
                    <h2 style="font-family: 'Arial', sans-serif;">{{ $product['product']?->product_name }}</h2>
                    <div class="d-flex mt-4">
                        @if ($product['product']->stock_status == 'In Stock')
                            <h5 class="me-3"><strong>Rs. </strong>{{ number_format($product['product']->price,0) }}</h5>
                            <h5 class="text-danger"><strong>Rs. </strong><del>{{ number_format($product['product']->mrp,0) }}</del></h5>
                        @else
                            <p class="text-warning fw-bold">{{ $product['product']->stock_status }}</p>
                        @endif
                    </div>
                    {{-- <p>Inclusive of all Taxes</p> --}}
                    <hr>
                </div>
                
                <!-- <div class="mb-4">
                    <h2 class="fs-6">Colors</h2>
                    <div class="d-flex" style="column-gap: 15px">
                        @foreach ($colors as $color)
                            <span class="text-center p-2 colors" data-color-id="{{ $color->id }}" style="cursor:pointer;border:2px solid {{ $color->code }}">{{ $color->color_name }}</span>   
                        @endforeach
                    </div>
                </div> -->
                    
                <!-- <div class="mb-4">
                    <h2 class="fs-6">Size</h2>
                    <div class="d-flex align-items-center" style="column-gap: 15px">
                        @foreach ($sizes as $size)
                            <span class="border text-center py-2 sizes" data-size-id="{{ $size->id }}" style="width:50px;cursor:pointer;">{{ $size->size_name }}</span>
                        @endforeach
                    </div>
                </div> -->
                <div class="mb-4">
                    <h2 class="fs-6">Quantity</h2>
                    <div class="d-flex" style="column-gap: 15px">
                        <button class="border py-2" style="width: 50px;" onclick="decreaseQunatity()"><i class="fa-solid fa-minus"></i></button>
                        <input class="border py-2 text-center mt-0" style="width: 50px;" readonly type="text" name="quantity" value="@if ($updated_qty) {{$updated_qty->quantity}} @else {{1}} @endif" id="quantity">
                        <button class="border py-2" style="width: 50px;" onclick="increaseQunatity()"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="mb-4">
                    <h2 class="fs-6"><i class="fa-solid fa-truck-moving"></i> Check delivery at your location</h2>
                    <div class="d-flex" style="column-gap: 15px">
                        <input class="w-50 rounded-0 border border-dark px-2 py-2" type="text" name="" id="" placeholder="Enter your pincode">
                        <button class="btn btn-dark rounded-0 py-2">CHECK</button>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex" style="column-gap: 15px">
                        <button class="btn btn-white rounded-0 border border-dark py-2" style="width:35%" type="button" id="addToCart">ADD TO CART</button>
                        <button class="btn btn-dark rounded-0 border border-dark py-2" style="width:35%" type="submit">BUY IT NOW</button>
                    </div>
                    <div class="mt-3">
                        <span id="addWishlist" class="text-dark" style="cursor: pointer"><i class="fa-regular fa-heart"></i> ADD TO WISHLIST</span>
                    </div>
                </div> 

                {{-- Other link url --}}
                @if(app('settings')['ecommerce_other_url_status'])
                    @if($ecommerce_url && $ecommerce_url->status)
                        <h2 class="custom-title text-center mb-3">Click To Buy</h2>
                        <p class="text-center text-danger"><i class="fa-solid fa-angles-down"></i></p>
                        @if($ecommerce_url->amazon)
                            <div class="mb-4">
                                <a target="blank" href="{{ $ecommerce_url->amazon }}" class="text-decoration-none">
                                    <div class="custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><img height="30" src="{{ URL::asset('icon/amazon.png') }}" alt="Amazon"></i></p>
                                                <p class="mb-0">Amazon</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if($ecommerce_url->flipkart)
                            <div class="mb-4">
                                <a href="{{ $ecommerce_url->flipkart }}" target="blank" class="text-decoration-none">
                                    <div class="custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><img src="{{ URL::asset('icon/flipkart.png') }}" width="30" height="30" alt="Flpkart"></p>
                                                <p class="mb-0">Flpkart</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if($ecommerce_url->ajio)
                            <div class="mb-4">
                                <a href="{{ $ecommerce_url->ajio }}" target="blank" class="text-decoration-none">
                                    <div class="custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><img height="30" src="{{ URL::asset('icon/ajio.png') }}" alt="Ajio"></p>
                                                <p class="mb-0">Ajio</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if($ecommerce_url->myntra)
                            <div class="mb-4">
                                <a href="{{ $ecommerce_url->myntra }}" target="blank" class="text-decoration-none">
                                    <div class="custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><img width="30" src="{{ URL::asset('icon/myntra.png') }}" alt="Myntra"></p>
                                                <p class="mb-0">Myntra</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if($ecommerce_url->meesho)
                            <div class="mb-4">
                                <a href="{{ $ecommerce_url->meesho }}" target="blank" class="text-decoration-none">
                                    <div class="custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><img height="30" src="{{ URL::asset('icon/meesho.png') }}" alt="Meesho"></p>
                                                <p class="mb-0">Meesho</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endif
                @endif
                <!-- related products----------->
                @if($relatedProducts->isNotEmpty());
                    <h3>Related Products</h3>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                            <div class="border p-2">
                                <a href="{{ route('catalog.product-detail', [$related->product->id, $related->product->slug]) }}">
                                    <img src="{{ asset('storage/' . $related->product->image) }}" alt="{{ $related->product->product_name }}">
                                    <p>{{ $related->product->product_name }}</p>
                                    <p>₹{{ $related->product->price }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
                <!---------end related products------------>
            </div>
        </div>
        <div class="card rounded-0 p-3 mb-3">
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
                </li>
                <li class="nav-item" role="presentation"> <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">Review</button></li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Description -->
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <div>
                        {!! $product['product']->product_description !!}
                    </div>
                </div>

                <!-- Review -->
                <div class="tab-pane fade show" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <!-- review----->
                <form action="{{ route('catalog.reviews') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['product']->id }}">
                    
                    <br>
                    <div class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star" data-index="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" placeholder="rating" id="rating" name="rating">

                    <textarea name="review" rows="4" class="form-control" required></textarea>
                    
                    <button type="submit" class="btn btn-primary mt-2">Submit Review</button>   
                </form>
    
                    {{-- Loop through reviews --}}
                    @foreach ($reviews as $review)
                        <div class="mt-3 mb-4 pb-3 border-bottom">
                            <div>
                                <span class="ps-2">Rating:</span>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : '' }}"></i>
                                @endfor
                            </div>

                            <div class="p-2">
                                <strong>Review:</strong> {{ $review->review }}
                            </div>

                            @if ($review->replies && $review->replies->count())
                                <div class="ms-4">
                                    @foreach ($review->replies as $reply)
                                        <div class="mb-1 text-muted">
                                            <strong>{{ $reply->name }}:</strong> {{ $reply->reply }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="toggleReplyForm({{ $review->id }})">
                                Reply
                            </button>

                            <form id="reply-form-{{ $review->id }}" class="d-none mt-2 ms-4" method="POST" action="{{ route('catalog.review-replies') }}">
                                @csrf
                                <input type="hidden" name="review_id" value="{{ $review->id }}">
                                <input type="text" name="name" class="form-control mb-2" required placeholder="Your Name">
                                <textarea name="reply" rows="3" class="form-control" required placeholder="Your Reply"></textarea>
                                <button type="submit" class="btn btn-dark mt-2">Submit Reply</button>
                            </form>
                        </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>

                </div>
            </div>
        </div>
   </div>
</section>

<script>
    // reviews
    function toggleReplyForm(id) {
        const form = document.getElementById('reply-form-' + id);
        form.classList.toggle('d-none');
    }

    const product_side_images = document.querySelectorAll('.product_side_image');
    product_side_images.forEach(side_image => {
        side_image.addEventListener('mouseover', () => {
            document.querySelector('.product_image').src = side_image.getAttribute('data-src');
        });
    });

    // select color
    const colors = document.querySelectorAll('.colors');
    colors.forEach(color => {
        color.addEventListener('click', function () {
            colors.forEach(c => c.classList.remove('color-selected'));
            this.classList.add('color-selected');
        });
    });

    // select size
    const sizes = document.querySelectorAll('.sizes');
    sizes.forEach(size => {
        size.addEventListener('click', function () {
            sizes.forEach(c => c.classList.remove('size-selected'));
            this.classList.add('size-selected');
        });
    });


    // add cart
    const addCart = document.getElementById('addToCart')
    addCart.addEventListener('click', () => {
        let product_id = {!! json_encode($product['product']->id) !!}
        let user_id = {!! json_encode(session('isUser')) !!}
        let action = {!! json_encode(route('catalog.addCart')) !!}
        let quantity = document.getElementById('quantity').value;

        let color_id = document.querySelector('.color-selected')
        // if(color_id) 
        //     color_id = color_id.getAttribute('data-color-id')

        // let size_id = document.querySelector('.size-selected')
        // if(size_id) 
        //     size_id = size_id.getAttribute('data-size-id')

        // if(!(color_id && size_id)){
        //     showFlashMessage('error','Please select color and size.')
        //     return 
        // }

        
        if(user_id){
            $.ajax({
                url: action,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id,
                    product_id: product_id,
                    quantity: quantity,
                    // color_id: color_id,
                    // size_id: size_id
                },
                success: function(response) {
                    if (response.success) {
                        showFlashMessage('success',response.message)
                    }else {
                        showFlashMessage('error',response.message)
                    }
                },
                error: function(xhr, status, error) {
                    showFlashMessage('error','An error occurred while adding to cart.')
                }
            });
        }else{
            window.location.href =  {!! json_encode(route('catalog.user-login')) !!}
        }
        
    })

    // add wishlist
    const addWishlist = document.getElementById('addWishlist')
    addWishlist.addEventListener('click', () => {
        let product_id = {!! json_encode($product['product']->id) !!}
        let user_id = {!! json_encode(session('isUser')) !!}
        let action = {!! json_encode(route('catalog.wishlist')) !!}
        let quantity = document.getElementById('quantity').value;

        if(user_id){
            $.ajax({
                url: action,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id,
                    product_id: product_id,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        showFlashMessage('success',response.message)
                    }else {
                        showFlashMessage('error',response.message)
                    }
                },
                error: function(xhr, status, error) {
                    showFlashMessage('error','An error occurred while adding to cart.')
                }
            });
        }else{
            window.location.href =  {!! json_encode(route('catalog.user-login')) !!}
        }
        
    })

    // increase quantity
    function increaseQunatity() {
        let current_quantity = parseInt(document.getElementById('quantity').value);
        let total_quantity = document.getElementById('quantity').value = current_quantity +  1;
    }

    // increase quantity
    function decreaseQunatity() {
        let current_quantity = parseInt(document.getElementById('quantity').value);
        if(current_quantity > 1){
            let total_quantity = document.getElementById('quantity').value = current_quantity -  1;
        }
    }

    // rating

    let stars = document.querySelectorAll('.star-rating .fa-star');
    let ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function () {
            let rating = this.getAttribute('data-index');
            ratingInput.value = rating;

            stars.forEach((s, i) => {
                s.classList.toggle('checked', i < rating);
            });
        });
    });

 </script>

@endif

@endsection
