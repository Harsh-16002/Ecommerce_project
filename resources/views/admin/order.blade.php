<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        table {
            width: 100%;
            max-width: 1200px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #1a1a1a;
            color: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4caf50;
            color: white;
            font-size: 16px;
        }
        td {
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #2e2e2e;
            transition: background-color 0.3s ease;
        }
        img {
            width: 100px;
            border-radius: 8px;
        }
        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .status-red {
            color: red;
        }
        .status-yellow {
            color: yellow;
        }
        .status-green {
            color: green;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Order Management</h2>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Phone No</th>
                        <th>Product Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        <th>Print PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->address }}, {{ $data->city }}, {{ $data->state }}, {{ $data->country }}, {{ $data->pincode }}</td>
                        <td>{{ $data->phone }}</td>
                        <td>{{ $data->product->title }}</td>
                        <td>${{ $data->product->price }}</td>
                        <td><img src="products/{{ $data->product->image }}" alt="Product Image"></td>
                        <td>
                            @if($data->status == 'in progress')
                            <span class="status-red">{{ $data->status }}</span>
                            @elseif($data->status == 'On the way')
                            <span class="status-yellow">{{ $data->status }}</span>
                            @else
                            <span class="status-green">{{ $data->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('on_the_way', $data->id) }}" class="btn btn-primary">On the Way</a>
                            <a href="{{ url('delivered', $data->id) }}" class="btn btn-success">Delivered</a>
                        </td>
                        <td>
                            <a href="{{ url('print_pdf', $data->id) }}" class="btn btn-secondary">Print PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- JavaScript files-->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
  </body>
</html>
