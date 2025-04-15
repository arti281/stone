@extends('catalog.common.base')

@push('setTitle')
    Category
@endpush

@section('content')

    <section class="container-fluid p-4">
        <!-- categories -->
        <div class="pb-5">
            <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                <h2 class="section-title fs-3">All Categories</h2>                      
            </div>
            <!-- All category  -->
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-6 col-sm-3 col-md-2">
                        <a href="{{ route('catalog.product-all', [$category->id, $category->slug]) . '?sort=latest' }}">
                            <div class="p-1 category_image">
                                <img class="w-100 category-img" src="{{ isset($category->image) ? asset('image/category/' . $category->image) : asset('not-image-available.png') }}" alt="{{ $category->category_name }}">
                            </div>
                            <p class="text-center mt-2 text-dark">{{ $category->category_name }}</p>
                        </a>
                    </div>
                @endforeach
            </div>

            @if ($pagination)
                <!-- Pagination -->
                <div class="mt-3">
                    @include('catalog.common.pagination')
                </div>
            @endif
        </div>
    </section>
@endsection
