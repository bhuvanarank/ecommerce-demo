@extends('layouts.app')

@section('content')
<div class="container gap30">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('/add-category') }}">
                      @csrf
                      <div class="row">

                        @if(session()->has('status'))
                          <div class="form-group col-md-12 col-sm-12">
                            <h3 class="suc">{{session()->get('message')}}</h3>
                          </div>
                          <div class="col-md-12 col-sm-12 gap20" id="gap"></div>
                        @endif

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 ">
                        <h5>Add Category</h5>
                      </div>

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 text-right lapshow">
                        <a href="{{url('category-list')}}"><img src="{{asset('assets/img/cancel.png')}}" height="10px;"></a>
                      </div>

                      <div class="form-group col-sm-12 col-lg-12 col-md-12">
                          <label> Category Name </label>
                          <input type="text" name="category_name" id="category_name" value="" class="form-control" required="">
                          <span id="err_category_name" class="error"></span>
                      </div>

                      <input type="hidden" name="id" id="id" value="">

                      <div class="form-group col-sm-6 col-lg-6 col-md-12 gap10">
                        <button type="submit" class="btn btn-primary">Submit</button> &nbsp;
                        <a href="{{url('category-list')}}" class="btn btn-primary-outline">Close</a>
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
    $('#menu1').addClass('active');
}); 

//hide success message after 5 seconds
setTimeout(function(){
  $(".suc").hide();
  $("#gap").hide();
},5000);

</script>