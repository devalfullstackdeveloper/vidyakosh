<?php   

namespace App\Http\Controllers\Backend\Admin;   


use App\Exceptions\GeneralException;    
use App\Http\Controllers\Traits\FileUploadTrait;    
use App\Http\Requests\Admin\StoreSubCategoriesRequest;  
use App\Http\Requests\Admin\UpdateSubCategoriesRequest; 
use App\Models\SubCategories;   
use App\Models\Category;    
use DB; 
use Illuminate\Http\Request;    
use App\Http\Controllers\Controller;    
use Illuminate\Support\Facades\Gate;    
use Yajra\DataTables\DataTables;    


class SubCategoriesController extends Controller    
{   
    /** 
     * Display a listing of the resource.   
     *  
     * @return \Illuminate\Http\Response    
     */ 
    public function index($id)
    {   
        $subcategories = DB::table('sub_categories')->where('cat_id','=',$id)->get();
        return view('backend.subcategories.index', compact('subcategories','id'));
    }   
        
    public function index1($id) 
    {   
        $subcategories = DB::table('sub_categories')->where('cat_id','=',$id)->get();
        return view('backend.subcategories.index', compact('subcategories','id'));    
    } 
        
        
        /** 
     * Display a listing of Courses via ajax DataTable. 
     *  
     * @return \Illuminate\Http\Response    
     */ 
        
        public function getData(Request $request)   
    {   
        $has_view = false;  
        $has_delete = false;    
        $has_edit = false;  
        $has_publish = false;   
        $has_unpublish = false; 

        //$departments =Departments::orderBy('id', 'desc')->get();  
        $subcategories = DB::table('sub_categories')->get();

        $subcategories = DB::table('sub_categories')    
                        ->join('categories', 'categories.id', '=', 'sub_categories.cat_id') 
                        ->where('sub_categories.cat_id', '=', $request->category_id)    
                        ->select('sub_categories.id', 'sub_categories.name', 'sub_categories.status', 'categories.name as cat_name')    
                        ->orderBy('sub_categories.id', 'desc')->get();  

        if (auth()->user()->isAdmin() || auth()->user()->is_admin == 1) {   
            $has_view = true;   
            $has_edit = true;   
            $has_delete = true; 
            $has_publish = true;    
            $has_unpublish = true;  
        }   

        return DataTables::of($subcategories)   
        ->addIndexColumn()  
        ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $has_publish, $has_unpublish, $request) {  
        $view = ""; 
        $edit = ""; 
        $delete = "";   
        if ($request->show_deleted == 1) {  
        return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.subcategories', 'label' => 'subcategories', 'value' => $q->id]); 
        }   

        if ($has_edit) {    
        $edit = view('backend.datatable.action-edit')   
        ->with(['route' => route('admin.subcategories.edit', ['subcategories' => $q->id])]) 
        ->render(); 
        $view .= $edit; 
        }   

        if ($has_delete) {  
        $delete = view('backend.datatable.action-delete')   
        ->with(['route' => route('admin.subcategories.destroy', ['subcategories' => $q->id, "cat_id" => $request->category_id])])  
        ->render(); 
        $view .= $delete;   
        }   

        if ($has_publish || $has_unpublish) {   
        if($q->status == 1){    
        $publish = view('backend.datatable.action-publish') 
        ->with(['route' => route('admin.subcategories.unpublish', ['subcategories' => $q->id])])    
        ->render(); 
        $view .= $publish;  
        } else{ 
        $unpublish = view('backend.datatable.action-unpublish') 
        ->with(['route' => route('admin.subcategories.publish', ['subcategories' => $q->id])])  
        ->render(); 
        $view .= $unpublish;    
        }   
        }   

        return $view;   

        })  
        ->rawColumns(['actions', 'image'])  
        ->make();   
    }   
        
    public function getData1(Request $request , $id)    
    {   
            
        $has_view = false;  
        $has_delete = false;    
        $has_edit = false;  
        $has_publish = false;   
        $has_unpublish = false; 
        $subcategories = "";    
    //$departments =Departments::orderBy('id', 'desc')->get();  
        $subcategories=DB::table('sub_categories')  
                     ->join('categories','categories.id','=','sub_categories.cat_id')   
                     ->where('sub_categories.cat_id',$id)   
                     ->select('sub_categories.id','sub_categories.name','sub_categories.status','categories.name as cat_name')  
                     ->orderBy('sub_categories.id', 'desc')->get(); 
                        
                        
        if (auth()->user()->isAdmin()) {    
            $has_view = true;   
            $has_edit = true;   
            $has_delete = true; 
            $has_publish = true;    
            $has_unpublish = true;  
        }   


        return DataTables::of($subcategories)   
            ->addIndexColumn()  
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete,$has_publish,$has_unpublish, $request) {    
                $view = ""; 
                $edit = ""; 
                $delete = "";   
                if ($request->show_deleted == 1) {  
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.subcategories', 'label' => 'subcategories', 'value' => $q->id]); 
                }           

                if ($has_edit) {    
                    $edit = view('backend.datatable.action-edit')   
                        ->with(['route' => route('admin.subcategories.edit', ['subcategories' => $q->id])]) 
                        ->render(); 
                    $view .= $edit; 
                }   

                if ($has_delete) {  
                    $delete = view('backend.datatable.action-delete')   
                        ->with(['route' => route('admin.subcategories.destroy', ['subcategories' => $q->id, "cat_id" => $id])])  
                        ->render(); 
                    $view .= $delete;   
                }   
                    
               if ($has_publish || $has_unpublish) {    
                        if($q->status == 1){    
                    $publish = view('backend.datatable.action-publish') 
                        ->with(['route' => route('admin.subcategories.unpublish', ['subcategories' => $q->id])])    
                        ->render(); 
                    $view .= $publish;  
                        }else{  
                       $unpublish = view('backend.datatable.action-unpublish')  
                        ->with(['route' => route('admin.subcategories.publish', ['subcategories' => $q->id])])  
                        ->render(); 
                    $view .= $unpublish;            
                        }   
                }   
                    
                return $view;   

            })  
        
            ->rawColumns(['actions', 'image'])  
            ->make();   
    }   
        
    /** 
     * Show the form for creating a new resource.   
     *  
     * @return \Illuminate\Http\Response    
     */ 
   public function create(Request $request) 
    {   
       $url = $request->fullUrl();  
       $url_param = explode('?', $url); 
       $category = str_replace("=", "", $url_param[1]); 
        return view('backend.subcategories.create',compact('category'));    
    }   



public function create1($id)    
    {   
       $url = $request->fullUrl();  
       $category=$id;   
        return view('backend.subcategories.create',compact('category'));    
    }   

public function store(StoreSubCategoriesRequest $request)   
    {   
     $this->validate($request, [    
            'name' => 'required|unique:sub_categories,name',    
            'category_id' => 'required',    
//            'moodle_subcat_ref_id'=>'required|numeric',   
        ]); 
        $subcategories = new  SubCategories();  
        $subcategories->name = $request->name;  
        $subcategories->cat_id = $request->category_id; 
        $subcategories->slug = str_slug($request->name);    
        $subcategories->short_name = $request->short_name;
        $subcategories->moodle_subcat_ref_id = "0"; 
        $subcategories->status = $request->status;  
        $subcategories->save(); 
        $id=$request->category_id;  
        
//        return redirect()->route('admin.subcategories.index', [$id])->withFlashSuccess(trans('alerts.backend.general.created'));
        return redirect()->route('admin.subcategories.index', ['cat_id' => $id])->withFlashSuccess(trans('alerts.backend.general.created'));
    }   


    /** 
     * Display the specified resource.  
     *  
     * @param  \App\SubCategories  $subCategories   
     * @return \Illuminate\Http\Response    
     */ 
    public function show(SubCategories $subCategories)  
    {   
        //  
    }   

    /** 
     * Show the form for editing the specified resource.    
     *  
     * @param  \App\SubCategories  $subCategories   
     * @return \Illuminate\Http\Response    
     */ 
   public function edit($id)    
    {   
        $subcategories = SubCategories::findOrFail($id);    
        return view('backend.subcategories.edit', compact('subcategories', 'id'));  
    }   

    /** 
     * Update the specified resource in storage.    
     *  
     * @param  \Illuminate\Http\Request  $request   
     * @param  \App\SubCategories  $subCategories   
     * @return \Illuminate\Http\Response    
     */ 
    public function update(UpdateSubCategoriesRequest $request, $id)    
    {   
       $subcategories = SubCategories::findOrFail($id); 
       $subcategories->update($request->all()); 

       $subcategories->save();  
//       return redirect()->route('admin.subcategories.index')->withFlashSuccess(trans('alerts.backend.general.updated'));  
       return redirect()->route('admin.subcategories.index', ['id' => $subcategories->cat_id])->withFlashSuccess(trans('alerts.backend.general.created'));  
    }   

    /** 
     * Remove the specified resource from storage.  
     *  
     * @param  \App\SubCategories  $subCategories   
     * @return \Illuminate\Http\Response    
     */ 
      //public function destroy(SubCategories $subCategories)   
    public function destroy($id)    
    {   
        $url = explode("=",url()->full());
        $subcategory = SubCategories::findOrFail($id);   
        $subcategory->delete(); 

//        return redirect()->route('admin.subcategories.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));   
        return redirect()->route('admin.subcategories.index', ['id' => $url[1]])->withFlashSuccess(trans('alerts.backend.general.deleted'));   
    }   
        
        
                
            
 //////////////////////////////////////////////////////////////////////unpublish SubCategories  
        
   public function unpublish($id)   
    {   
        $status=0;  
        $subcategories = SubCategories::findOrFail($id);    
        $subcategories->status = $status;   
        $subcategories->update();   
        return redirect()->route('admin.subcategories.index')->withFlashSuccess(trans('alerts.backend.general.updated'));   
    }   


///////////////////////////////////////////////////////////////////////publish SubCategories        
      public function publish($id)  
    {   
        $status=1;  
        $subcategories = SubCategories::findOrFail($id);    
        $subcategories->status = $status;   
        $subcategories->update();   
        return redirect()->route('admin.subcategories.index')->withFlashSuccess(trans('alerts.backend.general.updated'));   
    }   
}