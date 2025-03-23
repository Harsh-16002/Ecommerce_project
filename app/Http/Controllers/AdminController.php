<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Barryvdh\DomPDF\Facade\Pdf;

use function Laravel\Prompts\search;
use function Pest\Laravel\delete;

class AdminController extends Controller
{
    public function view_category(){
        $data=Category::all();
        return view('admin.category',compact('data'));
        
    }

    public function add_category(Request $request){
        $category=new Category();
        $category->category_name=$request->category;
        $category->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Category added sussesfully.');
        return redirect()->back();
    }

    public function delete_category($id){
        $delete=Category::find($id);
        $delete->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Category deleted sussesfully.');
        return redirect()->back();
    }

    public function edit_category($id){
        $edit=Category::find($id);
        return view('admin.edit',compact('edit'));
    }

    public function update_category(Request $req,$id){
        $update=Category::find($id);
        $update->category_name=$req->category;
        toastr()->timeOut(5000)->closeButton()->addSuccess('Category updated sussesfully.');
        $update->save();
        return redirect('/view_category');
    }

    public function add_product()
    {
        $data=Category::all();
        return view('admin.add_product',compact('data'));
    }

    public function  upload_product(Request $req){
     $upload=new Product();
     $upload->title=$req->title;   
     $upload->description=$req->description;   
     $upload->price=$req->price;     
     $upload->quantity=$req->quantity;   
        
     $upload->category=$req->category;  

     $image=$req->image;
     if($image){
        $imagename=time().'.'.$image->getClientOriginalExtension();
        request()->image->move('products',$imagename);
        $upload->image=$imagename;
     }
     $upload->save();
     toastr()->timeOut(5000)->closeButton()->addSuccess('Category updated sussesfully.');
     return redirect()->back(); 
    }

    public function view_product(){
        $data=Product::paginate(4);
        return view('admin.view_product',compact('data'));
    }

    public function delete_product($id){
        $data=Product::find($id);
        $image_path=public_path('products/'.$data->image);
        if(file_exists($image_path)){
         unlink($image_path);
        }
        $data->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product deleted sussesfully.');
        return redirect()->back();

    }

    public function update_product($id){
        $data=Product::find($id);
        $category=Category::all();
        return view('admin.update_product',compact('data','category'));
    }

    public function edit_product(Request $req,$id){
        $data=Product::find($id);
        $data->title=$req->title;
        $data->description=$req->description;
        $data->price=$req->price;
        $data->category=$req->category;
        $data->quantity=$req->quantity;
        $image=$req->image;
        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $req->image->move('products',$imagename);
            $data->image=$imagename;
        }
        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product updated sussesfully.');
        return redirect('/view_product');

    }

    public function search_product(Request $req){
        $search=$req->search;
        $data=Product::where('title','LIKE','%'.$search.'%')->orWhere('category','LIKE','%'.$search.'%')->paginate('4');
        return view('admin.view_product',compact('data'));
    }

    public function view_orders(){
        $order= Order::all();

        return view('admin.order',compact('order'));
    }

    public function on_the_way($id){
        $order=Order::find($id);
        $order->status='on the way';
        $order->save();
        return redirect('view_orders');
    }
    public function delivered($id){
        $order=Order::find($id);
        $order->status='Delivered';
        $order->save();
        return redirect('view_orders');
    }

    public function print_pdf($id){
        $data=Order::find($id);
        $pdf = Pdf::loadView('admin.invoice',compact('data'));
        return $pdf->download('invoice.pdf');
    }

}
