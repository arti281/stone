<!DOCTYPE html>
<html>
<head>
    <title>Product Invoice</title>
</head>
<body>
    <h2>Thank you for your order!</h2>
    @if ($orderMaster)
    <div class="invoice-info">
        <hr>
        <p><strong>Order ID:</strong> <span>{{ $orderMaster->id }}</span></p>
        <p><strong>Order Date:</strong> 
            <span>{{ $orderMaster->created_at?->format('d M Y') }}</span>
        </p>
        <p><strong>Invoice No:</strong> 
            <span>{{ $orderMaster->invoice_prefix }}{{ $orderMaster->invoice_no }}</span>
        </p>
    </div>
@endif

@if ($orderMaster && $orderMaster->orders)
    <div class="details">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderMaster->orders as $item)
                    <tr>
                        <td>{{ $item->product->product_name ?? '' }}</td>
                        <td>{{ $item->quantity ?? '' }}</td>
                        <td><span style="font-size: 16px">₹</span>{{ $item->price ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

 @if ($orderMaster)
    <div class="summary">
        <table>
            <tr>
                <th>Subtotal:</th>
                <td>{{ $item->price ?? 0 }}</td>
            </tr>
            <tr>
                <th>Discount:</th>
                <td>{{ $orderMaster->discount ?? 0 }}</td>
            </tr>
            <tr>
                <th>Tax:</th>
                <td>{{ $orderMaster->tax ?? 0 }}</td>
            </tr>
            <tr>
                <th>Paid:</th>
                <td>{{ $item->price ?? 0 }}</td>
            </tr>
        </table>
        <div class="total">Total: {{ $item->price ?? 0 }}</div>
    </div>
@endif
</body>
</html>
