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
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Edit Profile</p>
                    </div>
                    @if ($profile)
                        <div class="card rounded-0 p-3 mb-3 ">
                            <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-2 text-end">
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="username" name="username" class="form-control p-2" value="{{ isset($profile) && property_exists($profile, 'username') ? $profile->username : old('username') }}" placeholder="Username">
                                    </div>
                                    <div class="errors">
                                        <span class="text-danger">
                                            @error('username')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-2 text-end">
                                        <label for="firstname">FirstName</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="firstname" name="firstname" class="form-control p-2" value="{{ isset($profile) && property_exists($profile, 'firstname') ? $profile->firstname : old('firstname') }}" placeholder="FirstName">
                                    </div>
                                    <div class="errors">
                                        <span class="text-danger">
                                            @error('firstname')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-2 text-end">
                                        <label for="lastname">LastName</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="lastname" name="lastname" class="form-control p-2" value="{{ isset($profile) && property_exists($profile, 'lastname') ? $profile->lastname : old('lastname') }}" placeholder="LastName">
                                    </div>
                                    <div class="errors">
                                        <span class="text-danger">
                                            @error('lastname')
                                                {{$message}}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-2 text-end">
                                        <label for="email">Email</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="email" name="email" class="form-control p-2" value="{{ isset($profile) && property_exists($profile, 'email') ? $profile->email : old('email') }}" placeholder="Email">
                                    </div>
                                    <div class="errors">
                                        <span class="text-danger">
                                            @error('email')
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
                                            <img src="{{ isset($profile->image) ? asset('image/profile/'.$profile->image) : asset('not-image-available.png')}}" alt="Profile Image" class="card-img-top" id="imagePreview"  onclick="triggerFileUpload()">
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
                                        <label for="status">Status</label>
                                    </div>
                                    <div class="col-10 form-check form-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input fs-3 m-0" id="status" name="status" type="checkbox" role="switch" value="1" {{ isset($profile) && property_exists($profile, 'status') ? (($profile->status) ? 'checked': '') : old('status') }}>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
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