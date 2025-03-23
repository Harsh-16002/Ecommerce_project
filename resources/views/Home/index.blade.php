<!DOCTYPE html>
<html>

<head>
  @include('home.css')
 
</head>

<body>
  <div class="hero_area">
   @include('Home.header')
    <!-- slider section -->

    @include('Home.slider')

    <!-- end slider section -->
  </div>
  <!-- end hero area -->

  <!-- shop section -->

  @include('Home.product')
  <!-- end shop section -->







  <!-- contact section -->

  @include('home.contact')
  <!-- end contact section -->

   

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