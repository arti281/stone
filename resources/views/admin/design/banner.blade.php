@extends('admin.common.base')

@push('setTitle')
    Dashboard
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
                            <button id="add_banner" class="btn btn-primary fs-5 px-3" type="button" data-bs-toggle="modal"data-bs-target="#bannerModal"><i class="fa-solid fa-plus" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Banner"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row g-3 px-4">
                    <div class="col-md-12">
                        <!-- Alert Message -->
                        @include('admin.common.alert')

                        <div class="alert alert-success alert-dismissible fade show" id="error_display" role="alert" style="display: none">
                            <span id="error"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <div class="card rounded-0 p-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="20%">Title</th>
                                        <th width="20%">Image</th>
                                        <th width="20%">Sort</th>
                                        <th width="20%">Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="showAllBanner">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="false">
            <div class="modal-dialog" style="max-width: 800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="bannerModalLabel">Banner</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin-banner') }}" id="myForm" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="banner_id" id="banner_id">
                            @csrf
                            <div class="mt-4">
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="title">Title</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="title" name="title" class="form-control p-2"
                                            placeholder="Enter title">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="description">Description</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="description" name="description" class="form-control p-2"
                                            placeholder="Enter description">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="button_text">Button Text</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="button_text" name="button_text" class="form-control p-2"
                                            placeholder="Enter button text">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="button_url">Button URL</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="button_url" name="button_url" class="form-control p-2"
                                            placeholder="Enter button URL">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="image">Image</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="file" id="image" name="image" class="form-control p-2">

                                        <img class="mt-3" id="banner_image" width="100" height="100" src="{{asset('not-image-available.png')}}" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="sort">Sort</label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="sort" name="sort" value="0" class="form-control p-2"
                                            placeholder="Enter sorting">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2 text-center">
                                        <label for="status">Status</label>
                                    </div>
                                    <div class="col-10">
                                        <select name="status" id="status" class="form-control p-2">
                                            <option value="1">Enabled</option>
                                            <option value="0">Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            //Get Banner
            function getBanner(){
                $.ajax({
                    url: '/admin/banner/getallbanner',
                    type: 'GET',
                    success: function(response) {
                        let html = '';
                        response.forEach(element => {                            
                            html += '<tr>';
                            html += '<td>' + element.title + '</td>';
                            html += '<td>';
                            if (element.image) {
                                html += '<img width="100" height="100" src="{{ asset("image/banner/") }}/'+ element.image +'">';
                            } else {
                                html += '<img class="mt-3" width="100" height="100" src="{{ asset("image/not-available.png") }}">';
                            }
                            html += '</td>';
                            html += '<td>' + element.sort + '</td>';
                            html += '<td>' + element.status + '</td>';
                            html += '<td>';
                            html += '<button class="btn btn-primary banner_update me-3" id="add_banner" data-bs-toggle="modal" data-bs-target="#bannerModal" data-banner-id="' + element.id + '"><i class="fa-regular fa-pen-to-square"></i></button>';
                            html += '<button class="btn btn-danger banner_delete" data-banner-id="' + element.id + '"><i class="fa-solid fa-trash"></i></button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        document.getElementById('showAllBanner').innerHTML = html;
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText); // Output any error messages
                    }
                });
            }
            getBanner();


            // update banner
           setTimeout(() => {
            const bannerButtons = document.querySelectorAll('.banner_update');
            bannerButtons.forEach(element => {     
                element.addEventListener('click', () => {
                    let banner_id = element.getAttribute('data-banner-id');
                    $.ajax({
                        url: '/admin/banner/' + banner_id,
                        type: 'GET',
                        success: function(response) {
                            document.getElementById('banner_id').value = response.id;
                            document.getElementById('title').value = response.title;
                            document.getElementById('description').value = response.description;
                            document.getElementById('button_text').value = response.button_text;
                            document.getElementById('button_url').value = response.button_url;
                            document.getElementById('banner_image').src = "{{ asset('image/banner/') }}" + '/'+ response.image;;
                            document.getElementById('sort').value = response.sort;
                            document.getElementById('status').value = response.status;
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Output any error messages
                        }
                    });
                })
            });
           }, 1000);

            // delete banner
            setTimeout(() => {
                const bannerButtonsDelete = document.querySelectorAll('.banner_delete');
                bannerButtonsDelete.forEach(element => {     
                    element.addEventListener('click', () => {
                        if (confirm("Are you sure you want to delete this banner?")) {
                            let banner_id = element.getAttribute('data-banner-id');
                            $.ajax({
                                url: '/admin/banner/delete/' + banner_id,
                                type: 'get',
                                success: function(response) {
                                    document.getElementById('error_display').style.display = "block"
                                    document.getElementById('error').innerText = response.success;
                                    getBanner();
                                },
                                error: function(xhr) {
                                    console.log(xhr.responseText); // Output any error messages
                                }
                            });
                        }
                    })
                });
            }, 1000);
        </script>
    </section>
@endsection
