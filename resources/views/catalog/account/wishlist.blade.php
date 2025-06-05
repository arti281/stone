@extends('catalog.common.base')

@push('setTitle')
    Wishlist
@endpush

@section('content')

<section class="container-fluid py-4">
    <h2 class="text-center mb-4"><i class="fa-solid fa-heart"></i> My Wishlist</h2>
    <!-- Alert message -->
    @include('catalog.common.ajax_alert')
    @include('catalog.common.alert')

    <div class="row g-4">
        <div class="col-lg-10">
            <div class="card p-2 overflow-auto">
                <table class="table table-stripped">
                    <thead>
                        <tr>
                            <th width="20%"></th>
                            <th width="40%">Product Name</th>
                            <th width="20%">Quantity</th>
                            <th width="10%">Price</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($wishlist_total > 0)
                            @foreach ($wishlists as $wishlist)
                                <tr>
                                    <td class="text-center">
                                        <a
                                            href="{{ route('catalog.product-detail', ['product_id' => $wishlist['product_id'], 'slug' => $wishlist['slug']]) }}">
                                            <img class="border p-1 px-5" height="150" src="{{ $wishlist['image'] }}"
                                                alt="{{ $wishlist['product_name'] }}">
                                        </a>
                                    </td>
                                    <td>
                                        <p class="mb-0" style="font-size: 15px">
                                            <a class="text-dark fw-bold"
                                                href="{{ route('catalog.product-detail', ['product_id' => $wishlist['product_id'], 'slug' => $wishlist['slug']]) }}">{{ $wishlist['product_name'] }}</a>
                                        </p>
                                        {{-- <p class="mb-0 text-muted">Color: <span>Red</span></p> --}}
                                        <p class="mb-0 text-muted">
                                            @if ($wishlist['stock_status'] == 'In Stock')
                                                <span class="badge bg-success">{{ $wishlist['stock_status'] }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $wishlist['stock_status'] }}</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        @if ($wishlist['stock_status'] == 'In Stock')
                                            <div class="d-flex" style="column-gap: 15px">
                                                <input class="border text-center" style="width: 30px; height:30px"
                                                    type="text" readonly id="quantity_{{ $wishlist['product_id'] }}"
                                                    value="{{ $wishlist['quantity'] }}">
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($wishlist['stock_status'] == 'In Stock')
                                            <strong>Rs.</strong><span
                                                id="price_{{ $wishlist['product_id'] }}">{{ $wishlist['price'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between" style="gap: 5px">
                                            <button onclick="removeWishlistItem({{ $wishlist['product_id'] }})" class="btn btn-danger">Remove</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <caption class="text-center">
                                <h4>Wishlist is empty</h4>
                            </caption>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-2">
            @include('catalog.common.right-navbar')
        </div>
    </div>

</section>

<script>
    function removeWishlistItem(product_id){
        let user_id = {!! json_encode(session('isUser')) !!}
        let action = {!! json_encode(route('catalog.wishlist')) !!}

        if(user_id){
            $.ajax({
                url: action + '/' + product_id,
                method: 'DELETE',
                data: {_token : '{{ csrf_token() }}'},
                success: function(response) {
                    if (response.success) {
                        // showFlashMessage('success', response.message)
                        window.location.href = action
                    }else {
                        showFlashMessage('error', response.message)
                    }
                },
                error: function(xhr, status, error) {
                    showFlashMessage('error','An error occurred while adding to cart.')
                }
            });
        }else{
            window.location.href =  {!! json_encode(route('catalog.user-login')) !!}
        }

    }

</script>

@endsection
