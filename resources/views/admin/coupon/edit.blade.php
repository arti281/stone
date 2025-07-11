@extends('admin.common.base')

@section('content')
    <h1>Edit Coupon</h1>
    <form method="POST" action="{{ route('admin.coupon.update', $coupon->id) }}">
        @csrf
        @method('PUT')
        <input type="text" name="code" value="{{ old('code', $coupon->code) }}" placeholder="Coupon Code">
        <input type="number" name="discount" value="{{ old('discount', $coupon->discount) }}" placeholder="Discount">
        <button type="submit">Update</button>
    </form>
@endsection
