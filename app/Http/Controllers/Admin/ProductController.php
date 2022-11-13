<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use DataTables;
use Illuminate\Http\Request;
use Session;
class ProductController extends Controller
{

    public function __construct(Request $request){
        $this->middleware('auth:admin');
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {   
        $datas=Product::orderBy('id','desc')->get();  
        return DataTables::of($datas)
                             ->addIndexColumn()
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin.product.status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin.product.status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option></select></div>';
                            })

                            ->addColumn('action', function(Product $data) {
                                return '<div class="action-list">
                                
                                <a href="'.route('admin.product.edit',$data->id).'" class="btn btn-info btn-sm fs-13 waves-effect waves-light"><i class="ri-edit-box-fill align-middle fs-16 me-2"></i>Edit</a> 

                                <a data-href="' . route('admin.product.delete',$data->id) . '" data-bs-toggle="modal" data-bs-target="#confirm-delete" class="btn btn-sm fs-13 btn-danger waves-effect waves-light"><i class="ri-delete-bin-fill align-middle fs-16 me-2"></i>Delete</a>

                                </div>';
                            }) 
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side

       
    }

    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories=Category::where('status',1)->get();
        return view('admin.products.create',compact('categories'));
    }

    public function createImport($value='')
    {   
        $categories=Category::where('status',1)->get();
        return view('admin.products.import',compact('categories'));
    }

    public function importSubmit(Request $request)
    {   
        $log = "";
        //--- Validation Section
         $this->validate($request,[
            'category_id'=>'required',
            'csvfile'      => 'required|mimes:csv,txt',
        ]);

        $filename = '';
        if ($file = $request->file('csvfile')) {
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move('assets/temp_files', $filename);
        }
        $category = Category::where('id',$request->category_id)->first();
        $datas = "";

        $file = fopen(public_path('assets/temp_files/' . $filename), "r");
        $i = 1;
        while (($line = fgetcsv($file)) !== FALSE) {

            if ($i != 1) {

                if (!Product::where('sku', $line[0])->exists()) {
                    //--- Logic Section
                    $data = new Product;
                    //$sign = Currency::where('is_default', '=', 1)->first();
                    $input['category_id'] = $category->id;
                    $input['sku'] = $line[0];
                    $input['name'] = $line[1];
                    $input['website'] = $line[2];
                    $input['email'] = $line[3];
                    $input['phone'] = $line[4];
                    $input['location'] = $line[5];
                    $input['revenue'] = $line[6];
                    $input['details'] = $line[7];
                    $input['facebook'] = $line[8];

                    // Save Data
                    $data->fill($input)->save();

                    // Set SLug
                    $prod = Product::find($data->id);
                    $prod->slug = str_slug($data->name, '-') . '-' . strtolower($data->sku);
                    $prod->update();

                     
                } else {
                    $log .= "<br>Row No: " . $i . " - Duplicate Listing Sku Code!<br>";
                }
            }

            $i++;
        }
        fclose($file);
        //--- Redirect Section
        $msg = 'Bulk Listing File Imported Successfully.<a class="text-primary" href="' . route('admin.product.index') . '">View Listings.</a>' . $log;
        Session::flash('message', $msg);
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $this->validate($request,[
            'category_id'=>'required',
            'sku' => 'required|unique:products',
            'name'=>'required',
        ]);
        $data=new Product();
        $input=$request->all();
        //$input['user_id']=auth()->user()->id;
        $data->fill($input)->save();

        // Set SLug
        $prod = Product::find($data->id);
        $prod->slug = str_slug($data->name, '-') . '-' . strtolower($data->sku);
        $prod->update();

        // Session::flash('message', 'Data Added Successfully !');
        // Session::flash('alert-class', 'alert-success');
        toastr()->success('Data has been saved successfully!');
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $categories=Category::where('status',1)->get();
        $data=Product::find($id);
        return view('admin.products.edit',compact('data','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request,[
            'name'=>'required',
            'category_id'=>'required',
            'sku' => 'required|unique:products,sku,'.$id,
        ]);
        $data=Product::find($id);
        $input=$request->all();
        $data->update($input);

        // Set SLug
        $prod = Product::find($data->id);
        $prod->slug = str_slug($data->name, '-') . '-' . strtolower($data->sku);
        $prod->update();

        // Session::flash('message', 'Data Updated Successfully !');
        // Session::flash('alert-class', 'alert-success');
        // return redirect()->back();
        // toastr()->success('');
        toastr('Data has been updated successfully!', 'success');
        return redirect()->route('admin.product.index');
    }

        //*** GET Request
    public function status($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        $data = Product::findOrFail($id);
        $data->delete();
    }
}
