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
                                <li>
                                    @if ($breadcrumb['href'])
                                        <a href="{{$breadcrumb['href']}}">{{$breadcrumb['text']}}</a>
                                    @else
                                        <span class="text-muted">{{$breadcrumb['text']}}</span>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div>
                        <button id="submitButton" class="btn btn-primary fs-4 px-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Save"><i class="fa-solid fa-floppy-disk"></i></button>
                        <a class="btn btn-primary fs-4 px-3" href="{{$back}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back"><i class="fa-solid fa-reply"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 px-4">
                <div class="col-md-12">
                    <!-- Alert Message -->
                    @include('admin.common.alert')
                    
                    <div class="px-3 py-2 title-list">
                        <p class="mb-0"><i class="fa-solid fa-pencil"></i> {{ $list_title }}</p>
                    </div>
                    <div class="card rounded-0 p-3 mb-3 ">
                        <form id="saveForm" action="{{$action}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="general_cod_fee">COD Fee</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="general_cod_fee" name="general_cod_fee" class="form-control p-2" value="{{ isset($general_cod_fee) ? $general_cod_fee: old('general_cod_fee') }}" placeholder="COD Fee in reupee">
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-switch ms-5" >
                                        <input type="hidden" name="general_cod_fee_status" value="0">
                                        <input class="form-check-input fs-2" name="general_cod_fee_status" type="checkbox" role="switch" @if($general_cod_fee_status) checked @endif>
                                    </div>
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('general_cod_fee')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-2 text-end">
                                    <label for="general_prepaid_fee">Prepaid Fee %</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" id="general_prepaid_fee" name="general_prepaid_fee" class="form-control p-2" value="{{ isset($general_prepaid_fee) ? $general_prepaid_fee: old('general_prepaid_fee') }}" placeholder="Prepaid fee in percentage">
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-switch ms-5">
                                        <input type="hidden" name="general_prepaid_fee_status" value="0">
                                        <input class="form-check-input fs-2" name="general_prepaid_fee_status" type="checkbox" role="switch" @if($general_prepaid_fee_status) checked @endif>
                                    </div>
                                </div>
                                <div class="errors">
                                    <span class="text-danger">
                                        @error('general_prepaid_fee')
                                            {{$message}}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let submitButton = document.getElementById("submitButton");
            let form = document.getElementById("saveForm");

            submitButton.addEventListener("click", function() {
                form.submit(); // This will submit the form when the button is clicked
            });
        });

    </script>
    
</section>
@endsection