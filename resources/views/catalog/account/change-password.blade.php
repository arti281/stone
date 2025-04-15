@extends('catalog.common.base')

@push('setTitle')
    Change Password
@endpush

@section('content')

<section class="container-fluid py-5">
    <div class="row g-4">
        <div class="col-lg-10 d-flex justify-content-center">
            <div class="col-12 col-sm-12 col-md-8">
               <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-center">Change Password</h4>
                        <!-- alert message -->
                        @include('catalog.common.alert')
        
                        <form action="{{$action}}" method="POST">
                            @csrf
                            <!-- password Input -->
                            <div class="mb-4">
                                <label for="password" class="form-label"><strong>New Password</strong></label>
                                <input type="password" class="form-control p-3 bg-light" id="password" name="password" placeholder="New Password">
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('password')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                    
                            <!-- password Input -->
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label"><strong>Confirm Password</strong></label>
                                <input type="text" class="form-control p-3 bg-light" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('confirm_password')
                                        {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>
        
                            @if(session('password_not_match'))
                                <div class="mb-4">
                                    <span class="text-danger">
                                    {{ session('password_not_match') }}
                                    </span>
                                </div>
                            @endif
                    
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button class="btn btn-dark btn-lg px-5 py-2" type="submit">Submit</button>
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