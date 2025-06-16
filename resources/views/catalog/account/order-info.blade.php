@extends('catalog.common.base')

@push('setTitle')
    Order Info #{{ $orderMaster->id }}
@endpush

@push('addStyle')
    <style>
        p{
            margin: 0px !important;
            font-size: 15px
        }
    </style>
@endpush

@push('addScript')
    <script>
        function showHistory() {
            const order_master_id = {!! json_encode($orderMaster->id) !!};
            const route = {!! json_encode(route('catalog.getOrderHistory', $orderMaster->id)) !!};

            $.ajax({
                url: route,
                method: 'GET',
                success: function(response) {
                    let html = '';
                    // Populate the table rows
                    response.histories.data.forEach(history => {                      
                        html += `
                            <tr>
                                <td>${history.order_id}</td>
                                <td>${history.order_status}</td>
                                <td>${new Date(history.created_at).toLocaleString()}</td>
                                <td>${history.comment ?? ''}</td>
                            </tr>
                        `;
                    });

                    // Update the order history table
                    document.getElementById('orderHistory').innerHTML = html;

                    // Handle pagination
                    let paginationHtml = '';

                    if (response.histories.prev_page_url) {
                        paginationHtml += `
                            <a href="javascript:void(0)" class="page-link text-primary" onclick="fetchPage('${response.histories.prev_page_url}')">Previous</a>
                        `;
                    }

                    // Add current and total pages
                    if(response.histories.data.length >= response.histories.per_page){
                        paginationHtml += `
                            <span class="mx-2">Page ${response.histories.current_page} of ${Math.ceil(response.histories.to / response.histories.per_page)}</span>
                        `;
                    }

                    if (response.histories.next_page_url) {
                        paginationHtml += `
                            <a href="javascript:void(0)" class="page-link text-primary" onclick="fetchPage('${response.histories.next_page_url}')">Next</a>
                        `;
                    }

                    // Update pagination container
                    document.getElementById('pagination').innerHTML = paginationHtml;
                },
                error: function(error) {
                    console.error('Error fetching order history:', error);
                }
            });
        }

        // Helper function to handle pagination clicks
        function fetchPage(url) {
            if (!url) return;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    let html = '';

                    // Populate the table rows
                    response.histories.data.forEach(history => {
                        html += `
                            <tr>
                                <td>${history.order_id}</td>
                                <td>${history.order_status}</td>
                                <td>${new Date(history.created_at).toLocaleString()}</td>
                                <td>${history.comment ?? ''}</td>
                            </tr>
                        `;
                    });

                    // Update the order history table
                    document.getElementById('orderHistory').innerHTML = html;

                    // Handle pagination again for new page
                    let paginationHtml = '';

                    if (response.histories.prev_page_url) {
                        paginationHtml += `
                            <a href="javascript:void(0)" class="page-link text-primary" onclick="fetchPage('${response.histories.prev_page_url}')">Previous</a>
                        `;
                    }

                    paginationHtml += `
                        <span class="mx-2">Page ${response.histories.current_page} of ${Math.ceil(response.histories.to / response.histories.per_page)}</span>
                    `;

                    if (response.histories.next_page_url) {
                        paginationHtml += `
                            <a href="javascript:void(0)" class="page-link text-primary" onclick="fetchPage('${response.histories.next_page_url}')">Next</a>
                        `;
                    }

                    // Update pagination container
                    document.getElementById('pagination').innerHTML = paginationHtml;
                },
                error: function(error) {
                    console.error('Error fetching page:', error);
                }
            });
        }
        showHistory()

        // print invoice
        document.getElementById('download-invoice').addEventListener("click", () => {

        })
    </script>
@endpush

@section('content')

<section class="container-fluid py-4">
    <h2 class="text-center mb-4"><i class="fa-brands fa-jedi-order"></i> Order Info</h2>
    <div class="row g-4">
        <div class="col-lg-10">
            <div class="col-md-12">
                <div class="card p-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h2>Order #{{ $orderMaster->id }}</h2>  
                        <div>
                            <a target="blank" href="{{ route('catalog.invoice', ['order_master_id' => $orderMaster->id]) }}" id="download-invoice" class="btn btn-primary btn-sm">Download Invoice</a>
                        </div>
                    </div>               
                    <div class="row g-4 px-0">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Order ID</p>
                                </div>
                                <div class="col-6">
                                    <p>#{{ $orderMaster->id }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Order Status</p>
                                </div>
                                <div class="col-6">
                                    <p>{{ $orderMaster->order_status }}</p>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Payment Method</p>
                                </div>
                                <div class="col-6">
                                    <p>{{ strtoupper($orderMaster->payment_method) }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="fw-bold">Date Added</p>
                                </div>
                                <div class="col-6">
                                    <p>{{ $orderMaster->created_at->format('d-m-Y') }}</p>
                                </div>
                            </div>
                        </div>
        
                        <!-- shipping address -->
                        <div class="col-12">
                            <div class="border">
                                <h5 class="p-2" style="background-color: #e7e8e9">Shipping Address</h5>
                                <div class="mt-2 p-2">
                                    <p class="fw-bold">{{ $orderMaster->name }}</p>
                                    <p>{{ $orderMaster->contact }},</p>
                                    <p>{{ $orderMaster->address_1 }},</p>
                                    <p>{{ $orderMaster->address_2 }},</p>
                                    <p>{{ $orderMaster->city }},</p>
                                    <p>{{ $orderMaster->state }}-{{ $orderMaster->pincode }}</p>
                                </div>
                            </div>
                        </div>
        
                        <!-- Products -->
                        <div class="col-12">
                            <table class="table table-bordered" style="font-size: 15px">
                                <thead>
                                    <tr>
                                        <th width="20%">Product Order ID</th>
                                        <th width="20%">Product Image</th>
                                        <th width="20%">Product Name</th>
                                        <th width="20%">Quantity</th>
                                        <th width="20%">Price</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><strong>{{ $order->id }}</strong></td>
                                            <td>                                                                <img class="p-1 me-3" height="70" src="{{ ($order->product->image) ? asset("image/cache/products").'/'.($order->product->id .'/'. str_replace(".jpg",'',$order->product->image) .'_100x100.jpg') : asset('not-image-available.png')}}" alt=""></td>
                                            <td>{{ $order->product_name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td><i class="fa-solid fa-indian-rupee-sign"></i> {{ number_format($order->price, 0) }}</td>
                                            <td>
                                                <a href="{{ route('catalog.product-detail', ['product_id' => $order->product_id]) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reorder"><i class="fa-solid fa-cart-plus"></i></a>
                                                <a href="#" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Return"><i class="fa-solid fa-reply"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-muted">Total MRP</td>
                                        <td class="text-end">
                                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="total_mrp">{{ number_format($orderMaster->total_mrp, 0) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-muted">Discount on MRP</td>
                                        <td class="text-end text-success">
                                            <span class="fw-bold"> - <i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="discount_on_mrp">{{ number_format($orderMaster->discount_on_mrp, 0) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-muted">Coupon Discount</td>
                                        <td class="text-end text-success">
                                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="coupon_discount">0</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-muted">Platform Fee</td>
                                        <td class="text-end text-success">
                                            <span id="platform_fee">Free</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-muted">Shipping Fee</td>
                                        <td class="text-end text-success">
                                            <span id="shipping_fee">Free</span>
                                        </td>
                                    </tr>
                                    @if ($orderMaster->cod_fee)
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-muted">COD Fee</td>
                                            <td class="text-end text-success">
                                                <span id="shipping_fee"><i class="fa-solid fa-indian-rupee-sign"></i> {{ $orderMaster->cod_fee }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($orderMaster->prepaid_fee)
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="text-muted">Prepaid Fee</td>
                                            <td class="text-end text-success">
                                                <span id="shipping_fee">-{{ $orderMaster->prepaid_fee }} %</span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="text-muted">Total Amount</td>
                                        <td class="text-end fw-bold">
                                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="total_amount">{{ number_format($orderMaster->total_amount, 0) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        
                        <!-- Order History -->
                        <div class="col-12">
                            <h5>History</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30%">Product Order ID</th>
                                        <th width="23%">Order Status</th>
                                        <th width="22%">Date</th>
                                        <th width="25%">Comment</th>
                                    </tr>
                                </thead>
                                <tbody id="orderHistory"></tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center my-3" id="pagination"></div>
                        </div>
        
                        <div class="text-end">
                            <a href="{{ route('catalog.order') }}" class="btn btn-primary btn-sm">Continue</a>
                        </div>
        
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
