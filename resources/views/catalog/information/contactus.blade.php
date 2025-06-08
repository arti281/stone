@extends('catalog.common.base')

@push('setTitle')
    Contact Us
@endpush

@section('content')
<style>
    .policy_font{
        font-size: 14px
    }
</style>
<section id="aa-contact" class="py-5">
  <div class="container">
    <div class="text-center mb-4">
      <h2>Your Vision, Our Craft – Contact Us</h2>
      <p>Reach Out to Us</p>
    </div>

    <!-- Contact Map -->
    <div class="mb-5">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3506.484440694825!2d77.23589027549573!3d28.495069175740102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce1ce7a12e09d%3A0x310ac2ef78b0e98e!2sPstone%20Arts%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1748709835654!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Contact Address and Form -->
    <div class="row">
      <!-- Contact Form -->
      <div class="col-md-8 mb-4">
         @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @error('mobile')
    <div class="text-danger">{{ $message }}</div>
@enderror
        <form action="{{ route('catalog.contactus') }}" method="POST">
         @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" class="form-control mb-3">
            </div>
            <div class="col-md-6">
              <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control mb-3">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="mobile" class="form-label">Mobile Number</label>
              <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"placeholder="Enter your mobile number" pattern="[0-9]{10}" required>
            </div>
          </div>
          <div class="mb-3">
            <textarea rows="3" name="message" value="{{ old('message') }}"placeholder="Message" class="form-control"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4">
        <address>
          <h4>Pstone Arts</h4>
          <p>Pstone Arts, Govindgarh Road, Behind the Jagannath Temple, Sikri, Deeg<br/> </p>
          <p><i class="bi bi-house-door-fill me-2"></i><b>Pin Code</b> - 321024</p>
          <p><i class="bi bi-telephone-fill me-2"></i><b>Phone No.: </b>+91 - 8094246141, +91 - 8130854742</p>
          <p><i class="bi bi-envelope-fill me-2"></i><b>Email: </b>support@pstonearts.com</p>
        </address>
      </div>
    </div>
  </div>
</section>

@endsection
