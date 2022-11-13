<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Category,Product};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('vendorhasactiveplan');
        $this->request = $request;
    }


    public function category($value='')
    {   $categories=Category::where('status',1)->orderBy('id','desc')->get();
        return view('front.categories',compact('categories'));
    }
    public function categorydetail(Request $request,$slug)
    {   
        $categories=Category::where('status',1)->orderBy('id','desc')->get();
        $cat=Category::where('slug',$slug)->where('status',1)->first();
        // $products=Product::where('category_id',$category->id)->where('status',1)->paginate(1);
        $returndata=$request->all();
        $name=$request->name;
        $prods = Product::when($cat, function ($query, $cat) {
                                      return $query->where('category_id', $cat->id);
                                  })
                                  ->when($name, function ($query, $name) {
                                       return $query->where('name','LIKE',"%{$name}%");
                                  });
                                  $products = $prods->where('status',1)->orderBy('id', 'desc')->paginate(10);


        return view('front.products',compact('products','categories','returndata'));
    }
    public function productdetail($slug)
    {
        $product=Product::where('slug',$slug)->where('status',1)->first();
        return view('front.product-details',compact('product'));
    }
}
