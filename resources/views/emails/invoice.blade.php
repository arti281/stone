<!DOCTYPE html>
<html>
<head>
    <title>Product Invoice</title>
</head>
<body>
    <h2>Thank you for your order!</h2>
    <div class="invoice-info">
                <hr>
                <p><strong>Order ID:</strong> <span>{{ $emailData['orderMaster']->id }}</span></p>
                <p><strong>Order Date:</strong> <span>{{ $emailData['orderMaster']->created_at->format('d M Y') }}</span></p>
                <p><strong>Invoice No:</strong> <span>{{ $emailData['orderMaster']->invoice_prefix }}{{ $emailData['orderMaster']->invoice_no }}</span></p>
            </div>

                        <div class="details">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            {{-- <th>Color</th>
                            <th>Size</th> --}}
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emailData['orderMaster']->orders as $item)
                            <tr>
                                <td>{{ $item->product->product_name }}</td>
                                {{-- <td>{{ $item->color->color_name }}</td>
                                <td>{{ $item->size->size_name }}</td> --}}
                                <td>{{ $item->quantity }}</td>
                                <td><span style="font-size: 16px">₹</span>{{ $item->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="summary">
                <table>
                    <tr>
                        <th>Subtotal:</th>
                        <td>{{ $item->price }}</td>
                    </tr>
                    <tr>
                        <th>Discount:</th>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <th>Tax:</th>
                        <td>$0.00</td>
                    </tr>
                    <tr>
                        <th>Paid:</th>
                        <td>{{ $item->price }}</td>
                    </tr>
                </table>
                <div class="total">Total: {{ $item->price }}</div>
            </div>
</body>
</html>
