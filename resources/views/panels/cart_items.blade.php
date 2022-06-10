@extends('layouts.app')

@section('content')
<div class="container gap20">
    <div class="row justify-content-center">

        <div class="col-md-6 col-sm-6">
          <h4>Cart Items</h4>
        </div>
        <div class="col-md-6 col-sm-6 md-text-right">
          <a class="btn btn-primary" href="{{url('/add-cartitems-form')}}">Add Cart Items</a>
          <a data-toggle="tooltip" data-placement="top" title="Export to excel" href="#"><img src="{{asset('assets/img/download.png')}}" height="30px;"></a>
        </div>

        <div class="col-md-12 gap10">
            <table class="table table-striped" id="sorttable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Category Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">Added On</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if($cart_items)
                @foreach($cart_items as $key => $items)
                <tr>
                  <td scope="row">{{$key+1}}</td>
                  <td>{{$items->product_name}}</td>
                  <td>{{$items->category_name}}</td>
                  <td>{{number_format($items->product_price / 100 ,2)}}</td>
                  <td>{{date('d/m/Y',strtotime($items->created_on))}}</td>
                  <td><a href="{{url('edit-cartitem-form')}}/{{$items->cart_id}}" data-toggle="tooltip" data-placement="top" title="Edit Cart Item"><i class="fa fa-pen-to-square"></i></a> <a href="#" onclick="delete_cartitem('{{$items->cart_id}}')" data-toggle="tooltip" data-placement="top" title="Delete Cart Item"><i class="fa fa-trash"></i></a></td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function() { 
    $('#menu3').addClass('active');
}); 
function delete_cartitem(val){

    if(confirm("Are you sure you want to delete this item?")){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var id = val;
            var host = "{{ url('delete-cartitem/') }}";   
                $.ajax({
                /* the route pointing to the post function */
                url: host,
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {'_token': CSRF_TOKEN, 'id':id},
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