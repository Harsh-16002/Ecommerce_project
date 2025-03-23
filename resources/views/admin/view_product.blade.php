<!DOCTYPE html>
<html>

<head>
    <style>
        /* Container for the table */
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
            overflow-x: auto;
            width: 100%;
        }

        /* Table design */
        .table_deg {
            border: 2px solid #00C851;
            /* Bright green border */
            width: 100%;
            table-layout: auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
        }

        /* Header design */
        th {
            background-color: #33b5e5;
            /* Light blue background */
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            border: 1px solid #ddd;
            /* Light border */
        }

        /* Cell design */
        td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 12px;
            background-color: #f9f9f9;
            /* Light grey background for cells */
            transition: background-color 0.3s ease;
            /* Smooth background transition */
            color: black;
        }

        /* Hover effect on table rows */
        tr:hover {
            background-color: #f1f1f1;
            /* Light grey background on hover */
        }

        /* Description column adjustments */
        td.description-column {
            min-width: 250px;
            max-width: 500px;
            word-wrap: break-word;
            white-space: normal;
            text-align: left;
            font-size: 16px;
        }

        /* Image styling with interaction */
        td img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            /* Rounded corners */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Smooth transform and shadow */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            /* Subtle shadow for depth */
        }

        /* Zoom-in effect on hover for images */
        td img:hover {
            transform: scale(1.1);
            /* Slight zoom-in effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            /* Stronger shadow on hover */
        }

        /* Pagination design */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            color: #33b5e5;
            /* Blue color for links */
            padding: 10px 15px;
            margin: 0 5px;
            border: 1px solid #ddd;
            text-decoration: none;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #33b5e5;
            /* Blue background on hover */
            color: white;
        }

        .pagination .active span {
            background-color: #00C851;
            /* Green background for active page */
            color: white;
            border-color: #00C851;

        }
    </style>
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <form action="{{url('search_product')}}" method="get">
                    @csrf
                    <input type="text" name="search" placeholder="Search here..." class="form-control" style="width: auto; display: inline-block; margin-right: 10px;">
                    <input type="submit" value="Submit" class="btn btn-secondary" style="display: inline-block;">


                </form>
                <div class="div_deg">
                    <table class="table_deg">
                        <tr>
                            <th>Product Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        @foreach($data as $datas)
                        <tr>
                            <td>{{$datas->title}}</td>
                            <td class="description-column">{{$datas->description}}</td>
                            <td>{{$datas->price}}</td>
                            <td>{{$datas->category}}</td>
                            <td>{{$datas->quantity}}</td>
                            <td><img src="products/{{$datas->image}}" alt="Product Image"></td>
                            <td><a class="btn btn-success" href="{{url('update_product',$datas->id)}}" ,>Update</a></td>
                            <td><a class="btn btn-danger" href="{{url('delete_product',$datas->id)}}" ,>Delete</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="pagination">
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>