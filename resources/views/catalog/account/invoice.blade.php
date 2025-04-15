<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .invoice-container{
            width: 8in;  /* A4 width */
            max-width: 100%; /* Scale content responsively */
            height: auto; /* Adjust height to content */
            margin: 0;
            padding: 10px;
            font-size: 13px;
            padding-top: 20px;
            box-sizing: border-box;
            overflow: hidden; /* Hide overflow */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-btn{
            width: 8.27in;
            margin: 10px auto;
            padding: 10px;
        }
        .invoice-btn button{
            background-color: #2b3c63;
            color: #fff;
            padding: 7px;
            font-size: 17px;
            border-radius: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .header .invoice-title {
            background-color: #2b3c63;
            color: white;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 4px;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        .invoice-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-info th,
        .invoice-info td {
            text-align: left;
            padding: 5px 0;
        }

        .invoice-info th {
            font-weight: bold;
            color: #555;
        }

        .details {
            margin-bottom: 20px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .details th {
            background-color: #f9f9f9;
            color: #333;
        }

        .summary {
            text-align: right;
            margin-top: 20px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary th,
        .summary td {
            padding: 10px;
            text-align: right;
        }

        .summary th {
            color: #555;
        }

        .total {
            background-color: #2b3c63;
            color: white;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            border-radius: 4px;
        }
        p{
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <div class="invoice-btn" style="text-align: end">
        <button id="download-pdf">Download as PDF</button>
    </div>

    <div class="container">
        <div class="invoice-container">
            <div class="header">
                <div class="logo">Ecommerce Surface</div>
                <div class="invoice-title">INVOICE</div>
            </div>
            <div class="invoice-info">
                <hr>
                <p><strong>Order ID:</strong> <span>{{ $orderMaster->id }}</span></p>
                <p><strong>Order Date:</strong> <span>{{ $orderMaster->created_at->format('d M Y') }}</span></p>
                <p><strong>Invoice No:</strong> <span>{{ $orderMaster->invoice_prefix }}{{ $orderMaster->invoice_no }}</span></p>
            </div>
            <div class="details">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderMaster->orders as $item)
                            <tr>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->color->color_name }}</td>
                                <td>{{ $item->size->size_name }}</td>
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
                        <td>$3380.00</td>
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
                        <td>$0.00</td>
                    </tr>
                </table>
                <div class="total">Total: $3380.00</div>
            </div>
        </div>
    </div>

    {{-- https://github.com/eKoopmans/html2pdf.js?tab=readme-ov-file#image-type-and-quality --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        document.getElementById('download-pdf').addEventListener('click', async function() {
            const invoice = document.querySelector('.invoice-container');
            var opt = {
                margin: 0,
                filename:     'invoice.pdf',
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: [8.27, 11.69], orientation: 'portrait' } // Custom size (width x height)
            };
    
            // New Promise-based usage:
            html2pdf().set(opt).from(invoice).save();
        });
    </script>

</body>
</html>