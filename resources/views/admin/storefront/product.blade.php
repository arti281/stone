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
                        <a class="btn btn-primary fs-4 px-3" href="{{$add}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Product"><i class="fa-solid fa-plus"></i></a>
                        <a class="btn btn-danger fs-4 px-3" data-name="Selected Products" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Product" id="multi-selection-delete-button"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-9 col-md-9">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-list"></i> Product List</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"><input type="checkbox" class="form-check-input" name="" id="multiselections"></th>
                                    <th width="10%">Image</th>
                                    <th width="30%">Product Name</th>
                                    {{-- <th width="5%">Model</th> --}}
                                    <th width="12%">Price</th>
                                    <th width="12%">Quantity</th>
                                    <th width="11%">Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input selectBox" name="" data-product-id="{{$product->product_id}}"></td>
                                        <td class="text-center p-1">
                                            <div class="bg-white p-1">
                                                <img height="50" src="{{ ($product->image) ? asset("image/cache/products").'/'.($product->product_id .'/'. str_replace(".jpg",'',$product->image) .'_100x100.jpg') : asset('not-image-available.png')}}" alt="{{$product->product_name}}">
                                            </div>
                                        </td>
                                        <td>{{$product->product_name}}</td>
                                        {{-- <td>{{$product->model}}</td> --}}
                                        <td>Rs.{{ number_format($product->price,2) }}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td> @if($product->status) <p class="text-success">Enabled</p> @else <p>Disabled</p> @endif </td>
                                        <td>
                                            <a class="btn btn-primary mb-1" href="{{ route('admin-product-edit', ['product_id' => $product->product_id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                            <button type="button" class="btn btn-primary mb-1 addVariation" data-product-id="{{ $product->product_id }}" data-bs-toggle="modal" data-bs-target="#addVariation">
                                                <span class="b-block" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Variation"><i class="fa-solid fa-list"></i></span>
                                            </button>
                                            <a class="btn btn-danger deleteRow" href="javascript:void(0)" data-href="{{ route('admin-product-delete', ['product_id' => $product->product_id]) }}" data-name="{{$product->product_name}}" data-row-name="Product" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>

                        <!-- Add variation -->
                        <div class="modal fade" id="addVariation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVariationLabel" aria-hidden="true">
                            <div class="modal-dialog" style="max-width: 1100px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addVariationLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ $product_variation_route }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" id="product_id">
                                        <div class="col-sm-12 mb-4">
                                            <div class="row">
                                                <div class="col-sm-5 mb-4">
                                                    <div class="row mb-4">
                                                        <div class="col-2 text-end">
                                                            <label for="color">Color</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <select id="color" class="form-control">
                                                                <option value="">Select color</option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->id }}">{{ $color->color_name }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> 
                                                    <div class="row mb-4">
                                                        <div class="col-2 text-end">
                                                            <label for="size">Size</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <select id="size" class="form-control">
                                                                <option value="">Select Size</option>
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-2 text-end">
                                                            <label for="variation_qty">Quantity</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="number" id="variation_qty" name="variation_qty" class="form-control" value="" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-2 text-end">
                                                            <label for="variation_price">Price</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="number" id="variation_price" name="variation_price" class="form-control" value="" placeholder="Price">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-2 text-end">
                                                            <label for="variation_sku">SKU</label>
                                                        </div>
                                                        <div class="col-10">
                                                            <input type="text" id="variation_sku" name="variation_sku" class="form-control" value="" placeholder="SKU">
                                                        </div>
                                                    </div> 
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-outline-success" id="addVariationBtn">Add Variation</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="text-start">
                                                        <div class="text-start" id="variationsSection">
                                                            <h5>Variations</h5>
                                                            <table class="table table-bordered">
                                                                <tr>
                                                                    <th>Sr.</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th>Combination</th>
                                                                    <th>SKU</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                <tbody id="variationsList">
                                                                   
                                                                </tbody>
                                                                <caption class="text-center fs-4" id="variation_not_available"></caption>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="saveVariation">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @include('admin.common.pagination')

                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-filter"></i> Filter</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <form id="product-filter-form" action="{{route('admin-storefront-product')}}" method="get">
                            {{-- @csrf --}}
                            <div class="mb-3">
                                <label for="product_name" class="form-label fw-bold">Product Name</label>
                                <input type="text" class="form-control" name="product_name" value="{{ $product_name ?? '' }}" id="product_name" placeholder="Product Name">
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label fw-bold">Model</label>
                                <input type="text" class="form-control" name="model" id="model" value="{{ $model ?? '' }}" placeholder="Model">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Price</label>
                                <input type="text" class="form-control" name="price" id="price" value="{{ $price ?? '' }}" placeholder="Price">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label fw-bold">Quantity</label>
                                <input type="text" class="form-control" name="quantity" id="quantity" value="{{ $quantity ?? '' }}" placeholder="Quantity">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if($status == 1) selected @endif>Enable</option>
                                    <option value="0" @if($status == 0) selected @endif>Disable</option>
                                </select>
                            </div>
                            <div class="mb-3 text-end">
                                <input id="filter-button"  type="submit" class="btn btn-primary" value="Filter">
                                <button type="button" class="btn btn-warning" id="clearFilter">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // JavaScript to handle form submission
    document.getElementById('product-filter-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Collect form data
        const form = event.target;
        const formData = new FormData(form);

        const queryParams = [];
        formData.forEach((value, key) => {
            if (value.trim() !== '') { // Check if value is not empty or only whitespace
                queryParams.push(`${key}=${encodeURIComponent(value)}`);
            }
        });

        // Construct URL with query parameters
        const actionUrl = form.getAttribute('action');
        const urlWithParams = actionUrl + '?' + queryParams.join('&');

        // Redirect to the constructed URL
        window.location.href = urlWithParams;
    });

        //================ clear filter button ===================
        document.getElementById('clearFilter').addEventListener('click', () => {
            window.location.href = {!! json_encode($page_url) !!}
        })

    // start variation

    // model
    document.querySelectorAll('.addVariation').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            document.getElementById('product_id').value = productId;
            getVariations(productId);
        });
    });
    // show
    function getVariations(product_id){
        let count = 0;
        $.ajax({
            url: '/admin/storefront/product-get-variation/' + product_id,
            type: 'GET',
            success: function(response) {
                const variationsSection = document.getElementById('variationsSection');
                const variationsList = document.getElementById('variationsList');
                variationsList.innerHTML = '';
                if(response.success){
                    response.variationData.forEach(data => {   
                        console  
                        // Create a new table row for the variation
                        let row = document.createElement('tr');
    
                        count += 1; // Increment counter
    
                        row.innerHTML = `
                            <td>${count}</td>
                            <td>
                                <input type="hidden" name="variation_qty[]" value="${data['quantity']}">
                                <span>${data['quantity']}</span>
                            </td>
                            <td>
                                <input type="hidden" name="variation_price[]" value="${data['price']}">
                                <span><i class="fa-solid fa-indian-rupee-sign"></i> ${data['price']}</span>    
                            </td>
                            <td>
                                <input type="hidden" name="color_id[]" value="${data['color_id']}">
                                <input type="hidden" name="size_id[]" value="${data['size_id']}">
                                <input type="hidden" name="combinations[]" value="${data['color_id']}_${data['size_id']}">
                                <span>${data['color_name']}_${data['size_name']}</span> 
                            </td>
                            <td>
                                <input type="hidden" name="variation_sku[]" value="${data['sku']}">
                                <span>${data['sku']}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeVariation(this)">Remove</button>
                            </td>
                        `;
    
                        variationsList.appendChild(row);
                        document.getElementById('variation_not_available').innerHTML = '';
                        document.getElementById('saveVariation').removeAttribute('disabled');
                    });
                }else{
                    document.getElementById('saveVariation').setAttribute('disabled', true);
                    document.getElementById('variation_not_available').innerHTML = response.error
                }                    
            },

            error: function(xhr) {
                console.log(xhr.responseText); // Output any error messages
            }
        });
    }

    // add variation
    document.getElementById('addVariationBtn').addEventListener('click', function() {
        let count = 0;
        const colorSelect = document.getElementById('color');
        const sizeSelect = document.getElementById('size');
        const variationQty = document.getElementById('variation_qty').value;
        const variationPrice = document.getElementById('variation_price').value;
        const variationSku = document.getElementById('variation_sku').value;

        const colorId = colorSelect.value;
        const colorName = colorSelect.options[colorSelect.selectedIndex].text;

        const sizeId = sizeSelect.value;
        const sizeName = sizeSelect.options[sizeSelect.selectedIndex].text;

        if (colorId && sizeId && variationQty && variationSku) {
            const variationsSection = document.getElementById('variationsSection');
            const variationsList = document.getElementById('variationsList');

            // Create a new table row for the variation
            const row = document.createElement('tr');

            count += 1; // Increment counter

            row.innerHTML = `
                <td>${count}</td>
                <td>
                    <input type="hidden" name="variation_qty[]" value="${variationQty}">
                    <span>${variationQty}</span>
                </td>
                <td>
                    <input type="hidden" name="variation_price[]" value="${variationPrice}">
                    <span><i class="fa-solid fa-indian-rupee-sign"></i> ${variationPrice}</span>    
                </td>
                <td>
                    <input type="hidden" name="color_id[]" value="${colorId}">
                    <input type="hidden" name="size_id[]" value="${sizeId}">
                    <input type="hidden" name="combinations[]" value="${colorId}_${sizeId}">
                    <span>${colorName}_${sizeName}</span>    
                    </td>
                <td>
                    <input type="hidden" name="variation_sku[]" value="${variationSku}">
                    <span>${variationSku}</span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeVariation(this)">Remove</button>
                </td>
            `;

            variationsList.appendChild(row);
            document.getElementById('variation_not_available').innerHTML = '';
            document.getElementById('saveVariation').removeAttribute('disabled');

            // Optionally, clear the selection
            colorSelect.value = '';
            sizeSelect.value = '';
        } else {
            alert('All filled are required');
        }
    });

    function removeVariation(button) {
        const row = button.closest('tr');
        row.remove();

        // Decrement the counter and update the remaining rows
        count -= 1;
        updateRowNumbers();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('#variationsList tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
        });
    }

    // end variation

    // ======================== multi selections ================================
    let productList = [];
    const multiSelection = document.getElementById('multiselections');
    const selectBox = document.querySelectorAll('.selectBox');

    multiSelection.addEventListener('click', () => {
        productList = [];
        
        selectBox.forEach(element => {
            let productId = element.getAttribute('data-product-id')
            if(productId){
                if(multiSelection.checked){
                    productList.push(productId)
                    element.checked = true
                }else{
                    productList.pop(productId)
                    element.checked = false
                }
            }
        }); 
    })

    selectBox.forEach(element => {
        productList = [];
        element.addEventListener('click', () => {
            let productId = element.getAttribute('data-product-id')
            if(productId){
                if(element.checked){
                    productList.push(productId)
                    element.checked = true
                }else{
                    productList.pop(productId)
                    element.checked = false
                }
            }

            // unchecked multiselection when rest product
            if(selectBox.length !== productList.length){
                multiSelection.checked = false
            }else{
                multiSelection.checked = true
            }
        })
    }); 

    // for multiselection confirm box
    document.getElementById('multi-selection-delete-button').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default action
        let name = document.getElementById('multi-selection-delete-button').getAttribute('data-name')
        if(productList.length < 1){
            dataName = "<span style='color:red'>You must select a product to delete</span>"
        }else{
            dataName = `<span>Do you want delete this ${name}</span>`
        }
        Swal.fire({
            title: 'Are you sure?',
            html: dataName ,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/storefront/deleteMultiSelection',
                    method : 'post',
                    data: {
                        'productList' : productList,
                        '_token': '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: 'Success',
                                html: response.message ,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                window.location.href = {!! json_encode($page_url) !!};
                            });
                        }
                    }
                })
            }
        });
    });


    // ========================= End multi selection =======================
</script>
@endsection