@extends('admin.common.base')

@push('setTitle')
    {{$heading_title}}
@endpush

@push('addScript')
    <script>
        //================ clear filter button ===================
        document.getElementById('clearFilter').addEventListener('click', () => {
            window.location.href = {!! json_encode(route('admin.order')) !!}
        })

        // JavaScript to handle form submission
        document.getElementById('filter-form').addEventListener('submit', function(event) {
            event.preventDefault();

            // Collect form data
            const form = event.target;
            const formData = new FormData(form);

            const queryParams = [];
            formData.forEach((value, key) => {
                if (value.trim() !== '') { // Check if value is not empty or only whitespace
                    queryParams.push(`${key}=${encodeURIComponent(value)}`);
                }
            });

            // Construct URL with query parameters
            const actionUrl = form.getAttribute('action');
            const urlWithParams = actionUrl + '?' + queryParams.join('&');

            // Redirect to the constructed URL
            window.location.href = urlWithParams;
        });
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
                        {{-- <a class="btn btn-primary fs-4 px-3" href="{{$add}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add user"><i class="fa-solid fa-plus"></i></a>
                        <a class="btn btn-danger fs-4 px-3" data-name="Selected Users" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete user" id="multi-selection-delete-button"><i class="fa-solid fa-trash"></i></a> --}}
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-9 col-md-9">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%">Order ID</th>
                                    <th width="30%">Username</th>
                                    <th width="10%">Total</th>
                                    <th width="15%">Order Status</th>
                                    <th width="20">Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orderMaster as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{$order->name}}</td>
                                        <td><i class="fa-solid fa-indian-rupee-sign"></i> {{ $order->total_amount }}</td>
                                        <td>{{ $order->order_status }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            <a class="btn btn-primary mb-1" href="{{ route('admin.order') .'/'. $order->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>                                    
                                @empty
                                    <caption>
                                        <p class="text-center">Not found any users</p>
                                    </caption>
                                @endforelse
                            </tbody>
                        </table>

                       <!-- Pagination -->
                        <div class="d-flex justify-content-center my-3">
                            {{ $orderMaster->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-filter"></i> Filter</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <form id="filter-form" action="{{ route('admin.order') }}" method="get">
                            <div class="mb-3">
                                <label for="order_id" class="form-label fw-bold">Order Id</label>
                                <input type="text" class="form-control" name="order_id" id="order_id" value="{{ request('order_id') }}" placeholder="Order Id">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label fw-bold">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ request('username') }}" id="username" placeholder="Username">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label fw-bold">Start Date</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->name }}"  {{ request('status') == $status->name ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 text-end">
                                <input id="filter-button"  type="submit" class="btn btn-primary" value="Filter">
                                <button type="button" class="btn btn-warning" id="clearFilter">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection