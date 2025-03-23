<!DOCTYPE html>
<html>

<head>
  <style>
    .div_center {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 60px;
    }

    table {
      border: 2px solid black;
      text-align: center;
      width: 800px;
    }

    th {
      border: 2px solid skyblue;
      background-color: black;
      color: white;
      font-size: 19px;
      font-weight: bold;
      text-align: center;
    }

    td {
      border: 1px solid skyblue;
      padding: 10px;
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
  <!-- end hero area -->

  <!-- shop section -->

  <div class="div_center">
    <table>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Delivery status</th>
        <th>Image</th>
      </tr>
      @foreach($order as $order)
      <tr>
        <td>{{$order->product->title}}</td>
        <td>{{$order->product->price}}</td>
        <td>{{$order->status}}</td>
        <td><img width="150" src="products/{{$order->product->image}}" alt=""></td>
      </tr>
      @endforeach
    </table>
    <?php
    $totalValue = 0;
    foreach ($cart as $cart_item) {
      $totalValue += $cart_item->product->price;
    }
    ?>

    <a href="{{url('checkout',$totalValue)}}" class="btn btn-success">Pay using Card</a>
  </div>





  <!-- contact section -->





  <!-- info section -->

  @include('Home.info')
  <!-- end info section -->


  <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
  <script src="{{('js/bootstrap.js')}}"></script>
  <script src="{{('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js')}}">
  </script>
  <script src="{{('js/custom.js')}}"></script>

</body>

</html>