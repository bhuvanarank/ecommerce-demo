@extends('layouts.app')

@section('content')
<div class="container gap30">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form id="product-form" method="POST" action="{{ url('/add-cart-items') }}" enctype="multipart/form-data"> 
                      @csrf
                      <div class="row">

                        @if(session()->has('status'))
                          <div class="form-group col-md-12 col-sm-12">
                            <h3 class="suc">{{session()->get('message')}}</h3>
                          </div>
                          <div class="col-md-12 col-sm-12 gap20" id="gap"></div>
                        @endif

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 ">
                        <h5>Edit Cart Items</h5>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 text-right lapshow">
                        <a href="{{url('cart-items')}}"><img src="{{asset('assets/img/cancel.png')}}" height="10px;"></a>
                      </div>
                      <input type="hidden" name="id" id="id" value="{{$cart_items->cart_id}}">

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Product Category </label>
                          <select name="category_id" id="category_id" value="" class="form-control" required="required" onchange="load_products()">
                            <option value="">Select</option>
                            @foreach($category_list as $category)
                            <option value="{{$category->id}}" @if($cart_items->category_id == $category->id) selected = "selected" @endif>{{$category->name}}</option>
                            @endforeach
                          </select>
                          <span id="err_category" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Product Name </label>
                          <input type="hidden" id="product_name_hid" value="{{$cart_items->product_id}}">
                          <select name="product_name" id="product_name" value="" class="form-control" required="required" onchange="load_price()">
                            <option value="">Select</option>
                          </select>
                          <span id="err_product_name" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Price </label>
                          <input type="text" name="price" id="price" value="{{number_format($cart_items->product_price / 100 , 2)}}" readonly="readonly" class="form-control">
                          <span id="err_price" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6"></div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 gap10">
                        <button type="submit" class="btn btn-primary">Submit</button> &nbsp;
                        <a href="{{url('cart-items')}}" class="btn btn-primary-outline">Close</a>
                      </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $('#menu3').addClass('active');
  load_products();
  setTimeout(function(){
    var product_id = $("#product_name_hid").val();
    $("#product_name").val(product_id);
  },1000);
});

setTimeout(function(){
  $(".suc").hide();
  $("#gap").hide();
},5000);

function load_products(){

  var host = "{{ url('get-products/') }}";  
  var category_id = $("#category_id").val();
  $("#product_name").html('');
  $("#product_name").append("<option value=''>Select</option>");

    $.ajax({
    /* the route pointing to the post function */
    url: host,
    type: 'POST',
    /* send the csrf-token and the input to the controller */
    data: {'_token': '{{ csrf_token() }}', 'category_id':category_id},
    dataType: 'JSON',
    complete: function (data) {
      console.log(data);
    },
    /* remind that 'data' is the response of the AjaxController */
    success: function (response) 
    {
      var array = response;
      if (array != '')
      {
        for (i in array) {                        
         $("#product_name").append("<option value="+array[i].id+">"+array[i].name+"</option>");
        }  
      }
    }
    });
}

function load_price(){

  var host = "{{ url('get-price/') }}";  
  var product_id = $("#product_name").val();
  $("#price").val('');

    $.ajax({
    /* the route pointing to the post function */
    url: host,
    type: 'POST',
    /* send the csrf-token and the input to the controller */
    data: {'_token': '{{ csrf_token() }}', 'product_id':product_id},
    dataType: 'JSON',
    complete: function (data) {
      console.log(data);
    },
    /* remind that 'data' is the response of the AjaxController */
    success: function (response) 
    {
    $("#price").val(response);
    }
    });
}
</script>