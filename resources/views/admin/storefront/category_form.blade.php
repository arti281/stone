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
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Add Category</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="category_name">Category Name</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="category_name" name="category_name" class="form-control p-2" value="{{ isset($category) && property_exists($category, 'category_name') ? $category->category_name : old('category_name') }}" placeholder="Category Name">
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('category_name')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="parent_id">Parent Name</label>
                                </div>
                                <div class="col-10">
                                    <select id="category-dropdown" name="parent_id" class="multiple-select">
                                        <option value="">Select Parent Category</option>
                                        @foreach($categories as $cat)
                                            @php
                                                $isSelected = isset($categoryPath) && $cat->id == $categoryPath->path_id;
                                            @endphp
                                            <option value="{{ $cat->id }}" {{ $isSelected ? 'selected' : '' }}>
                                                {{ $cat->full_path }}
                                            </option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('parent_id')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="description">Description</label>
                                </div>
                                <div class="col-10">
                                    <textarea id="summernote" name="description"></textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="meta_tag">Meta Tag</label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="meta_tag" name="meta_tag" class="form-control p-2" value="{{ isset($category) && property_exists($category, 'meta_tag') ? $category->meta_tag : old('meta_tag') }}" placeholder="Meta Tag">
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('meta_tag')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="image">Image</label>
                                </div>
                                <div class="col-10">
                                    <div class="card p-2" style="width: 12rem">
                                        <img src="{{ isset($category->image) ? asset('image/category/'.$category->image) : asset('not-image-available.png')}}" alt="Category Image" class="card-img-top" id="imagePreview"  onclick="triggerFileUpload()">
                                        <input type="file" name="image" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                        <div class="card-body text-center mt-1"> 
                                            <button type="button" class="btn btn-danger fs-5 px-3" onclick="removeImage()" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('image')
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

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="menu_top">Menu Top</label>
                                </div>
                                <div class="col-10 form-check form-switch">
                                    <input class="form-check-input fs-3 m-0" id="menu_top" name="menu_top" type="checkbox" role="switch" {{ isset($category) && property_exists($category, 'menu_top') ? (($category->menu_top) ? 'checked': '') : old('menu_top') }}  >
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="status">Status</label>
                                </div>
                                <div class="col-10 form-check form-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input class="form-check-input fs-3 m-0" id="status" name="status" type="checkbox" role="switch" value="1" {{ isset($category) && property_exists($category, 'status') ? (($category->status) ? 'checked': '') : old('status') }}>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        // Form save 
        document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("saveForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });

        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(`imagePreview`);
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function triggerFileUpload(index) {
            document.getElementById(`imageUpload`).click();
        }

        function removeImage() {
            document.getElementById('imageUpload').value = '';
            document.getElementById(`imagePreview`).src = "{{ asset('not-image-available.png')}}";
        }

    </script>
</section>
@endsection