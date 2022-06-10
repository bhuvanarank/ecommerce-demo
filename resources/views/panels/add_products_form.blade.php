@extends('layouts.app')

@section('content')
<div class="container gap30">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form id="product-form" method="POST" action="{{ url('/add-products') }}" enctype="multipart/form-data"> 
                      @csrf
                      <div class="row">

                        @if(session()->has('status'))
                          <div class="form-group col-md-12 col-sm-12">
                            <h3 class="suc">{{session()->get('message')}}</h3>
                          </div>
                          <div class="col-md-12 col-sm-12 gap20" id="gap"></div>
                        @endif

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 ">
                        <h5>Add Products</h5>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 text-right lapshow">
                        <a href="{{url('products')}}"><img src="{{asset('assets/img/cancel.png')}}" height="10px;"></a>
                      </div>
                      <input type="hidden" name="id" id="id" value="">

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Product Name </label>
                          <input type="text" name="product_name" id="product_name" value="" class="form-control" required="">
                          <span id="err_product_name" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Price </label>
                          <input type="text" name="price" id="price" value="" class="form-control" required="" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" maxlength="8">
                          <span id="err_price" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Category </label>
                          <select name="category_id" id="category_id" value="" class="form-control" required="required">
                            @foreach($category_list as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                          </select>
                          <span id="err_category" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12">
                          <label> Image </label>
                          <input type="file" name="product_image" id="product_image" value="" class="form-control" required="">
                          <span id="err_product_image" class="error"></span>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 gap10">
                        <button type="submit" class="btn btn-primary">Submit</button> &nbsp;
                        <a href="{{url('products')}}" class="btn btn-primary-outline">Close</a>
                      </div>
                      </div>
                    </form>
                </div>
            </div>
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

//hide success message after 5 seconds
setTimeout(function(){
  $(".suc").hide();
  $("#gap").hide();
},5000);

</script>