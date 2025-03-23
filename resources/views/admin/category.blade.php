<!DOCTYPE html>
<html>
  <head> 
    <style type="text/css">

     input[type='text']
     {
        width: 400px;
        height: 40px;
     }
     .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
     }
     .table_deg{
     text-align: center;
     margin: auto;
     border: 2px solid yellowgreen;
     margin-top: 50px;
     }
     th{
      background-color: skyblue;
      padding: 15px;
      font-size: 20px;
      font-weight: bold;
      color:white;
      width: 600px;
     }
     td{
      color: white;
      padding: 10px;
      border:  1px solid skyblue;
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

          <h1 style="color:white">Add Category</h1>
     <div class="div_deg">
          <form action="{{url('add_category')}}" method="post">
            @csrf
        <div>
        <input type="text" name="category">
        
            <input class="btn btn-primary" type="submit" value="Add category">
        </div>


          </form>
    </div>
    <div>
      <table class="table_deg">
        <tr>
          <th>Category</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
        <tr>
          @foreach($data as $data)
          <td>{{$data->category_name}}</td>
          <td><a href="{{url('edit_category',$data->id)}}" class="btn btn-success">Edit</a></td>
          <td> <a href="{{url('delete_category',$data->id)}}" class="btn btn-danger" onclick="Confirmation(event)">Delete</a> </td>
        </tr>
        @endforeach
      </table>
    </div>
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
     <script>
      function Confirmation(ev){
       ev.preventDefault();
       var urlToRedirect = ev.currentTarget.getAttribute('href');
       console.log(urlToRedirect);

       Swal.fire({
           title: "Are you sure to delete this?",
           text: "This delete will be permanent",
           icon: "warning",
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, delete it!'
       }).then((result) => {
           if (result.isConfirmed) {
               window.location.href = urlToRedirect;
           }
       });
   }
</script>
     </script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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