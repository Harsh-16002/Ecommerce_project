<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .hero_area {
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .shop_section {
            display: flex;
            justify-content: center;
            padding: 40px 0;
        }

        /* .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        } */

        .box {
            text-align: center;
        }

        .box img {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .box img:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .detail-box {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .detail-box h6 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #34495e;
        }

        .detail-box span {
            color: #e74c3c;
            font-weight: bold;
        }

        .detail-box p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .detail-box:last-child {
            border-bottom: none;
        }
    </style>
    @include('home.css')
</head>

<body>
    <div class="hero_area">
        @include('Home.header')
    </div>

    <h2>Product Details</h2>

    <!-- Product details start -->
    <section class="shop_section layout_padding">
        <div class="container">
            <div class="box">
                <img src="/products/{{$data->image}}" alt="{{ $data->title }}">
                <div class="detail-box">
                    <h6>{{ $data->title }}</h6>
                    <h6>Price: <span>{{ $data->price }}</span></h6>
                </div>
                <div class="detail-box">
                    <h6>Category: {{ $data->category }}</h6>
                    <h6>Available Quantity: <span>{{ $data->quantity }}</span></h6>
                </div>
                <div class="detail-box">
                    <p>Description: {{ $data->description }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Product details ends -->

    <!-- Keeping the same style for Home.info -->
    @include('Home.info')

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
