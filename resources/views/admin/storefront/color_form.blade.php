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
                        <button class="btn btn-primary fs-4 px-3" data-bs-toggle="tooltip" id="submitButton" data-bs-placement="top" data-bs-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
                        <a class="btn btn-primary fs-4 px-3" href="{{$back}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back"><i class="fa-solid fa-reply"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-12">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Color</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="color_name">Color Name</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="color_name" name="color_name" class="form-control p-2" value="{{ isset($category) && property_exists($category, 'color_name') ? $category->color_name : old('color_name') }}" placeholder="Color Name">
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('color_name')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="hex_code">Hex Code</label>
                                </div>
                                <div class="col-10">
                                    <input type="color" id="hex_code" name="hex_code" class="form-control p-2" value="{{ isset($category) && property_exists($category, 'hex_code') ? $category->hex_code : old('hex_code') }}">
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('hex_code')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="sort_order">Sort Order</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="sort_order" name="sort_order" class="form-control p-2" value="{{ isset($category) && property_exists($category, 'sort_order') ? $category->sort_order : old('sort_order') }}" placeholder="Sort Order">
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('sort_order')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Form save 
    document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("saveForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });
</script>
@endsection