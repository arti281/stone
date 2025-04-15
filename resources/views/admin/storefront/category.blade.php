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
                        <a class="btn btn-primary fs-4 px-3" href="{{$add}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Category"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-9 col-md-9">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-list"></i> Category List</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"><input type="checkbox" class="form-check-input" name="" id=""></th>
                                    <th width="10%" height="50">Image</th>
                                    <th width="40%">Category Name</th>
                                    <th width="12">Top</th>
                                    <th width="12%">Sort</th>
                                    <th width="7%">Status</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input" name="" id=""></td>
                                        <td class="text-center p-1">
                                            <div class="bg-white p-1">
                                                <img height="50" width="50" src="{{ ($category->image) ? asset("image/category").'/'.($category->image) : asset('not-image-available.png')}}" alt="{{$category->category_name}}">
                                            </div>
                                        </td>
                                        <td>{{$category->full_path}}</td>
                                        <td>{{ $category->menu_top }}</td>
                                        <td>{{$category->sort_order }}</td>
                                        <td>@if($category->status) <p class="text-dark rounded p-1">Enabled</p> @else <p class="text-dark rounded p-1">Disabled</p> @endif</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('edit-category', ['category_id' => $category->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-danger deleteRow" href="javascript:void(0)" data-href="{{ route('delete-category', ['category_id' => $category->id]) }}" data-name="{{ $category->full_path }}" data-row-name="Category" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></a>                                        
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>

                        <!-- Pagination -->
                        @include('admin.common.pagination')

                    </div>
                </div>
                <div class="col-sm-3 col-md-3">
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-filter"></i> Filter</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <form id="product-filter-form" action="{{route('category')}}" method="get">
                            <div class="mb-3">
                                <label for="category_name" class="form-label fw-bold">Category Name</label>
                                <input type="text" class="form-control" name="category_name" value="{{ $category_name ?? '' }}" id="category_name" placeholder="Category Name">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
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
    //================ clear filter button ===================
    document.getElementById('clearFilter').addEventListener('click', () => {
        window.location.href = {!! json_encode($page_url) !!}
    })
</script>
@endsection