@extends('catalog.common.base')

@push('setTitle')
    Address
@endpush

@section('content')

<section class="container-fluid py-5">
    <div class="row g-4">
        <div class="col-12 col-lg-10">
            <div class="col-12">
                <div class="card shadow">
                     <div class="card-body">
                         <h2 class="text-center mb-4"><i class="fa-solid fa-address-book"></i> Address</h2>
                         <!-- alert message -->
                         @include('catalog.common.alert')
         
                         <div class="text-end mb-3">
                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="resetAddressForm()" data-bs-target="#addAddress"><i class="fa-solid fa-plus"></i> Add New Address</button>
                         </div> 
         
                         <!-- Address Display -->
                         <div class="row">
                             @foreach ($addresses as $address)
                                 <div class="col-sm-6 col-md-3">
                                     <div class="card shadow-sm mb-3">
                                         <div class="card-body">
                                             <div class="d-flex justify-content-between">
                                                 <h2 class="fs-6 fw-bold">{{ $address->name }}</h2>
                                                 <div class="form-check">
                                                     <form action="{{ $action .'/'.$address->id }}" method="POST" id="defaultAddressForm-{{ $address->id }}">
                                                         @csrf
                                                         @method('PUT')
                                                         <input class="form-check-input" type="radio" name="default" 
                                                             @if ($address->default) @checked(true) @endif
                                                             onclick="document.getElementById('defaultAddressForm-{{ $address->id }}').submit();">
                                                     </form>
                                                 </div>
                                             </div>
                                             <p class="fs-6">{{$address->address_1}}, {{$address->address_2}}, {{$address->city}}, {{$address->state->name}}, {{$address->country->name}} - {{$address->pincode}}</p>
                                             <div class="d-flex justify-content-start">
                                                 <button class="badge btn btn-primary me-2 fs-6" onclick="updateAddress({{$address->id}})" data-bs-toggle="modal" data-bs-target="#addAddress"><i class="fa-solid fa-edit"></i></button>
                                                 <form action="{{ $action .'/'.$address->id }}" method="POST">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="badge btn btn-danger fs-6"><i class="fa-solid fa-trash"></i></button>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach    
                         </div>
         
                         <!-- Modal -->
                         <div class="modal fade" id="addAddress" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
                             <div class="modal-dialog" style="max-width: 1100px">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h1 class="modal-title fs-5" id="addAddressLabel">Add New Address</h1>
                                         <button type="button" class="btn-close" onclick="closeBtn()" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <form action="{{$action}}" id="address" method="POST">
                                             @csrf
                                             <div class="row">
                                                 <div class="col-6 mb-4">
                                                     <label for="name" class="form-label"><strong>Name</strong></label>
                                                     <input type="text" class="form-control bg-light" id="name" name="name" value="{{ session('user_name') }}" placeholder="New name">
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('name')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                             
                                                 <div class="col-6 mb-4">
                                                     <label for="contact" class="form-label"><strong>Contact</strong></label>
                                                     <input type="text" class="form-control bg-light" id="contact" name="contact" value="{{ $user_number }}" placeholder="Contact">
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('contact')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                             
                                                 <div class="col-6 mb-4">
                                                     <label for="address_1" class="form-label"><strong>Address1</strong></label>
                                                     <input type="text" class="form-control bg-light" id="address_1" name="address_1" placeholder="Address 1">
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('address_1')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                             
                                                 <div class="col-6 mb-4">
                                                     <label for="address_2" class="form-label"><strong>Address 2</strong></label>
                                                     <input type="text" class="form-control bg-light" id="address_2" name="address_2" placeholder="Address 2">
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('address_2')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                             
                                                 <div class="col-6 mb-4">
                                                     <label for="city" class="form-label"><strong>City</strong></label>
                                                     <input type="text" class="form-control bg-light" id="city" name="city" placeholder="city">
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('city')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                             
                                                 <div class="col-6 mb-4">
                                                     <label for="pincode" class="form-label"><strong>Pin Code</strong></label>
                                                     <input type="number" class="form-control bg-light" id="pincode" name="pincode" placeholder="pincode">
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('pincode')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                         
                                                 <div class="col-6 mb-4">
                                                     <label for="state_id" class="form-label"><strong>State</strong></label>
                                                     <select name="state_id" id="state_id" class="form-control bg-light">
                                                         @foreach ($states as $state)
                                                             <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                         @endforeach
                                                     </select>
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('state_id')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                         
                                                 <div class="col-6 mb-4">
                                                     <label for="country_id" class="form-label"><strong>Country</strong></label>
                                                     <select name="country_id" id="country_id" class="form-control bg-light">
                                                         @foreach ($countries as $country)
                                                             <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                         @endforeach
                                                     </select>
                                                     <div class="errors">
                                                         <span class="text-danger">
                                                             @error('country_id')
                                                             {{$message}}
                                                             @enderror
                                                         </span>
                                                     </div>
                                                 </div>
                         
                                             </div>
                         
                                             <!-- Submit Button -->
                                             <div class="text-center">
                                                 <button class="btn btn-dark btn-lg px-5 py-2" onclick="onSubmut()" type="submit">Submit</button>
                                             </div>
                                         </form> 
                                     </div>
                                 </div>
                             </div>
                         </div>
                         
                     </div>
                </div>
             </div>
        </div>
        <div class="col-lg-2">
            @include('catalog.common.right-navbar')
        </div>
    </div>
</section>

<script>
    // Show the modal if the session has the 'show_modal' flag
    @if ($errors->any())
        let myModal = document.getElementById('addAddress');
        myModal.classList.add('show');
        myModal.style.display = "block"
        myModal.style.backgroundColor = "#00000085"
    @endif

    function closeBtn(){
        let myModal = document.getElementById('addAddress');
        myModal.classList.remove('show');
        myModal.style.display = "none"
        document.querySelectorAll('.errors').forEach(element => element.remove());
    }

    // Show data for update
    function updateAddress(address_id) {
        let action = {!! json_encode(route('catalog.address')) !!} + '/' + address_id

        $.ajax({
            url: action,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    document.getElementById('name').value = response.address.name
                    document.getElementById('contact').value = response.address.contact
                    document.getElementById('address_1').value = response.address.address_1
                    document.getElementById('address_2').value = response.address.address_2
                    document.getElementById('city').value = response.address.city
                    document.getElementById('pincode').value = response.address.pincode
                    document.getElementById('state_id').value = response.address.state_id
                    document.getElementById('country_id').value = response.address.country_id
                    document.getElementById('addAddressLabel').textContent = "Update Address"

                    document.getElementById('address').setAttribute('action', action)

                    document.querySelectorAll('.errors').forEach(element => element.remove());
                    
                    const hiddenInput = document.getElementById('address');
                    const newElement = document.createElement('input');
                    newElement.type = 'hidden';
                    newElement.name = '_method';
                    newElement.value = 'PUT';
                    newElement.id = 'PutMethod'
                    hiddenInput.insertAdjacentElement('beforeend', newElement);

                    const update_mode = document.createElement('input');
                    update_mode.type = 'hidden';
                    update_mode.name = 'update_mode';
                    update_mode.value = response.update_mode;
                    hiddenInput.insertAdjacentElement('beforeend', update_mode);
                }
            },
            error: function(xhr, status, error) {
                showFlashMessage(error)
            }
        });
    }

    // reset form data
    function resetAddressForm(){
        document.getElementById('name').value = {!! json_encode(session('user_name')) !!};
        document.getElementById('contact').value = {!! json_encode($user_number) !!};
        document.getElementById('address_1').value = ""; 
        document.getElementById('address_2').value = ""; 
        document.getElementById('city').value = ""; 
        document.getElementById('pincode').value = ""; 
        document.getElementById('address').setAttribute('action', {!! json_encode(route('catalog.address')) !!})
        document.getElementById('addAddressLabel').textContent = "Add New Address"

        const methodInput = document.getElementById('PutMethod');
        if (methodInput) {
            methodInput.remove();
        }
    }
</script>

@endsection