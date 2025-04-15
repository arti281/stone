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
                        <a class="btn btn-primary fs-4 px-3" href="{{$add}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add user"><i class="fa-solid fa-plus"></i></a>
                        <a class="btn btn-danger fs-4 px-3" data-name="Selected Users" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete user" id="multi-selection-delete-button"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-3 px-4">
                <div class="col-sm-9 col-md-9">
                    <!-- Alert Message -->
                    @include('admin.common.alert')

                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-list"></i> user List</p>
                    </div>
                    <div class="card rounded-0 p-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"><input type="checkbox" class="form-check-input" name="" id="multiselections"></th>
                                    <th width="10%">Image</th>
                                    <th width="30%">user Name</th>
                                    <th width="24%">Email</th>
                                    <th width="15%">Status</th>
                                    <th width="16%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="form-check-input selectBox" name="" data-user-id="{{$user->id}}"></td>
                                        <td class="text-center"><img height="50" src="{{ ($user->image) ? asset("image/user").'/'.$user->image : asset('not-image-available.png')}}" alt="{{$user->name}}"></td>
                                        <td>{{$user->name}}</td>
                                        <td>{{ $user->email }}</td>
                                        <td> @if($user->status) <p class="text-success">Enabled</p> @else <p>Disabled</p> @endif </td>
                                        <td>
                                            <a class="btn btn-primary mb-1" href="{{ route('user-edit', ['user_id' => $user->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-danger deleteRow" href="javascript:void(0)" data-href="{{ route('user-delete', ['user_id' => $user->id]) }}" data-name="{{$user->name}}" data-row-name="user" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>                                    
                                @empty
                                    <caption>
                                        <p class="text-center">Not found any users</p>
                                    </caption>
                                @endforelse
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
                        <form id="filter-form" action="" method="get">
                            <div class="mb-3">
                                <label for="user_name" class="form-label fw-bold">user Name</label>
                                <input type="text" class="form-control" name="user_name" value="{{ $user_name ?? '' }}" id="user_name" placeholder="user Name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ $email ?? '' }}" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label fw-bold">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact" value="{{ $contact ?? '' }}" placeholder="Contact">
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
    document.getElementById('filter-form').addEventListener('submit', function(event) {
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

    // ======================== multi selections ================================
    let userList = [];
    const multiSelection = document.getElementById('multiselections');
    const selectBox = document.querySelectorAll('.selectBox');

    multiSelection.addEventListener('click', () => {
        userList = [];
        
        selectBox.forEach(element => {
            let productId = element.getAttribute('data-user-id')
            if(productId){
                if(multiSelection.checked){
                    userList.push(productId)
                    element.checked = true
                }else{
                    userList.pop(productId)
                    element.checked = false
                }
            }
        }); 
    })

    selectBox.forEach(element => {
        userList = [];
        element.addEventListener('click', () => {
            let productId = element.getAttribute('data-user-id')
            if(productId){
                if(element.checked){
                    userList.push(productId)
                    element.checked = true
                }else{
                    userList.pop(productId)
                    element.checked = false
                }
            }

            // unchecked multiselection when rest product
            if(selectBox.length !== userList.length){
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
        if(userList.length < 1){
            dataName = "<span style='color:red'>You must select a user to delete</span>"
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
                    url: '/admin/user/deleteMultiSelection',
                    method : 'post',
                    data: {
                        'userList' : userList,
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