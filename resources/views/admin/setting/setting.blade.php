@extends('admin.common.base')

@push('setTitle')
{{$heading_title}}
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
                                    <li><a href="{{$breadcrumb['href']}}">{{$breadcrumb['text']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 px-4">
                <div class="col-md-12">
                    <!-- Alert Message -->
                    @include('admin.common.alert')
                    
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Setting List</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <div class="row">

                            <div class="col-sm-3">
                                <a href="{{ route('admin.general') }}" class="text-decoration-none">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><i class="fa-solid fa-gear"></i></p>
                                                <p class="mb-0">General</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a href="{{ route('ecommerce-links') }}" class="text-decoration-none">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><i class="fa-solid fa-link"></i></p>
                                                <p class="mb-0">Other Ecommerce Links</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-3">
                                <a href="{{ route('site') }}" class="text-decoration-none">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <p class="me-2 mb-0"><i class="fa-solid fa-globe"></i></p>
                                                <p class="mb-0">Site Setting</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("myForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });
    </script>
    
</section>
@endsection