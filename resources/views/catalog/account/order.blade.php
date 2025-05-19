@extends('catalog.common.base')

@push('setTitle')
    My Order
@endpush

@section('content')

<section class="container-fluid py-4">
    <h2 class="text-center mb-4"><i class="fa-brands fa-jedi-order"></i> My Order</h2>
    <!-- Alert message -->
    @include('catalog.common.alert')

    <div class="row g-4">
        <div class="col-lg-10">
            <div class="card p-2">
                <div class="row">
                    @forelse ($orderMaster as $item)
                        <div class="col-md-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0 fs-6">Order #{{ $item->id }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-0 fs-6"><strong>User Name:</strong> {{ $item->name }}</p>
                                            <p class="mb-0 fs-6"><strong>Total:</strong> <i class="fa-solid fa-indian-rupee-sign"></i> {{ number_format($item->total_amount, 0) }}</p>
                                            <p class="mb-0 fs-6"><strong>Payment Method:</strong> @if ($item->payment_method == 'cod') <span class="bg-info text-white p-1 rounded">{{ strtoupper($item->payment_method) }}</span> @else  <span class="bg-success text-white p-1 rounded">PAID</span>  @endif</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-0 fs-6">
                                                <strong>Status:</strong> 
                                                <span>{{ ucfirst($item->order_status) }}
                                                </span>
                                            </p>
                                            <p class="mb-0 fs-6"><strong>Date:</strong> {{ $item->created_at->format('d-m-Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('catalog.orderInfo', $item->id) }}" class="btn btn-dark btn-sm">
                                            <i class="fa-solid fa-eye"></i> View Order
                                        </a>
                                        <button class="btn btn-dark btn-sm" data-bs-toggle="collapse" data-bs-target="#order-{{ $item->id }}">
                                            <i class="fa-solid fa-eye"></i> View Items
                                        </button>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div id="order-{{ $item->id }}" class="collapse">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr class="table-dark">
                                                    <th width="40%">Order Item</th>
                                                    <!-- color and size-->
                                                    <th width="20%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item->orders as $order)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('catalog.product-detail', ['product_id' => $order->product->id, 'slug' => $order->product->slug]) }}">
                                                                <img class="p-1 me-3" height="70" src="{{ ($order->product->image) ? asset("image/cache/products").'/'.($order->product->id .'/'. str_replace(".jpg",'',$order->product->image) .'_100x100.jpg') : asset('not-image-available.png')}}" alt="">
                                                            </a>
                                                            <span class="mb-0 fs-6">{{ $order->product->product_name }}</span>
                                                        </td>
                                                        <!-- color and size value---->
                                                        <td>
                                                            @foreach ($order->orderHistory as $key => $history)
                                                                @if ($key == 0)
                                                                    <span>{{ $history->order_status }}</span>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">No Orders Found</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center my-3">
                    {{ $orderMaster->links() }}
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            @include('catalog.common.right-navbar')
        </div>
    </div>
</section>

@endsection
