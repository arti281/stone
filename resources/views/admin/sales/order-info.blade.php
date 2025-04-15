@extends('admin.common.base')

@push('setTitle')
    {{$heading_title}}
@endpush

@push('addScript')
    <script>
        // Generate invoice
        const generate_invoice = document.getElementById('generate_invoice');
        if(generate_invoice){
            generate_invoice.addEventListener('click', () => {
                const route = {!! json_encode(route('admin.generateIncoice')) !!}
                const order_id = {!! json_encode($orderMaster->id) !!}
    
                $.ajax({
                    url: route,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: order_id
                    },
                    success: function(response) {
                        if (response.success) {
                            document.getElementById('invoice_no').textContent = response.invoice
                            generate_invoice.innerHTML = '';
                            showFlashMessage('success',response.message)
                        }else {
                            showFlashMessage('error',response.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        showFlashMessage('error','An error occurred while generating invoice.')
                    }
                });
            })
        }

        // add order history
        function addHistory(event){
            event.preventDefault();
            const route = {!! json_encode(route('admin.order')) !!}
            const order_master_id = {!! json_encode($orderMaster->id) !!}
            const product_order_id = document.getElementById('product_order_id');
            const order_status = document.getElementById('order_status');
            const notify = document.getElementById('notify');
            const comment = document.getElementById('comment');

            $.ajax({
                url: route,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_master_id: order_master_id,
                    order_id: product_order_id.value, 
                    order_status: order_status.value,
                    notify: notify.checked ? 1 : 0,
                    comment: comment.value
                },
                success: function(response) {
                    let messageDiv = document.getElementById('add_history_message');
                    if (response.success) {

                        product_order_id.value = '';
                        order_status.value = '';
                        comment.value = '';
                        notify.checked = false

                        messageDiv.innerHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        showHistory()
                    } else {
                        messageDiv.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                    }
                },
                error: function(response) {
                    let messageDiv = document.getElementById('add_history_message');
                    messageDiv.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ${response?.responseJSON?.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                }
            });
        }

        function showHistory() {
            const order_master_id = {!! json_encode($orderMaster->id) !!};
            const route = {!! json_encode(route('admin.getOrderHistory', $orderMaster->id)) !!};

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

    </script>
@endpush

@section('content')
<section class="container-fluid px-0">
    <div class="row">
        <div class="col-sm-12">
            @include('admin.common.header')
        </div>
        <div class="col-sm-2 p-0">
            @include('admin.common.left-sidebar')
        </div>
        <div class="col-sm-10 p-0">
            <div class="m-4">
                <div class="admin-title d-flex justify-content-between px-2">
                    <div class="d-flex admin-title-box">
                        <h2>{{$heading_title}}</h2>
                        <div class="breadcrumbs">
                            <ul class="ms-3">
                                @foreach ($breadcrumbs as $breadcrumb)
                                <li>
                                    @if ($breadcrumb['href'])
                                        <a href="{{$breadcrumb['href']}}">{{$breadcrumb['text']}}</a>
                                    @else
                                        <span class="text-muted">{{$breadcrumb['text']}}</span>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a class="btn btn-primary fs-4 px-3" href="{{$back}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back"><i class="fa-solid fa-reply"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-12">
                    
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <!-- Alert Message -->
                        @include('admin.common.alert')

                        <section class="container-fluid py-4">
                            <div class="col-12">
                                <div class="card p-4">
                                    <h2 class="mb-5">Order ID #{{ $orderMaster->id }}</h2>
                                   
                                    <div class="row g-4 px-0">
                        
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="fw-bold">Invoice No</p>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex" style="gap: 20px">
                                                        <p id="invoice_no">{{ $orderMaster->invoice_prefix }}{{ $orderMaster->invoice_no }}</p>
                                                        @if (!$orderMaster->invoice_no)
                                                            <p class="badge bg-primary p-2" id="generate_invoice" style="cursor: pointer" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Generate Invoice"><i class="fa-solid fa-cog"></i></p>
                                                        @endif
                                                    </div>
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
                                                    <p>{{ $orderMaster->created_at->format('d-m-Y h:i A') }}</p>
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
                                                        <th width="15%">Product Order ID</th>
                                                        <th width="20%">Product Name</th>
                                                        <th width="20%">SKU</th>
                                                        <th width="15%">Quantity</th>
                                                        <th width="15%">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td>{{ $order->id }}</td>
                                                            <td>{{ $order->product_name }}</td>
                                                            <td>{{ $order->sku }}</td>
                                                            <td>{{ $order->quantity }}</td>
                                                            <td><i class="fa-solid fa-indian-rupee-sign"></i> {{ number_format($order->price, 0) }}</td>
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
                                            <div class="border">
                                                <h5 class="mb-3 p-2" style="background-color: #e7e8e9">Order History</h5>
                                                <!-- Show order history -->
                                                <div class="card-body">
                                                    <h5>History</h5><hr>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th width="30%">Product Order ID</th>
                                                                <th width="23%">Order Status</th>
                                                                <th width="22%">Date</th>
                                                                <th width="25%">Comment</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="orderHistory">
                                                        </tbody>
                                                    </table>
                                                    <!-- Pagination -->
                                                    <div class="d-flex justify-content-center my-3" id="pagination"></div>
                                                </div>

                                                <!-- Add order history -->
                                                <div class="card-body">
                                                    <h5>Add History</h5><hr>
                                                    
                                                    <!-- alert message -->
                                                    <div id="add_history_message"></div>
                                                    
                                                    <form onsubmit="return addHistory(event)" method="post">
                                                        @csrf
                                                        <div class="row mb-4">
                                                            <div class="col-2 text-end">
                                                                <label for="product_order_id">Product Order ID</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <select name="product_order_id" id="product_order_id" class="form-control">
                                                                    <option value="">Select Product Order ID</option>
                                                                    @foreach ($orders as $order)
                                                                        <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->product_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('product_order_id')
                                                                    <div><span class="text-danger">{{$message}}</span></div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-2 text-end">
                                                                <label for="order_status">Order Status</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <select name="order_status" id="order_status" class="form-control">
                                                                    <option value="">Select Order Status</option>
                                                                    @foreach ($statuses as $status)
                                                                        <option value="{{ $status->name }}">{{ $status->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('order_status')
                                                                    <div><span class="text-danger">{{$message}}</span></div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-2 text-end">
                                                                <label for="notify">Notify</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="notify" type="checkbox" value="" id="notify">
                                                                </div>
                                                                @error('notify')
                                                                    <div><span class="text-danger">{{$message}}</span></div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-4">
                                                            <div class="col-2 text-end">
                                                                <label for="comment">Comment</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <textarea name="comment" id="comment" rows="5" class="form-control" placeholder="Write comment about product"></textarea>
                                                                @error('comment')
                                                                    <div><span class="text-danger">{{$message}}</span></div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-11 mb-4 text-end">
                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection