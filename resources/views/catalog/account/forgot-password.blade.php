@extends('catalog.common.base')

@push('setTitle')
    Forgot Your Password
@endpush

@section('content')

<section class="container py-5 d-flex justify-content-center ">
    <div class="col-6">
       <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center">Forgot Your Password</h4>
                <!-- alert message -->
                @include('catalog.common.alert')

                <form action="{{$action}}" method="POST">
                    @csrf
                    <!-- email Input -->
                    <div class="mb-4">
                        <label for="email" class="form-label"><strong>Email</strong></label>
                        <input type="email" class="form-control p-3 bg-light" id="email" name="email" placeholder="email">
                        <div class="errors">
                            <span class="text-danger">
                                @error('email')
                                {{$message}}
                                @enderror
                            </span>
                        </div>
                    </div>

                    @if(session('email_not_match'))
                        <div class="mb-4">
                            <span class="text-danger">
                            {{ session('email_not_match') }}
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