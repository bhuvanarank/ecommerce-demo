@extends('layouts.app')

@section('content')
<div class="container gap20">
    <div class="row justify-content-center">

        <div class="col-md-6 col-sm-6">
          <h4>Products</h4>
        </div>

        <div class="col-md-6 col-sm-6 md-text-right">
          <a class="btn btn-primary" href="{{url('/add-products-form')}}">Add Products</a>

          <a data-toggle="tooltip" data-placement="top" title="Export to excel" href="#"><img src="{{asset('assets/img/download.png')}}" height="30px;"></a>
        </div>

        <div class="col-md-12 gap10">
            <table class="table table-striped" id="sorttable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">Product Category</th>
                  <th scope="col">Image</th>
                  <th scope="col">Created On</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if($products)

                @foreach($products as $key => $product)
                <tr>
                  <td scope="row">{{$key+1}}</td>

                  <td>{{$product->name}}</td>

                  <td>{{number_format($product->price / 100, 2)}}</td>

                  <td>{{$product->product_name}}</td>

                  <td><a href="{{asset('uploads/products')}}/{{$product->image}}" target="_blank"><img src="{{asset('uploads/products')}}/{{$product->image}}" height="40px" width="50px"></a></td>

                  <td>{{date('d/m/Y',strtotime($product->created_at))}}</td>

                  <td><a href="{{url('edit-product-form')}}/{{$product->id}}" data-toggle="tooltip" data-placement="top" title="Edit Product"><i class="fa fa-pen-to-square"></i></a> 

                    <a href="#" onclick="delete_products('{{$product->id}}','{{$product->image}}')" data-toggle="tooltip" data-placement="top" title="Delete Product"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach

                @else
                <tr>
                  <th scope="row" colspan="7">No data found</th>
                </tr>
                @endif
              </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('assets/js/jquery.min.js')}}"></script>
<script>
//active menu label
$(function() { 
    $('#menu2').addClass('active');
}); 

//delete products
function delete_products(val, image){

    if(confirm("Are you sure you want to delete this product?")){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var id = val;
            var host = "{{ url('delete-products/') }}";   
                $.ajax({
                /* the route pointing to the post function */
                url: host,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {'_token': CSRF_TOKEN, 'id':id,'image':image},
                dataType: 'JSON',
                complete: function (data) {
                    console.log(data);
                },
                /* remind that 'data' is the response of the AjaxController */
                success: function (response) 
                {
                    window.location.reload();
                }
            });
    }
    else{
        return false;
    }

}

</script>