@extends('catalog.common.base')

@push('setTitle')
    Reset Password
@endpush

@section('content')

<section class="container py-5 d-flex justify-content-center ">
    <div class="col-6">
       <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center">Reset Password</h4>
                <!-- alert message -->
                @include('catalog.common.alert')

                <form action="{{$action}}" method="POST">
                    @csrf
                    <!-- password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label"><strong>Password</strong></label>
                        <input type="password" class="form-control p-3 bg-light" id="password" name="password" placeholder="Password">
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
</section>

@endsection