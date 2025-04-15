@extends('catalog.common.base')

@push('setTitle')
    Checkout
@endpush

@push('addScript')

<script>
    function populateFieldsFromSelected() {
        const selectBox = document.getElementById('address');
        const selectedOption = selectBox.options[selectBox.selectedIndex];
        
        // Get values from data attributes
        const name = selectedOption.getAttribute('data-name');
        const contact = selectedOption.getAttribute('data-contact');
        const address1 = selectedOption.getAttribute('data-address1');
        const address2 = selectedOption.getAttribute('data-address2');
        const city = selectedOption.getAttribute('data-city');
        const state = selectedOption.getAttribute('data-state');
        const pincode = selectedOption.getAttribute('data-pincode');
    
        // Populate input fields
        document.getElementById('name').value = name || '';
        document.getElementById('contact').value = contact || '';
        document.getElementById('address_1').value = address1 || '';
        document.getElementById('address_2').value = address2 || '';
        document.getElementById('city').value = city || '';
        document.getElementById('state').value = state || '';
        document.getElementById('pincode').value = pincode || '';
    }

    // Populate fields on page load
    window.addEventListener('DOMContentLoaded', populateFieldsFromSelected);

    // Update fields when the selection changes
    document.getElementById('address').addEventListener('change', populateFieldsFromSelected);

    // add cod fee

    if({!! json_encode(app('settings') && (int)app('settings')['general_cod_fee_status']) !!}){
        document.getElementById('cod').addEventListener('click', () => {
            const cod_fee = {!! json_encode($cod_fee) !!}
            const total_amount = {!! json_encode($total_amount) !!} 
    
            document.getElementById('fee_field').removeAttribute('style');
            document.getElementById('fee_text').textContent = "COD Fee";
            document.getElementById('fee_value').innerHTML = '<i class="fa-solid fa-indian-rupee-sign"></i>' + cod_fee;
            document.getElementById('total_amount').textContent = total_amount + cod_fee;
        })
    }
    
    // discount on prepaid
    if({!! json_encode(app('settings') && (int)app('settings')['general_prepaid_fee_status']) !!}){
        const codfee = document.getElementById('prepaid').addEventListener('click', () => {
            const prepaid_fee = {!! json_encode($prepaid_fee) !!}
            const total_amount = {!! json_encode($total_amount) !!}

            let prepaid_discount = (total_amount / 100) * prepaid_fee

            document.getElementById('fee_field').removeAttribute('style');
            document.getElementById('fee_text').textContent = "Prepaid Fee";
            document.getElementById('fee_value').textContent = '-' + prepaid_fee + '%';
            document.getElementById('total_amount').textContent = Math.ceil(total_amount - prepaid_discount);
        }) 
    }

</script>
    
@endpush

@section('content')
    <section class="container-fluid py-4">
        <h2 class="text-center mb-4"><i class="fa-solid fa-bag-shopping"></i> Checkout</h2>

        <!-- Alert message -->
        @include('catalog.common.ajax_alert')
        @include('catalog.common.alert')

        <form action="{{ $action }}" method="post">
            @csrf
            <div class="row g-4 mb-4">
                <!-- Billing Details -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-5">
                            <h4 class="card-title mb-4">Shipping Address</h4>
    
                            <!-- Select Address -->
                            <div class="mb-4">
                                <label for="address" class="fw-bold">Select Address</label>
                                <select name="address" id="address" class="form-control bg-light">
                                    <option value="" data-name="" data-contact="" data-address1="" data-address2="" data-city="" data-state="" data-pincode="">
                                        Select Address
                                    </option>
                                    @foreach ($addresses as $address)
                                        <option
                                            value="{{ $address->id }}" 
                                            data-name="{{ $address->name }}" 
                                            data-contact="{{ $address->contact }}" 
                                            data-address1="{{ $address->address_1 }}" 
                                            data-address2="{{ $address->address_2 }}" 
                                            data-city="{{ $address->city }}" 
                                            data-state="{{ $address->state->name }}" 
                                            data-pincode="{{ $address->pincode }}"
                                            {{ $address->id == old('address', $selectedAddressId ?? ($address->default ? $address->id : '')) ? 'selected' : '' }}
                                        >
                                            {{ $address->address_1 }}, {{ $address->address_2 }}, {{ $address->city }}, {{ $address->state->name }}-{{ $address->pincode }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
    
                            <!-- address Form Fields -->
                            <div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact" class="form-label">contact Number</label>
                                        <input type="tel" id="contact" name="contact" class="form-control" placeholder="+91 999-9999-999" value="{{ old('contact') }}">
                                        @error('contact')
                                            <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="address_1" class="form-label">Address 1</label>
                                    <input type="text" id="address_1" name="address_1" class="form-control" placeholder="House No" value="{{ old('address_1') }}">
                                    @error('address_1')
                                        <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address_2" class="form-label">Address 2</label>
                                    <input type="text" id="address_2" name="address_2" class="form-control" placeholder="123 Main Street" value="{{ old('address_2') }}">
                                    @error('address_2')
                                        <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" id="city" name="city" class="form-control" placeholder="City" value="{{ old('city') }}">
                                        @error('city')
                                            <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pincode" class="form-label">Pin Code</label>
                                        <input type="text" id="pincode" name="pincode" class="form-control" placeholder="123456" value="{{ old('pincode') }}">
                                        @error('pincode')
                                            <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="state" class="form-label">State</label>
                                        <select name="state" id="state" class="form-control bg-light">
                                            @foreach ($states as $state)
                                                <option value="{{ $state->name }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                            <div class="errors"><span class="text-danger">{{$message}}</span></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
    
                <!-- Order Summary -->
                <div class="col-lg-4">
                    @if ($cart_total > 0)
                        <div class="card p-4 mx-auto">
                            <h4 class="card-title mb-4">Order Summary ( {{$cart_total}} @if($cart_total >= 2)items @else item @endif)</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-muted">Total MRP</td>
                                        <td class="text-end">
                                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="total_mrp">{{ $total_mrp }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Discount on MRP</td>
                                        <td class="text-end text-success">
                                            <span class="fw-bold"> - <i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="discount_on_mrp">{{ $discount_on_mrp }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Coupon Discount</td>
                                        <td class="text-end text-success">
                                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="coupon_discount">0</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Platform Fee</td>
                                        <td class="text-end text-success">
                                            <span id="platform_fee">Free</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Shipping Fee</td>
                                        <td class="text-end text-success">
                                            <span id="shipping_fee">Free</span>
                                        </td>
                                    </tr>
                                    <tr id="fee_field" style="display: none">
                                        <td class="text-muted" id="fee_text"></td>
                                        <td class="text-end text-success">
                                            <span id="fee_value"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Total Amount</td>
                                        <td class="text-end fw-bold">
                                            <span class="fw-bold"><i class="fa-solid fa-indian-rupee-sign"></i></span>
                                            <span id="total_amount">{{ $total_amount }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
    
                            <!-- Choose payment method -->
    
                            <div class="card border-0">
                                <div class="list-group">
                                    <label class="list-group-item d-flex align-items-center p-3">
                                        <input class="form-check-input me-3 border-primary" type="radio" id="cod" name="payment_method" value="cod" style="width: 25px; height:25px">
                                        <div class="ms-2">
                                            <span class="fw-semibold">Cash on Delivery (COD)</span>
                                            <small class="d-block text-muted">Pay when you receive your order.</small>
                                        </div>
                                    </label>
                                    <label class="list-group-item d-flex align-items-center mb-3 p-3">
                                        <input class="form-check-input me-3 border-primary" type="radio" id="prepaid" name="payment_method" value="razorpay" style="width: 25px; height:25px">
                                        <div class="ms-2">
                                            <span class="fw-semibold">Razorpay </span>
                                            <small class="d-block text-muted">Pay securely using your credit card or UPI.</small>
                                        </div>
                                    </label>
                                    @error('payment_method')
                                        <div class="errors mb-3"><span class="text-danger">{{$message}}</span></div>
                                    @enderror
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Place Order</button>
                                </div>
                            </div>
                            
                        </div>
                    @endif
                </div>
            </div>
        </form>
    @endsection
