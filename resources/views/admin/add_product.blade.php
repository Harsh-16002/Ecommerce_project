<html>

<head>
    <style>
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
        }

        .product {
            color: white;
        }

        label {
            display: inline-block;
            width: 200px;
            font-size: 15p !important;
            color: white !important;
        }

        input[type="text"] {
            width: 350px;
            height: 40px;
        }

        textarea {
            width: 450px;
            height: 80px;
        }

        .input_deg {
            padding: 15px;
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
                <h1 class="product">Add Product</h1>
                <div class="div_deg">

                    <form action="{{url('upload_product')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input_deg">
                            <label for="">Title</label>
                            <input type="text" name="title">
                        </div>
                        <div class="input_deg">
                            <label for="">Description</label>
                            <textarea name="description" id="" required></textarea>
                        </div>
                        <div class="input_deg">
                            <label for="">Price</label>
                            <input type="number" name="price">
                        </div>
                        <div class="input_deg">
                            <label for="">Quantity</label>
                            <input type="number" name="quantity">
                        </div>
                        <div class="input_deg">
                            <label for="">Category</label>
                            <select name="category" required>

                                <option>Select a option</option>
                                @foreach($data as $data){
                                <option value="{{$data->category_name}}">{{$data->category_name}}</option>
                                @endforeach
                                }
                            </select>
                        </div>
                        <div class="input_deg">
                            <label for="">Product image</label>
                            <input type="file" name="image">
                        </div>
                        <div class="input_deg">
                            <input class="btn btn-success" type="submit" value="Add product">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
</body>

</html>