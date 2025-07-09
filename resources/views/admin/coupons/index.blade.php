@extends('admin.common.base')

@push('setTitle')
{{$heading_title}}
@endpush

@section('content')
<h2>Coupons</h2>
<a href="{{ route('coupons.create') }}">Create New Coupon</a>

<table>
    <thead>
        <tr>
            <th>Code</th>
            <th>Discount</th>
            <th>Type</th>
            <th>Valid From</th>
            <th>Valid To</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($coupons as $coupon)
        <tr>
            <td>{{ $coupon->code }}</td>
            <td>{{ $coupon->discount }}</td>
            <td>{{ ucfirst($coupon->discount_type) }}</td>
            <td>{{ $coupon->valid_from }}</td>
            <td>{{ $coupon->valid_to }}</td>
            <td>{{ $coupon->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('coupons.edit', $coupon->id) }}">Edit</a>
                <form method="POST" action="{{ route('coupons.destroy', $coupon->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this coupon?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
