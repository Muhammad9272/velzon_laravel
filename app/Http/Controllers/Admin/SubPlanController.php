<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\SubFeature;
use App\Models\SubPlan;
use DataTables;
use Illuminate\Http\Request;
use DB;
class SubPlanController extends Controller
{
    public function __construct(){

     $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function datatables()
    {   
        $datas=SubPlan::orderBy('id','desc')->get();  
        return DataTables::of($datas)
                            ->addIndexColumn()

                             ->editColumn('name', function(SubPlan $data) {
                                return $data->is_featured==1?'<div>'.$data->name. '<span class="badge badge-soft-success ml-10">Featured</span></div>':$data->name;
                            })
                            ->editColumn('interval', function(SubPlan $data) {
                                return AppHelper::setInterval($data->interval);
                            })
                            ->editColumn('price', function(SubPlan $data) {
                               return AppHelper::setCurrency($data->price);
                            })
                            ->addColumn('status', function(SubPlan $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin.subfeature.status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin.subplan.status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option></select></div>';
                            })

                            ->addColumn('action', function(SubPlan $data) {
                                return '<div class="action-list">
                                
                                <a href="'.route('admin.subplan.edit',$data->id).'" class="btn btn-info btn-sm fs-13 waves-effect waves-light"><i class="ri-edit-box-fill align-middle fs-16 me-2"></i>Edit</a> 
                                </div>';
                            }) 
                            ->rawColumns(['name','status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side

       
    }

    public function index()
    {
        return view('admin.subplans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        // $subfeatures=SubFeature::where('status',1)->get();
        // return view('admin.subplans.create',compact('subfeatures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
       $validated = $request->validate([
            'second_name'=>'required|unique:sub_plans|max:255',
            'price'=>'required',
            'interval'=>'required',
            'details'=>'required',
            'features' => 'present|array',
       ]);

        $data=new SubPlan();
        $input=$request->all();
        $input['features']=json_encode($request->features);
        $data->fill($input)->save();
        
        $data->name= str_slug($data->second_name,'-');
        $data->update();
        toastr()->success('Data has been saved successfully!');
        return redirect()->route('admin.subplan.index');
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
        $data=SubPlan::find($id);
        $subfeatures=SubFeature::where('status',1)->get();
        return view('admin.subplans.edit',compact('subfeatures','data'));
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
            
        $validated = $request->validate([
            'second_name'=> 'required|unique:sub_plans,second_name,'.$id,
            'price'=>'required',
            'interval'=>'required',
            'details'=>'required',
            'features' => 'present|array',
        ]);
        
        $data=SubPlan::find($id);
        $input=$request->all();
        if(isset($request->is_featured)){           
            DB::table('sub_plans')->update(['is_featured' => 0]);
            $input['is_featured']=1;
        }else{
            $input['is_featured']=0;
        }

        $input['features']=json_encode($request->features);
        $data->update($input);
        
        $data->name= str_slug($data->second_name,'-');
        $data->update(); 

        toastr()->success('Data has been Updated successfully!');
        return redirect()->route('admin.subplan.index');
    }

     public function status($id1,$id2)
    {
        $data = SubPlan::findOrFail($id1);
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
        $data = SubPlan::findOrFail($id);
        $data->delete();
    }
}
