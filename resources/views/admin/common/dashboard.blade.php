@extends('admin.common.base')

@push('setTitle')
    Dashboard
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
                <div class="admin-title">
                    <h2>Dashboard</h2>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-6 col-sm-6">
                    <div class="card dashboard dashboard-card1">
                        <div class="card-body p-5">
                            <p class="fs-1"><strong>{{ $total_brands ?? 0 }}</strong></p>
                            <h2><strong>DEMO</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6">
                    <div class="card dashboard dashboard-card2">
                        <div class="card-body p-5">
                            <p class="fs-1"><strong>{{ $total_retailers ?? 0 }}</strong></p>
                            <h2><strong>DEMO</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6">
                    <div class="card dashboard dashboard-card3">
                        <div class="card-body p-5">
                            <p class="fs-1"><strong>{{ $total_wholesalers ?? 0 }}</strong></p>
                            <h2><strong>DEMO</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6">
                    <div class="card dashboard dashboard-card4">
                        <div class="card-body p-5">
                            <p class="fs-1"><strong>{{$total_contacts ?? 0}}</strong></p>
                            <h2><strong>Enquiry</strong></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection