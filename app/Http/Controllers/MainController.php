<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Users;
use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\CartItems;
use DB;

class MainController extends Controller

{
    public function __construct()
    {
    }

    public function category_list()
    {
    	$category_list = ProductCategories::get();

        return view('panels.category_list',['category_list' => $category_list]);
    }

    public function add_category_form()
    {
        return view('panels.add_category_form',[]);
    }
    public function edit_category_form($id=null)
    {
    	$product_category = ProductCategories::where('id',$id)->first(); 

        return view('panels.edit_category_form',['product_category' => $product_category]);
    }

    public function add_category(Request $request)
	{  

		if($request->id==''){

		$ProductCategories = new ProductCategories;  
		$ProductCategories->name = $request->category_name;         
		$ProductCategories->save();
	
		$message='Product category added successfully';

		}else{
		ProductCategories::where('id','=',$request->id)->update(['name' => $request->category_name]); 
		
		$message='Product category updated successfully';
		}
		$status='success';

		return back()->with('status',$status)->with('message',$message);
	}

    public function delete_category(Request $request)
    {
		$result = ProductCategories::where('id', '=', $request->id)->delete(); 
        
        return response()->json($result);
    }

    public function products()
    {
    	$products = Products::select('products.*','product_categories.name as product_name')
    	->leftjoin('product_categories','product_categories.id','=','products.category_id')
    	->get();

        return view('panels.products',['products' => $products]);
    }

    public function add_products_form()
    {
    	$category_list = ProductCategories::get();

        return view('panels.add_products_form',['category_list' => $category_list]);
    }

    public function add_products(Request $request)
	{  
		$image = $request->file('product_image');
		if($image!=null){
	        $imageName = time().'-0.'.$image->getClientOriginalExtension();
	        $image->move(public_path().'/uploads/products',$imageName);
		}else{
			$imageName = "";
		}

		if($request->price!=''){
			$price = $request->price * 100;
		}else{
			$price = 0;
		}

		if($request->id==''){

			$Products = new Products;  
			$Products->name = $request->product_name;         
			$Products->price = $price;         
			$Products->category_id = $request->category_id;         
			$Products->image = $imageName;         
			$Products->save();
		
			$message='Products added successfully';

		}else{
			if($imageName == ''){
				$imageName = $request->product_image_hid;
			}
			Products::where('id','=',$request->id)->update(['name' => $request->product_name,'price' => $price,'category_id' => $request->category_id,'image' => $imageName]); 
		
			$message='Products updated successfully';
		}
			$status='success';

			return back()->with('status',$status)->with('message',$message);
	}

	public function edit_product_form($id=null)
    {
    	$category_list = ProductCategories::get();
    	$product = Products::where('id',$id)->first(); 

        return view('panels.edit_product_form',['product' => $product, 'category_list' => $category_list]);
    }

    public function delete_products(Request $request)
    {
		$result = Products::where('id', '=', $request->id)->delete(); 
        
        $path=public_path().'/uploads/products/'.$request->image;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json($result);
    }

    public function cart_items()
    {
    	$products = Products::select('products.*','product_categories.name as product_name')
    	->leftjoin('product_categories','product_categories.id','=','products.category_id')
    	->get();

    	$cart_items = CartItems::select('products.name as product_name','products.price as product_price','product_categories.name as category_name','cart_items.created_at as created_on','cart_items.id as cart_id')
    	->leftjoin('products','products.id','=','cart_items.product_id')
    	->leftjoin('product_categories','product_categories.id','=','products.category_id')
    	->get();

        return view('panels.cart_items',['products' => $products, 'cart_items' => $cart_items]);
    }

    public function add_cartitems_form()
    {
    	$category_list = ProductCategories::get();
    	
    	
        return view('panels.add_cartitems_form',['category_list' => $category_list]);
    }

    public function get_products(Request $request)
    {
    	$products = Products::where('category_id',$request->category_id)->get();
    	
        return response()->json($products);
    }

    public function get_price(Request $request)
    {
    	$products = Products::where('id',$request->product_id)->value('price');
    	
    	$result = number_format($products / 100 , 2);

        return response()->json($result);
    }

    public function add_cart_items(Request $request)
	{  

		if($request->id==''){

		$CartItems = new CartItems;  
		$CartItems->product_id  = $request->product_name;         
		$CartItems->save();
	
		$message='Product successfully added into a cart';

		}else{
		CartItems::where('id','=',$request->id)->update(['product_id' => $request->product_name]); 
		
		$message='Product successfully updated into a cart';
		}
		$status='success';

		return back()->with('status',$status)->with('message',$message);
	}

	public function edit_cartitem_form($id=null)
    {
    	$category_list = ProductCategories::get();
    	
    	$cart_items = CartItems::select('products.id as product_id','products.price as product_price','product_categories.id as category_id','cart_items.created_at as created_on','cart_items.id as cart_id')
    	->leftjoin('products','products.id','=','cart_items.product_id')
    	->leftjoin('product_categories','product_categories.id','=','products.category_id')
    	->where('cart_items.id',$id)
    	->first();

        return view('panels.edit_cartitem_form',['category_list' => $category_list, 'cart_items' => $cart_items]);
    }

    public function delete_cartitem(Request $request)
    {
		$result = CartItems::where('id', '=', $request->id)->delete(); 
        
        return response()->json($result);
    }
    
}	