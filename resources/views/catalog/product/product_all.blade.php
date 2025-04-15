@extends('catalog.common.base')

@push('setTitle')
    All Products
@endpush

@section('content')

    <section class="container-fluid py-4">
        <div class="col-sm-12">
            <div class="bg-white mb-4 p-2">
                <div class="row pt-1">
                    <div class="col-4 col-sm-4 col-md-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-block d-sm-block d-md-none">
                                <a class="btn btn-light fs-4" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                    <i class="fa-solid fa-filter"></i>
                                  </a>
                                <!-- For Mobile filter offcanvas -->
                                <div class="offcanvas offcanvas-start d-block" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                                    <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filters</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <form action="{{ route('catalog.product-all', [$category_id, $category_slug]) }}" method="get">
                                            <div class="bg-white p-2 pb-4">
                                                <h3 class="fs-6 text-uppercase fw-bold">Sizes</h3>
                                                @if ($sizes)
                                                    @foreach ($sizes as $size)
                                                        <div class="mt-3 d-flex align-items-center" style="line-height: 15px">
                                                            <input type="checkbox" name="size[]" class="size size_ids" @if(is_array($query_size) && in_array($size->size_name, $query_size)) checked @endif value="{{ $size->size_name }}" style="height: 18px; width:18px">
                                                            <span class="ms-2">{{ $size->size_name }}</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                        
                                            <div class="bg-white p-2 border-top py-3">
                                                <h3 class="fs-6 text-uppercase fw-bold">Colors</h3>
                                                @if ($colors)
                                                    @foreach ($colors as $color)
                                                        <div class="mt-3 d-flex align-items-center">
                                                            <input type="checkbox" name="color[]" class="color color_ids" @if(is_array($query_color) && in_array($color->color_name, $query_color)) checked @endif value="{{ $color->color_name }}"
                                                                style="height:18px; width:18px">
                                                            <p class="mb-0 ms-2 d-flex align-items-center" style="line-height: 15px">
                                                                <span class="d-block border"
                                                                    style="width:15px;height:15px;border-radius:50%;background:{{ $color->code }}"></span>
                                                                <span class="ms-1"> {{ $color->color_name }}</span>
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="text-end bg-white p-2 border-top py-3">
                                                @if ($search)
                                                    <input type="hidden" value="{{ $search ?? '' }}" name="search">
                                                @endif
                                                <input type="submit" class="btn btn-primary fs-6" value="Filter">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Mobile filter offcanvas -->
                            </div>
                            <h3 class="fs-6 text-uppercase mb-0 p-1 fw-bold d-none d-sm-none d-md-block">Filters</h3>
                            <a href="javascript:void(0)" id="clear_all"
                                class="fs-6 text-uppercase text-decoration-none text-danger fw-bold d-none d-sm-none d-md-block">Clear All</a>
                        </div>
                    </div>
                    <div class="col-8 col-sm-8 col-md-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 me-2 fw-bold" style="text-wrap: nowrap;">Sort By:</p>
                                <select name="filter" id="filters" class="custom-select">
                                    <option class="ms-2" value="latest" @if ($sort === 'latest') selected @endif>
                                        Latest</option>
                                    <option class="ms-2" value="discounted"
                                        @if ($sort === 'discounted') selected @endif>Discounted</option>
                                    <option class="ms-2" value="desc" @if ($sort === 'desc') selected @endif>
                                        Descending</option>
                                    <option class="ms-2" value="asc" @if ($sort === 'asc') selected @endif>
                                        Ascending</option>
                                    <option class="ms-2" value="low_to_high"
                                        @if ($sort === 'low_to_high') selected @endif>Price: Low To High</option>
                                    <option class="ms-2" value="high_to_low"
                                        @if ($sort === 'high_to_low') selected @endif>Price: High To Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 d-none d-sm-none d-md-block">
               <form class="" action="{{ route('catalog.product-all', [$category_id, $category_slug]) }}" method="get">
                    <div class="bg-white p-2 pb-4">
                        <h3 class="fs-6 text-uppercase fw-bold">Sizes</h3>
                        @if ($sizes)
                            @foreach ($sizes as $size)
                                <div class="mt-3 d-flex align-items-center" style="line-height: 15px">
                                    <input type="checkbox" name="size[]" class="size size_ids" @if(is_array($query_size) && in_array($size->size_name, $query_size)) checked @endif value="{{ $size->size_name }}" style="height: 18px; width:18px">
                                    <span class="ms-2">{{ $size->size_name }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="bg-white p-2 border-top py-3">
                        <h3 class="fs-6 text-uppercase fw-bold">Colors</h3>
                        @if ($colors)
                            @foreach ($colors as $color)
                                <div class="mt-3 d-flex align-items-center">
                                    <input type="checkbox" name="color[]" class="color color_ids" @if(is_array($query_color) && in_array($color->color_name, $query_color)) checked @endif value="{{ $color->color_name }}"
                                        style="height:18px; width:18px">
                                    <p class="mb-0 ms-2 d-flex align-items-center" style="line-height: 15px">
                                        <span class="d-block border"
                                            style="width:15px;height:15px;border-radius:50%;background:{{ $color->code }}"></span>
                                        <span class="ms-1"> {{ $color->color_name }}</span>
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-end bg-white p-2 border-top py-3">
                        @if ($search)
                            <input type="hidden" value="{{ $search ?? '' }}" name="search">
                        @endif
                        <input type="submit" class="btn btn-primary fs-6" value="Filter">
                    </div>
               </form>
            </div>
            <div class="col-md-10">
                <div class="row">
                    @if ($products)
                        <!-- Total -->
                        <div class="mb-3"><span>Total Products: <strong>{{ $pagination['total'] }}</strong></span></div>
                        @foreach ($products as $product)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 products">
                                <a href="{{ route('catalog.product-detail', ['product_id' => $product->product_id, 'slug' => $product->slug]) }}">
                                    <div class="product-item">
                                        <div class="image-holder">
                                            <img src="{{ $product->image ? asset('image/cache/products') . '/' . ($product->product_id . '/' . str_replace('.jpg', '', $product->image) . '_500x500.jpg') : asset('not-image-available.png') }}"
                                                alt="{{ $product->product_name }}" class="product-image"
                                                style="max-height:300px;object-fit:contain;">
                                        </div>
                                        {{-- <div class="cart-concern">
                                            <div class="cart-button d-flex justify-content-center align-items-center p-1" style="background-color: #eceef1;">
                                            <div class="col-6 border-end">
                                                <a href="#" class="text-decoration-none text-dark pe-3">
                                                    <i class="fa-regular fa-heart p-2 fs-4 rounded-circle" style="color:#ff006f"></i>
                                                </a>
                                            </div>
                                                <div class="col-6">
                                                <a href="#" class="text-decoration-none text-dark">
                                                        <i class="fa-solid fa-cart-plus p-2 fs-4 rounded-circle" style="color:#ff006f"></i>
                                                </a>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="product-detail">
                                            <h3 class="product-title fs-6 truncate-lines mb-0">
                                                <small>{{ $product->product_name }}</small></h3>
                                            <p class="mb-0 text-muted truncate-lines" style="color:teal;font-size:13px">
                                                {{ $product->tag }}</p>
                                            <span
                                                class="text-dark fs-6"><strong>Rs.{{ number_format($product->mrp, 0) }}</strong></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <h2 class="text-center">Product Not Found</h2>
                    @endif

                    @if ($pagination)
                        <!-- Pagination -->
                        @include('catalog.common.pagination')
                    @endif
                </div>
            </div>
    </section>

    <script>

        let category_id = {!! json_encode($category_id) !!};
        let category_slug = {!! json_encode($category_slug) !!};
        let query_string = {!! json_encode($query_string) !!};

        // Clear
        document.getElementById('clear_all').addEventListener('click', () => {
            document.querySelectorAll('.size').forEach(element => {
                element.checked = false
            });
            document.querySelectorAll('.color').forEach(element => {
                element.checked = false
            });

            window.location.href = '/products?sort=latest';
        })

        // Sorting
        if (category_id !== null) {
            document.getElementById('filters').addEventListener('change', function() {
                const selectedValue = encodeURIComponent(this.value);
                window.location.href = '/products/' + encodeURIComponent(category_id) + '/' + encodeURIComponent(category_slug) + '?' +query_string +'&sort=' + selectedValue;
            });
        } else {
            document.getElementById('filters').addEventListener('change', function() {
                const selectedValue = encodeURIComponent(this.value);
                window.location.href = '/products' + '?' +query_string +'&sort=' + selectedValue;
            });
        }

    </script>

@endsection
