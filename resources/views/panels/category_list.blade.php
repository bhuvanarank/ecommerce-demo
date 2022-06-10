@extends('layouts.app')

@section('content')
<div class="container gap20">
    <div class="row justify-content-center">

        <div class="col-md-6 col-sm-6">
          <h4>Product Categories</h4>
        </div>

        <div class="col-md-6 col-sm-6 md-text-right">

          <a class="btn btn-primary" href="{{url('/add-category-form')}}">Add Category</a>

          <a data-toggle="tooltip" data-placement="top" title="Export to excel" href="#"><img src="{{asset('assets/img/download.png')}}" height="30px;"></a>

        </div>

        <div class="col-md-12 gap10">
            <table class="table table-striped" id="sorttable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product Category Name</th>
                  <th scope="col">Created On</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>

                @if($category_list)
                @foreach($category_list as $key => $category)
                <tr>
                  <td scope="row">{{$key+1}}</td>
                  <td>{{$category->name}}</td>
                  <td>{{date('d/m/Y',strtotime($category->created_at))}}</td>
                  <td>
                    <a href="{{url('edit-category-form')}}/{{$category->id}}" data-toggle="tooltip" data-placement="top" title="Edit Product Category"><i class="fa fa-pen-to-square"></i></a> 
                    <a href="#" onclick="delete_category('{{$category->id}}')" data-toggle="tooltip" data-placement="top" title="Delete Product Category"><i class="fa fa-trash"></i></a>
                  </td>
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

<!-- js functions -->
<script>
//active menu label
$(function() { 
    $('#menu1').addClass('active');
}); 

//delete category
function delete_category(val){

    if(confirm("Are you sure you want to delete this category?")){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var id = val;
            var host = "{{ url('delete-category/') }}";   
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
@endsection