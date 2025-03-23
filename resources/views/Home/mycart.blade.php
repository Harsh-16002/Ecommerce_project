<!DOCTYPE html>
<html>

<head>
    <style>
        .div_deg {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 60px;
            flex-direction: column;
        }

        table {
            border: 2px solid black;
            text-align: center;
            width: 800px;
        }

        th {
            border: 2px solid black;
            text-align: center;
            color: white;
            font: 20px;
            font-weight: bold;
            background-color: black;
        }

        td {
            border: 1px solid skyblue;
        }

        .cart_value {
            text-align: center;
            margin: 20px;
            padding: 10px;
        }

        .address_form {
            margin-top: 40px;
            width: 800px;
            text-align: left;
            border: 2px solid black;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .address_form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .address_form input,
        .address_form textarea {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .address_form textarea {
            resize: vertical;
            min-height: 80px;
        }

        .address_form button {
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .address_form button:hover {
            background-color: #333;
        }
    </style>
    @include('home.css')

</head>

<body>
    <div class="hero_area">
        @include('Home.header')
        <!-- slider section -->

        <!-- end slider section -->
    </div>

    <div class="div_deg">
        <table>
            <tr>
                <th>Product title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Remove</th>
            </tr>
            <?php $value = 0; ?>
            @foreach($cart as $cart)
            <tr>
                <td>{{$cart->product->title}}</td>
                <td>{{$cart->product->price}}</td>
                <td>
                    <img width="150px" src="/products/{{$cart->product->image }}" alt="image">
                </td>
                <td><a href="{{url('remove_cart',$cart->id)}}" class="btn btn-danger">Remove</a></td>
            </tr>
            <?php $value = $value + $cart->product->price; ?>
            @endforeach
        </table>
    </div>

    <div class="cart_value">
        <h3>Total price: {{$value}}</h3>
    </div>

    <div class="div_deg">
        <form action="{{url('order_data')}}" method="POST" class="address_form">
            @csrf
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{Auth::user()->name}}" required>

            <label for="address">Address Line:</label>
            <textarea name="address" id="address">{{Auth::user()->address}}</textarea>

            <label for="landmark">Landmark:</label>
            <input type="text" id="landmark" name="landmark">

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{Auth::user()->phone}}">

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" required>

            <label for="pin">Pin Code:</label>
            <input type="text" id="pin" name="pin" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>

            <button type="submit">Save and Continue</button>
          
        </form>
    </div>

    <!-- info section -->
    @include('Home.info')
    <!-- end info section -->

    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{('js/bootstrap.js')}}"></script>
    <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js')}}"></script>
    <script src="{{('js/custom.js')}}"></script>

</body>

</html>
