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
                    <div>
                        <button id="submitButton" class="btn btn-primary fs-4 px-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
                        <a class="btn btn-primary fs-4 px-3" href="{{$back}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back"><i class="fa-solid fa-reply"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 px-4">
                <div class="col-md-12">
                    <!-- Alert Message -->
                    @include('admin.common.alert')
                    
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Ecommerce Status</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form id="saveForm" action="{{$action}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="ecommerce_other_url_status">Status</label>
                                </div>
                                <div class="col-10 form-check form-switch">
                                    <input type="hidden" name="ecommerce_other_url_status" value="0">
                                    <input class="form-check-input fs-3 m-0" id="ecommerce_other_url_status" name="ecommerce_other_url_status" type="checkbox" @if($ecommerce_other_url_status) checked @endif role="switch" >
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="ecommerce_checkout_status">Checkout Status</label>
                                </div>
                                <div class="col-10 form-check form-switch">
                                    <input type="hidden" name="ecommerce_checkout_status" value="0">
                                    <input class="form-check-input fs-3 m-0" id="ecommerce_checkout_status" name="ecommerce_checkout_status" type="checkbox" @if($ecommerce_checkout_status) checked @endif role="switch" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("saveForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });
    </script>
    
</section>
@endsection