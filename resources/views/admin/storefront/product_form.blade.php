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
        <div class="col-sm-2 p-0 bg-left-sidebar">
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
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> Add Product</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="false">General</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="false">Data</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="price-tab" data-bs-toggle="tab" data-bs-target="#price" type="button" role="tab" aria-controls="price" aria-selected="false">Price</button>
                              </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button" role="tab" aria-controls="links" aria-selected="false">Links</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="attribute-tab" data-bs-toggle="tab" data-bs-target="#attribute" type="button" role="tab" aria-controls="attribute" aria-selected="false">Attribute</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="discount-tab" data-bs-toggle="tab" data-bs-target="#discount" type="button" role="tab" aria-controls="discount" aria-selected="false">Discount</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="special-tab" data-bs-toggle="tab" data-bs-target="#special" type="button" role="tab" aria-controls="special" aria-selected="false">Special</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reward-tab" data-bs-toggle="tab" data-bs-target="#reward" type="button" role="tab" aria-controls="reward" aria-selected="false">Reward Point</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image" type="button" role="tab" aria-controls="image" aria-selected="false">Image</button>
                            </li>
                            @isset(app('settings')['ecommerce_other_url_status'])
                                @if (app('settings')['ecommerce_other_url_status'])
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="other-link-tab" data-bs-toggle="tab" data-bs-target="#other-link" type="button" role="tab" aria-controls="other-link" aria-selected="false">Other Link</button>
                                    </li>  
                                @endif
                            @endisset
                        </ul>
                        <!-- Tab content -->
                        <form action="{{ $action }}" id="saveForm" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content" id="myTabContent">
                                <!-- General -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="mt-4">
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="product_name">Product Name</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" id="product_name" name="product_name" class="form-control p-2" value="{{ isset($product) ? $product['product']->product_name : old('product_name') }}" placeholder="Product Name">
                                            </div>
                                            <div class="errors">
                                                <span class="text-danger">
                                                    @error('product_name')
                                                        {{$message}}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="product_name">Product description</label>
                                            </div>
                                            <div class="col-10">
                                                <textarea id="summernote" name="description">{{ isset($product) ? $product['product']->product_description : old('description')  }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="meta_description">Meta description</label>
                                            </div>
                                            <div class="col-10">
                                                <textarea type="text" id="meta_description" name="meta_description" class="form-control p-2" rows="3">{{ isset($product) ? $product['product']->meta_description : old('meta_description') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="meta_tag_keyword">Meta Tag Keywords</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" id="meta_tag_keyword" name="meta_tag_keyword" class="form-control p-2" value="{{ isset($product) ? $product['product']->meta_keyword : old('meta_tag_keyword') }}" placeholder="Meta Tag Keyword">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="product_tag">Product Tags</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" id="product_tag" name="product_tag" class="form-control p-2" value="{{ isset($product) ? $product['product']->tag : old('product_tag') }}" placeholder="Product Tags">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Data -->
                                <div class="tab-pane fade show" id="data" role="tabpanel" aria-labelledby="data-tab">
                                    <div class="mt-4"></div>
                                    <!-- Model -->
                                    <section class="model">
                                        <h4>Model</h4><hr>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="model">Model</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" id="model" name="model" class="form-control p-2" value="{{ isset($product) ? $product['product']->model : old('model') }}" placeholder="Model">
                                            </div>
                                            <div class="errors">
                                                <span class="text-danger">
                                                    @error('model')
                                                        {{$message}}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- Stock -->
                                    <section class="stock">
                                        <h4>Stock</h4><hr>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="stock_quantity">Quantity</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" id="stock_quantity" name="quantity" class="form-control p-2" value="{{ isset($product) ? $product['product']->quantity : old('quantity') }}" placeholder="Quantity">
                                            </div>
                                            <div class="errors">
                                                <span class="text-danger">
                                                    @error('quantity')
                                                        {{$message}}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="minimum_quantity">Minimum Quantity</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" id="minimum_quantity" name="minimum_quantity" class="form-control p-2" value="{{ isset($product) ? $product['product']->minimum : old('minimum_quantity') }}" placeholder="Minimum Quantity">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="stock_subtract">Subtract Stock</label>
                                            </div>
                                            <div class="col-10 form-check form-switch">
                                                <input class="form-check-input fs-3 m-0" id="stock_subtract" name="stock_subtract_status" type="checkbox" role="switch">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="input-stock-status">Out Of Stock Status</label>
                                            </div>
                                            <div class="col-10">
                                                <select name="stock_status_id" id="input-stock-status" class="form-select">
                                                    @if (isset($stock_status) && $stock_status->count() > 0)
                                                        @foreach ($stock_status as $item)
                                                            <option value="{{ $item->id }}" @if(isset($product) && $item->id === ($product['product']->stock_status_id)) selected  @endif>{{ $item->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="date_available">Date Available</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="date" id="date_available" name="date_available" class="w-25 p-2" value="{{ isset($product) ? $product['product']->date_available : old('date_available') }}">
                                            </div>
                                        </div>
                                    </section>
                                    <!-- Specification -->
                                    <section class="stock">
                                        <h4>Specification</h4><hr>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="shipping">Requires Shipping</label>
                                            </div>
                                            <div class="col-10 form-check form-switch">
                                                <input class="form-check-input fs-3 m-0" id="shipping" name="shipping" type="checkbox" role="switch">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label>Dimensions (L x W x H)</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" name="length" class="col p-2" value="{{ old('length') ?? '0.0000' }}">
                                                <input type="text" name="width" class="col p-2" value="{{ old('width') ?? '0.0000' }}">
                                                <input type="text" name="height" class="col p-2" value="{{ old('height') ?? '0.0000' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="input-length-class">Length Class</label>
                                            </div>
                                            <div class="col-10">
                                                <select name="length_class_id" id="input-length-class" class="form-select">
                                                    <option value="1" selected="">Centimeter</option>
                                                    <option value="3">Inch</option>
                                                    <option value="2">Millimeter</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="weight">Weight</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" name="weight" id="weight" class="form-control col p-2" value="{{ old('weight') ?? '0.0000' }}">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="input-weight-class">Weight Class</label>
                                            </div>
                                            <div class="col-10">
                                                <select name="weight_class_id" id="input-weight-class" class="form-select">
                                                    <option value="2">Gram</option>
                                                    <option value="1" selected="">Kilogram</option>
                                                    <option value="6">Ounce</option>
                                                    <option value="5">Pound </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="status">Status</label>
                                            </div>
                                            <div class="col-10 form-check form-switch">
                                                <input type="hidden" name="status" value="0">
                                                <input class="form-check-input fs-3 m-0" id="status" name="status" type="checkbox" role="switch" value="1" @isset($product) ? @if($product['product']->status) checked @endif @endisset >
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-2 text-end">
                                                <label for="sort_order">Sort Order</label>
                                            </div>
                                            <div class="col-10">
                                                <input type="text" name="sort_order" id="sort_order" class="form-control col p-2" value="{{ old('sort_order') }}" placeholder="Sort order">
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <!-- Price -->
                                <div class="tab-pane fade show" id="price" role="tabpanel" aria-labelledby="price-tab">
                                    <div class="mt-4"></div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="retail_price">Price</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="retail_price" name="retail_price" class="form-control p-2" value="{{ isset($product) ? $product['product']->price :  old('retail_price') }}" placeholder="List Price">
                                        </div>
                                        <div class="errors">
                                            <span class="text-danger">
                                                @error('retail_price')
                                                    {{$message}}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="mrp">MRP</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="mrp" name="mrp" class="form-control p-2" value="{{ isset($product) ? $product['product']->mrp :  old('mrp') }}" placeholder="MRP">
                                        </div>
                                        <div class="errors">
                                            <span class="text-danger">
                                                @error('mrp')
                                                    {{$message}}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Links -->
                                <div class="tab-pane fade show" id="links" role="tabpanel" aria-labelledby="links-tab">
                                    <div class="mt-4"></div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="manufacturer">Manufacturer</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="manufacturer" name="manufacturer" class="form-control p-2" value="{{ old('manufacturer') }}" placeholder="Manufacturer">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label>Product set as a New</label>
                                        </div>
                                        <div class="col-10">
                                            Start Date <input type="date" name="start_date" class="w-25 me-5 p-2" value="{{ old('start_date') }}">
                                            CLose Date <input type="date" name="close_date" class="w-25 p-2" value="{{ old('close_date') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="category-dropdown">Categories</label>
                                        </div>
                                        <div class="col-10">
                                            <select id="category-dropdown" name="category_ids[]" class="multiple-select" multiple>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    @php
                                                        $isSelected = false;
                                                    @endphp

                                                    @if(isset($getProductCategory))
                                                    @foreach($getProductCategory as $productCategory)
                                                        @if($category->id == $productCategory->category_id)
                                                            @php
                                                                $isSelected = true;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    <option value="{{ $category->id }}" {{ $isSelected ? 'selected' : '' }}>
                                                        {{ $category->full_path }}
                                                    </option>
                                                @endforeach
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="filter">Filters</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="filter" name="filter" class="form-control p-2" value="{{ old('filter') }}" placeholder="filter">
                                            <div class="form-control mt-1" style="height: 150px; overflow: auto;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="download">Downloads</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="download" name="download" class="form-control p-2" value="{{ old('download') }}" placeholder="Downloads">
                                            <div class="form-control mt-1" style="height: 150px; overflow: auto;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="related_product">Related Products</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="related_product" name="related_product" class="form-control p-2" value="{{ old('related_product') }}" placeholder="Related Products">
                                            <div class="form-control mt-1" style="height: 150px; overflow: auto;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Attributes -->
                                <div class="tab-pane fade show" id="attribute" role="tabpanel" aria-labelledby="attribute-tab">
                                    <div class="mt-4"></div>
                                    <div class="col-sm-12 mb-4">
                                        <table class="table table-bordered table-hover center-align-table">
                                            <thead>
                                                <tr>
                                                    <th>Attribute</th>
                                                    <th>Text</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="product_attributes">
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add" onclick="addAttributesRow()"><i class="fa-solid fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- Discount -->
                                <div class="tab-pane fade show" id="discount" role="tabpanel" aria-labelledby="discount-tab">
                                    <div class="mt-4"></div>
                                    <div class="col-sm-12 mb-4">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Customer Group</th>
                                                    <th>Quantity</th>
                                                    <th>Priority</th>
                                                    <th>Price</th>
                                                    <th>Date Start</th>
                                                    <th>Date End</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="product_discount">
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add" onclick="addDiscountRow()"><i class="fa-solid fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- Special -->
                                <div class="tab-pane fade show" id="special" role="tabpanel" aria-labelledby="special-tab">
                                    <div class="mt-4"></div>
                                    <div class="col-sm-12 mb-4">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Customer Group</th>
                                                    <th>Priority</th>
                                                    <th>Price</th>
                                                    <th>Date Start</th>
                                                    <th>Date End</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="product_special">
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add" onclick="addSpecialtRow()"><i class="fa-solid fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- Reward Points -->
                                <div class="tab-pane fade show" id="reward" role="tabpanel" aria-labelledby="reward-tab">
                                    <div class="mt-4"></div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="reward_point">Reward Points</label>
                                        </div>
                                        <div class="col-10">
                                            <input type="text" id="reward_point" name="reward_point" class="form-control p-2" value="{{ old('reward_point') }}" placeholder="Reward Points">
                                        </div>
                                    </div>
                                </div>
                                <!-- Image -->
                                <div class="tab-pane fade show" id="image" role="tabpanel" aria-labelledby="image-tab">
                                    <div class="mt-4"></div>
                                    <div class="col-sm-12 mb-4">
                                        <h5>Product Image</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="col-sm-4 col-md-3">
                                                <div class="card p-2" style="width: 12rem">
                                                    <img src="{{ isset($product['product']->image) ? asset("image/cache/products").'/'.($product['product']->product_id .'/'. str_replace(".jpg",'',$product['product']->image) .'_300x300.jpg') : asset('not-image-available.png')}}" alt="Product Image" class="card-img-top" id="productReviewImage">
                                                    <input type="file" name="image" id="productImageUpload" accept="image/*" style="display: none;" onchange="productPreviewImage(event)">
                                                    <div class="card-body text-center mt-2"> 
                                                        <button type="button" class="btn btn-primary fs-5 px-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="productTriggerFileUpload()"><i class="fa-solid fa-pencil"></i></button>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="text-end">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove" onclick="productRemoveImageRow(this)"><i class="fa-solid fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <h5>Additional Images</h5>
                                        <table class="table table-bordered table-hover center-align-table">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Sort Order</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="product_images">
                                                @if (isset($product['images']))
                                                    @php $i = 0; @endphp
                                                    @foreach ($product['images'] as $image)
                                                        <tr>
                                                            <td>
                                                                <div class="col-sm-4 col-md-3">
                                                                    <div class="card p-2" style="width: 12rem">
                                                                        <img src="{{ isset($image->image) ? asset("image/cache/products").'/'.($image->product_id .'/'. str_replace(".jpg",'',$image->image) .'_300x300.jpg') : asset('not-image-available.png')}}" data-image-id="{{$image->id}}" alt="Product Image" class="card-img-top" id="imagePreview_{{$i}}">
                                                                        <input type="file" class="product_images" name="product_image[{{$i}}][image]" id="imageUpload_{{$i}}" accept="image/*" style="display: none;" onchange="previewImage(event, {{$i}})">
                                                                        <div class="card-body text-center mt-2"> 
                                                                            <button type="button" class="btn btn-primary fs-5 px-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="triggerFileUpload({{$i}})"><i class="fa-solid fa-pencil"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </td>
                                                            <td>
                                                                <input type="text" name="product_image_sort[{{$i}}][sort]" class="form-control p-2" placeholder="Sort Order" value="{{$image->sort}}">
                                                            </td>
                                                            <td class="text-end">
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove" onclick="removeImageRow(this)"><i class="fa-solid fa-minus"></i></button>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add" onclick="addImageRow()"><i class="fa-solid fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- Other Link -->
                                <div class="tab-pane fade show" id="other-link" role="tabpanel" aria-labelledby="other-link-tab">
                                    <div class="mt-4"></div>
                                    <h4>Other E-commerce URL</h4><hr>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="amazon_url">Amazon</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="amazon_url" name="amazon_url" class="form-control p-2" value="{{ isset($other_links->amazon) ? $other_links->amazon : old('amazon_url') }}" placeholder="Amazon">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="flipkart_url">Flipkart</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="flipkart_url" name="flipkart_url" class="form-control p-2" value="{{ isset($other_links->flipkart) ? $other_links->flipkart : old('flipkart_url') }}" placeholder="Flipkart">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="myntra_url">Myntra</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="myntra_url" name="myntra_url" class="form-control p-2" value="{{ isset($other_links->myntra) ? $other_links->myntra : old('myntra_url') }}" placeholder="Myntra">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="ajio_url">Ajio</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="ajio_url" name="ajio_url" class="form-control p-2" value="{{ isset($other_links->ajio) ? $other_links->ajio : old('ajio_url') }}" placeholder="Ajio">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="meesho_url">Meesho</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="meesho_url" name="meesho_url" class="form-control p-2" value="{{ isset($other_links->meesho) ? $other_links->meesho : old('meesho_url') }}" placeholder="Meesho">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-2 text-end">
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="col-10 form-check form-switch">
                                            <input class="form-check-input fs-3 ms-3" name="other_url_status" type="checkbox" {{ isset($other_links) && property_exists($other_links, 'status') ? (($other_links->status) ? 'checked': '') : old('status') }} role="switch" >
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
</section>

<script>

    // Form save 
    document.addEventListener("DOMContentLoaded", function() {
        let submitButton = document.getElementById("submitButton");
        let form = document.getElementById("saveForm");

        submitButton.addEventListener("click", function() {
            form.submit(); // This will submit the form when the button is clicked
        });
    });

    // Product attributes
    function addAttributesRow() {
        const table = document.getElementById('product_attributes');
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);

        row.innerHTML = `
            <tr>
                <td>
                    <input type="text" name="product_attribute[${rowCount}][name]" class="form-control" placeholder="Attribue Name">
                </td>
                <td>
                    <textarea name="product_attribute[${rowCount}][text]" class="form-control" id="" rows="3" placeholder="Text"></textarea>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove" onclick="removeAttributeRow(this)"><i class="fa-solid fa-minus"></i></button>
                </td>
            </tr>
        `;
    }

    function removeAttributeRow(button) {
        const row = button.closest('tr');
        row.remove();
    }

    // Product discount
    function addDiscountRow() {
        const table = document.getElementById('product_discount');
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);

        row.innerHTML = `
            <td>
                <select name="product_discount[${rowCount}][customer_group_id]" class="form-select">
                    <option value="0">Default</option>
                </select>
                <input type="hidden" class="form-control" name="product_discount[${rowCount}][product_discount_id]" value="">
            </td>
            <td>
                <input type="text" class="form-control" name="product_discount[${rowCount}][discount_quantity]" id="discount_quantity" placeholder="Quantity">
            </td>
            <td>
                <input type="text" class="form-control" name="product_discount[${rowCount}][priority]" placeholder="Priority">
            </td>
            <td>
                <input type="text" class="form-control" name="product_discount[${rowCount}][price]" placeholder="Price">
            </td>
            <td>
                <input type="date" class="form-control" name="product_discount[${rowCount}][start_date]">
            </td>
            <td>
                <input type="date" class="form-control" name="product_discount[${rowCount}][close_date]">
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-danger" onclick="removeDiscountRow(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove"><i class="fa-solid fa-minus"></i></button>
            </td>
        `;
    }

    function removeDiscountRow(button) {
        const row = button.closest('tr');
        row.remove();
    }

    // Product Special
    function addSpecialtRow() {
        const table = document.getElementById('product_special');
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);

        row.innerHTML = `
            <tr>
                <td>
                    <select name="product_special[${rowCount}][customer_group_id]" class="form-select">    
                        <option value="0">Default</option>  
                    </select>
                    <input type="hidden" class="form-control" name="product_special[${rowCount}][special_id]" value="">
                </td>
                <td>
                    <input type="text" class="form-control" name="product_special[${rowCount}][priority]" id="special_priority" placeholder="Priority">
                </td>
                <td>
                    <input type="text" class="form-control" name="product_special[${rowCount}][price]" id="special_price" placeholder="Price">
                </td>
                <td>
                    <input type="date" class="form-control" name="product_special[${rowCount}][start_date]" id="special_start_date">
                </td>
                <td>
                    <input type="date" class="form-control" name="product_special[${rowCount}][close_date]" id="special_close_date">
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove" onclick="removeSpecialRow(this)"><i class="fa-solid fa-minus"></i></button>
                </td>
            </tr>
        `;
    }

    function removeSpecialRow(button) {
        const row = button.closest('tr');
        row.remove();
    }


    // Additional images
    function addImageRow() {
    const table = document.getElementById('product_images');
    const rowCount = table.rows.length;
    const row = table.insertRow(rowCount);

    row.innerHTML = `
        <tr>
            <td>
                <div class="col-sm-4 col-md-3">
                    <div class="card p-2" style="width: 12rem">
                        <img src="{{ asset('not-image-available.png')}}" alt="Product Image" class="card-img-top" id="imagePreview_${rowCount}">
                        <input type="file" name="product_image[${rowCount}][image]" id="imageUpload_${rowCount}" accept="image/*" style="display: none;" onchange="previewImage(event, ${rowCount})">
                        <div class="card-body text-center mt-2"> 
                            <button type="button" class="btn btn-primary fs-5 px-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="triggerFileUpload(${rowCount})"><i class="fa-solid fa-pencil"></i></button>
                        </div>
                    </div>
                </div> 
            </td>
            <td>
                <input type="text" name="product_image_sort[${rowCount}][sort]" class="form-control p-2" placeholder="Sort Order">
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove" onclick="removeImageRow(this)"><i class="fa-solid fa-minus"></i></button>
            </td>
        </tr>
    `;

    // Reinitialize tooltips for the new row
    // document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
}

function previewImage(event, index) {
    const input = event.target;
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById(`imagePreview_${index}`);
            img.src = e.target.result;

            // create image id element
            let dataImageId = img.getAttribute('data-image-id');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.value = dataImageId
            input.name = `product_image_id[${index}][image_id]`;
            img.insertAdjacentElement('afterend', input);
        }
        reader.readAsDataURL(file);
    }
}

function triggerFileUpload(index) {
    document.getElementById(`imageUpload_${index}`).click();
}


function removeImageRow(button) {
    const row = button.closest('tr');
    row.remove();
}

// Product Image
function productPreviewImage(event) {
    const input = event.target;
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('productReviewImage');
            img.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

function productTriggerFileUpload(index) {
    document.getElementById('productImageUpload').click();
}

function productRemoveImageRow(button) {
    document.getElementById('productImageUpload').value = '';
    document.getElementById(`productReviewImage`).src = "{{ asset('not-image-available.png')}}";
}
// end product image

</script>
@endsection