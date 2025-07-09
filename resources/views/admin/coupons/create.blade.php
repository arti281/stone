@extends('admin.common.base')

@push('setTitle')
{{$heading_title}}
@endpush

@section('content')
<h2>Create Coupon</h2>

@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="{{ route('coupons.store') }}" method="POST">
    @csrf
    <label>Coupon Code</label>
    <input type="text" name="code" required>

    <label>Discount</label>
    <input type="number" name="discount" required>

    <label>Discount Type</label>
    <select name="discount_type">
        <option value="fixed">Fixed</option>
        <option value="percent">Percent</option>
    </select>

    <label>Valid From</label>
    <input type="date" name="valid_from" required>

    <label>Valid To</label>
    <input type="date" name="valid_to" required>

    <label>Status</label>
    <select name="status">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
    </select>

    <button type="submit">Create</button>
</form>
@endsection
