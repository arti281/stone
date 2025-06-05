@extends('catalog.common.base')

@push('setTitle')
    Account Profile
@endpush

@section('content')

<section class="container-fluid py-5">
    <div class="row g-4">
        <div class="col-lg-10 d-flex justify-content-center">
            <div class="col-12 col-lg-8">
               <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-center">Update Your Information</h4>
                        <!-- alert message -->
                        @include('catalog.common.alert')
        
                        <form action="{{$action}}" method="POST">
                            @csrf
                            <!-- Email Input -->
                            <div class="mb-4">
                                <label for="email" class="form-label"><strong>Email</strong></label>
                                <input type="email" readonly value="{{ $profile->email ?? '' }}" class="form-control p-3 bg-light" placeholder="Enter your email">
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('email')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                    
                            <!-- Name Input -->
                            <div class="mb-4">
                                <label for="name" class="form-label"><strong>Name</strong></label>
                                <input type="text" id="name" name="name" class="form-control p-3" value="{{ $profile->name ?? '' }}" placeholder="Enter your name">
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('name')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                    
                    
                            <!-- Mobile Number Input -->
                            <div class="mb-4">
                                <label for="number" class="form-label"><strong>Mobile Number</strong></label>
                                <input type="number" id="number" name="number" value="{{ $profile->number ?? '' }}" class="form-control p-3" placeholder="Enter your mobile number">
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('number')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                    
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button class="btn btn-success btn-lg px-5 py-2" type="submit">Update</button>
                            </div>
                        </form>                
                        
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