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
                        <a class="btn btn-primary fs-4 px-3" href="{{$add}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Color"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-12 col-md-12">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-list"></i> Color List</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="10%" class="text-center"><input type="checkbox" class="form-check-input" name="" id=""></th>
                                    <th width="20%" height="50">Color Name</th>
                                    <th width="20%">Hex Code</th>
                                    <th width="20%">Sort</th>
                                    <th width="30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colors as $color)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input" name="" id=""></td>
                                        <td>{{$color->color_name}}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-3 rounded-circle border" style="width:20px; height:20px;display: inline-block; background-color: {{$color->code}}"></span>
                                                <span> {{$color->code}} </span>
                                            </div>
                                        </td>
                                        <td>{{$color->sort}}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('edit-color', ['color_id' => $color->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-danger deleteColor" data-href="{{ route('delete-color', ['color_id' => $color->id]) }}" data-color-name="{{$color->color_name}}" data-color-id data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // confirm box
        let deleteButton = document.querySelectorAll('.deleteColor');
        deleteButton.forEach(element => {
            element.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default action
                let url = element.getAttribute('data-href')
                let name = element.getAttribute('data-color-name')
                Swal.fire({
                    title: 'Are you sure?',
                    html: 'Do you want delete this Color.' + '<br><strong>'+name+'</strong>' ,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the deletion URL
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</section>
@endsection