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
                    <!-- image manager header -->
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
                            <a class="btn btn-danger fs-5 px-3 delete_files" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></a>
                            <button id="image_manager" class="btn btn-primary fs-5 px-3" type="button" data-bs-toggle="modal"data-bs-target="#imageModal"><i class="fa-solid fa-upload" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Image Upload"></i></button>
                        </div>
                    </div>
                    <!-- Show all images  -->
                    <div class="col-sm-12">
                        <div class="row g-4 mt-3" id="show_all_images">
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageManagerModal" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 60rem">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="imageManagerModal">Image Manager</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div>
                                            <a class="btn btn-outline-primary" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Parent"><i class="fa-solid fa-level-up-alt"></i></a>
                                            <button class="btn btn-outline-primary" id="refresh" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Refresh"><i class="fa-solid fa-rotate"></i></button>
                                            <button class="btn btn-primary" id="button-upload" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Image Upload"><i class="fa-solid fa-upload"></i></button>
                                            <input type="file" id="file-input" style="display: none;" multiple>
                                            <a class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="New Folder" onclick="openFolderBox()"><i class="fa-solid fa-folder"></i></a>
                                            <a class="btn btn-danger delete_files" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="text" name="search" value="" placeholder="Search.." id="input-search" class="form-control">
                                            <button type="button" id="button-search" data-bs-toggle="tooltip" title="Search" class="btn btn-primary px-3"><i class="fa-solid fa-search"></i></button>
                                        </div>
                                    </div>
                                </div><hr>
                                <!-- Craete folder -->
                                <div class="mb-3" id="create_folder" style="display: none">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" name="new_folder_box" value="" placeholder="Create New Folder" id="new_folder_box" class="form-control">
                                            <button type="button" id="new_folder_btn" data-bs-toggle="tooltip" title="Create New Folder" class="btn btn-primary px-3"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4" id="getAllproducts"></div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>

        // show all files and folders
        document.addEventListener('DOMContentLoaded', function() {
            showAllImages();
        }, false);

        // show all files and folders on the modal
        document.getElementById('image_manager').addEventListener('click', function() {
            getFiles();
        });

        document.getElementById('file-input').addEventListener('change', function() {
            uploadFiles(this.files)
        });

        document.getElementById('refresh').addEventListener('click', function() {
            getFiles();
        });

        document.getElementById('button-upload').addEventListener('click', function() {
            document.getElementById('file-input').click();
        });


        function uploadFiles(files) {
            let formData = new FormData();
            // Append each file to FormData
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }
            // Append CSRF token
            formData.append('_token', '{{ csrf_token() }}');
            // Use jQuery AJAX to send FormData to Laravel endpoint
            $.ajax({
                url: "/admin/media/uploadFile",
                type: "POST",
                data: formData,
                contentType: false, // Don't set contentType
                processData: false, // Don't process data
                success: function (response) {
                    alert('Files uploaded successfully')
                    getFiles()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // console.error(textStatus, errorThrown); // Handle errors
                    alert('Files uploaded Failed')
                }
            });
        }

        function getFiles(){
            let getAllproducts = document.getElementById('getAllproducts');
            $.ajax({
                url: "/admin/media/getFiles",
                type: "get",
                success: function (response) {
                    getAllproducts.innerHTML = '';
                    if(response.folders){
                        let files = response.folders;
                        files.forEach(element => {
                            let html = '';
                                html += '<div class="col-sm-4 col-md-3">';
                                html += '<div class="p-2" style="min-height:150px;display: flex;justify-content: center;overflow:hidden">';
                                html += '<a class="text-decoration-none" href="'+element.href+'"><i class="fa-solid fa-folder" style="font-size:8rem"></i>';
                                html += '<p class="mb-0 text-dark d-flex mt-2"><input class="me-2 form-check-input media_checkbox" type="checkbox" data-name="'+ element.text +'">'+ element.text +'</p>';
                                html += '</a>';              
                                html += '</div>';
                                html += '</div>';
                            getAllproducts.innerHTML += html;
                       });
                    }
                    if(response.files){
                        let files = response.files;
                        files.forEach(element => {
                            let html = '';
                                html += '<div class="col-sm-4 col-md-3">';
                                html += '<div class="card p-2" style="min-height:150px;display: flex;justify-content: center;overflow:hidden">';
                                html += '<a class="text-decoration-none" href="'+element.href+'">';
                                html += '<img src="'+element.href+'" alt="'+element.text+'" class="card-img-top" style="height:150px;vertical-align: middle;">';
                                html += '<p class="mb-0 text-dark d-flex mt-2"><input class="me-2 form-check-input media_checkbox" type="checkbox" data-name="'+ element.text +'">'+ element.text +'</p>';
                                html += '</a>';              
                                html += '</div>';
                                html += '</div>';
                            getAllproducts.innerHTML += html;
                       });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown); // Handle errors
                }
            });
        }

        function showAllImages(){
            let show_all_images = document.getElementById('show_all_images');
            $.ajax({
                url: "/admin/media/getFiles",
                type: "get",
                success: function (response) {
                    show_all_images.innerHTML = '';
                    if(response.folders){
                        let files = response.folders;
                        files.forEach(element => {
                            let html = '';
                                html += '<div class="col-sm-3 col-md-2">';
                                html += '<div class="p-2" style="min-height:150px;display: flex;justify-content: center;overflow:hidden">';
                                html += '<a class="text-decoration-none open_folder" href="'+element.href+'" data-text="'+element.text+'"><i class="fa-solid fa-folder" style="font-size:8rem"></i>';
                                html += '<p class="mb-0 text-dark d-flex mt-2"><input class="me-2 form-check-input media_checkbox" type="checkbox" data-name="'+ element.text +'">'+ element.text +'</p>';
                                html += '</a>';              
                                html += '</div>';
                                html += '</div>';
                            show_all_images.innerHTML += html;
                       });
                    }
                    if(response.files){
                        let files = response.files;
                        files.forEach(element => {
                            let html = '';
                                html += '<div class="col-sm-3 col-md-2">';
                                html += '<div class="card p-2" style="min-height:150px;display: flex;justify-content: center;overflow:hidden">';
                                html += '<a class="text-decoration-none" href="'+element.href+'">';
                                html += '<img src="'+element.href+'" alt="'+element.text+'" class="card-img-top" style="height:150px;vertical-align: middle;">';
                                html += '<p class="mb-0 text-dark d-flex mt-2" style=""><input class="me-2 form-check-input media_checkbox" type="checkbox" data-name="'+ element.text +'">'+ element.text +'</p>';
                                html += '</a>';              
                                html += '</div>';
                                html += '</div>';
                            show_all_images.innerHTML += html;
                       });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown); // Handle errors
                }
            });
        }

        function openFolderBox(){
            let openFolderBox = document.getElementById('create_folder');
            if(openFolderBox.style.display == 'none'){
                openFolderBox.style.display = 'block';
            }else{
                openFolderBox.style.display = 'none';
            }
        }

        document.getElementById('new_folder_btn').addEventListener('click', () =>{
            let formData = new FormData();
            let new_folder_box = document.getElementById('new_folder_box').value;
            formData.append('folder_name', new_folder_box);
            formData.append('_token', '{{ csrf_token() }}');
            
            $.ajax({
                url: "/admin/media/createFolder",
                type: "post",
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the Content-Type header
                success: function (response) {
                    alert(response.message) // Handle success
                    document.getElementById('new_folder_box').value = '';
                    getFiles();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown); // Handle errors
                }
            });
        })

        // delete files and folder
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete_files').forEach(deleteButton => {
                deleteButton.addEventListener("click", () => {
                    const mediaCheckbox = document.querySelectorAll('.media_checkbox');
                    let selectedFiles = [];
                    mediaCheckbox.forEach(element => {
                        if(element.checked){
                            selectedFiles.push(element.getAttribute('data-name'))
                        }
                    });

                    let formData = new FormData();
                    formData.append('files[]', selectedFiles);
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: "/admin/media/delete",
                        type: "post",
                        data: formData,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting the Content-Type header
                        success: function (response) {
                            alert(response.message) // Handle success
                            document.getElementById('new_folder_box').value = '';
                            showAllImages();
                            getFiles();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error(textStatus, errorThrown); // Handle errors
                        }
                    });
                });
            })
        })

        // open folder
        document.querySelectorAll('.open_folder').forEach(openFolder => {
            openFolder.addEventListener('click', () =>{
                let folder_data = openFolder.getAttribute('data-text');
                
            })
        })
    </script>
@endsection
