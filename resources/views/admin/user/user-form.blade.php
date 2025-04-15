@extends('admin.common.base')

@push('setTitle')
    {{$heading_title}}
@endpush

@section('content')

<style>
    .tabs {
        display: none;
    }

    .tabs.active {
        display: block;
    }
</style>

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
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Add Users</p>
                    </div>

                    <div class="card rounded-0 p-3 mb-3">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="false">General</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">Address</button>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <form action="{{$action}}" id="saveForm" method="post" enctype="multipart/form-data" class="pt-3">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <!-- Gerenel -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="user_group_id">Users Group</label>
                                                </div>
                                                <div class="col-9">
                                                    <select id="user-dropdown" name="user_group_id" class="form-control">
                                                        <option value="0">Default</option>
                                                    </select> 
                                                    <div>
                                                        <span class="text-danger">
                                                            @error('user_group_id')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="user_name">User Name</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="user_name" name="user_name" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'name') ? $user->name : old('user_name') }}" placeholder="user Name">
                                                    <div>
                                                        <span class="text-danger">
                                                            @error('user_name')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="email">Email</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="email" id="email" name="email" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'email') ? $user->email : old('email') }}" placeholder="Email">
                                                    <div>
                                                        @if(Session::has('email_error'))
                                                            <div id="flash-message" class="alert alert-danger alert-dismissible fade show mt-2 p-1" role="alert">
                                                                {{ Session::get('email_error') }}
                                                                <button type="button" class="btn-close p-0 mt-2 me-2" style="font-size:11px" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        @endif
                                                        <span class="text-danger">
                                                            @error('email')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="number">Contact</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" id="number" name="number" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'number') ? $user->number : old('number') }}" placeholder="Number">
                                                    <div>
                                                        <span class="text-danger">
                                                            @error('number')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="password">Password</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="password" id="password" name="password" class="form-control p-2" value="{{ old('password') }}" placeholder="Password">
                                                    <div>
                                                        <span class="text-danger">
                                                            @error('password')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="confirm_password">Confirm Password</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="confirm_password" name="confirm_password" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'confirm_password') ? $user->confirm_password : old('confirm_password') }}" placeholder="Confirm Password">
                                                    <div>
                                                        <span class="text-danger">
                                                            @error('confirm_password')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="status">Status</label>
                                                </div>
                                                <div class="col-9 form-check form-switch">
                                                    <input type="hidden" name="status" value="0">
                                                    <input class="form-check-input fs-3 m-0" id="status" name="status" type="checkbox" role="switch" value="1" {{ isset($user) && property_exists($user, 'status') ? (($user->status) ? 'checked': '') : old('status') }}>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="row mb-4">
                                                <div class="col-3 text-end">
                                                    <label for="image">Profile Picture</label>
                                                </div>
                                                <div class="col-9">
                                                    <div class="card p-2" style="width: 12rem">
                                                        <img src="{{ isset($user) && ($user->image) ? asset("image/user").'/'.$user->image : asset('not-image-available.png')}}" alt="user Image" class="card-img-top" id="imagePreview"  onclick="triggerFileUpload()">
                                                        <input type="file" name="image" id="imageUpload" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                                        <div class="card-body text-center mt-1"> 
                                                            <button type="button" class="btn btn-danger fs-5 px-3" onclick="removeImage()" data-bs-toggle="tooltip" data-bs-placement="top" title="Clear"><i class="fa-solid fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="text-danger">
                                                            @error('image')
                                                                {{$message}}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="tab-pane fade show" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="row px-4">
                                        <div class="col-sm-3" style="background-color: #061a23">
                                            <div style="line-height: 40px">
                                                <a class="d-block text-decoration-none text-light" href="javascript:void(0)" onclick="showSection('1')">Address 1</a>
                                                <a class="d-block btn btn-primary" href="#">Add Address</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div id="1" class="active tabs">
                                                <input type="hidden" name="address_id" value="">
                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="address_user_name">Name</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" id="address_user_name" name="address_user_name" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'name') ? $user->name : old('address_user_name') }}" placeholder="Name">
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('address_user_name')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="address_contact">Contact</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="number" id="address_contact" name="address_contact" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'address_contact') ? $user->name : old('address_contact') }}" placeholder="Contact">
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('address_contact')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="address_1">Address 1</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" id="address_1" name="address_1" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'address_1') ? $user->name : old('address_1') }}" placeholder="Address 1">
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('address_1')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="address_2">Address 2</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" id="address_2" name="address_2" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'address_2') ? $user->name : old('address_2') }}" placeholder="Address 2">
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('address_2')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="city">City</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" id="city" name="city" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'city') ? $user->name : old('city') }}" placeholder="City">
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('city')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="pincode">Pin Code</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="number" id="pincode" name="pincode" class="form-control p-2" value="{{ isset($user) && property_exists($user, 'pincode') ? $user->name : old('pincode') }}" placeholder="Pin Code">
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('pincode')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="state_id">State</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select name="state_id" id="state_id" class="form-control">
                                                            <option value="">Select State</option>
                                                            @if ($states)
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('state_id')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-3 text-end">
                                                        <label for="country_id">Country</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select name="country_id" id="country_id" class="form-control">
                                                            <option value="">Select State</option>
                                                            @if ($countries)
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <div>
                                                            <span class="text-danger">
                                                                @error('country_id')
                                                                    {{$message}}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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


        function showSection(id) {
            const sections = document.querySelectorAll('.tabs');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(id).classList.add('active');
        }
    </script>
</section>
@endsection