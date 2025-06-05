@extends('catalog.common.base')

@push('setTitle')
    Verify OTP
@endpush

@section('content')

<section class="container py-5 d-flex justify-content-center ">
    <div class="col-5">
       <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center">Verify OTP</h4>

                <!-- alert message -->
                @include('catalog.common.alert')

                <form action="{{$action}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="text-start mb-2">
                            <label for="otp"><strong>Enter OTP</strong></label>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="otp" name="otp" class="form-control p-2" placeholder="Enter OTP">
                        </div>
                        <div class="errors">
                            <span class="text-danger">
                                @error('otp')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                        <button class="btn btn-dark " type="submit">Verify</button>
                    </div>
                </form>
                
            </div>
       </div>
    </div>
</section>

@endsection