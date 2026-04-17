<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f2433;
            margin: 0;
            padding: 24px;
            background: #f6f8fb;
        }

        .invoice-box {
            max-width: 840px;
            margin: 0 auto;
            padding: 32px;
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e7ecf4;
        }

        .invoice-head {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
        }

        .muted {
            color: #77809a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 0;
            border-bottom: 1px solid #edf1f7;
            text-align: left;
        }

        th:last-child, td:last-child {
            text-align: right;
        }

        .summary {
            margin-top: 22px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total {
            font-size: 22px;
            font-weight: 800;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-head">
            <div>
                <div class="brand">BUY IT</div>
                <div class="muted">Premium commerce invoice</div>
                <div class="muted">Generated {{ now()->format('F d, Y') }}</div>
            </div>
            <div>
                <strong>Invoice For</strong>
                <div>{{ $data->name }}</div>
                <div class="muted">{{ $data->user?->email }}</div>
                <div class="muted">{{ $data->phone }}</div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <strong>Shipping Address</strong>
            <div class="muted">{{ $data->address }}, {{ $data->city }}, {{ $data->state }}, {{ $data->country }}, {{ $data->pincode }}</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->product?->title ?? 'Archived product' }}</td>
                    <td>{{ $data->product?->category ?? 'Uncategorized' }}</td>
                    <td>{{ $data->quantity }}</td>
                    <td>Rs. {{ number_format((float) ($data->unit_price ?? $data->product?->price), 2) }}</td>
                    <td>Rs. {{ number_format((float) ($data->total_price ?? $data->product?->price), 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span class="muted">Payment status</span>
                <strong>{{ $data->payment_status }}</strong>
            </div>
            <div class="summary-row">
                <span class="muted">Delivery status</span>
                <strong>{{ $data->status }}</strong>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>Rs. {{ number_format((float) ($data->total_price ?? $data->product?->price), 2) }}</span>
            </div>
        </div>
    </div>
</body>
</html>
