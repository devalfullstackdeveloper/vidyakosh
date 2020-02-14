<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Userdetail;
use App\Models\Crttraining;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use DB;
use App\Models\SubCategories;
use App\Models\Course;
use App\Models\Review;

class LearningController extends Controller
{
    /**
     * Get invoice list of current user
     *
     * @param Request $request
     */ 
    public function getIndex(){
         $rating = DB::table('reviews')
               ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                ->groupBy('reviewable_id')->get();
      
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $department_id =  $studentdetail->department_id;

        $track = DB::table('tracks')
            ->select('tracks.*')
            ->where('tracks.department_id', $department_id)
            ->get();

            $k = 0;
            $elementsdata = array();
            foreach($track as $trackdata){
                $trackid = $trackdata->id;
                $elementsdata[$k]['track']['id'] = $trackid;
                $elementsdata[$k]['track']['name'] = $trackdata->name;

               $category = DB::table('categories')
                ->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
                ->select('categories.*')
                ->where('categories.track_id', $trackid)
                ->where('department_categories.department_id', $department_id)
                ->get();
                
                $i = 0;
                foreach ($category as $categorydata) {
                    $catid = $categorydata->id;
                    $elementsdata[$k]['track']['categories'][$i]['category']['id'] = $catid;
                    $elementsdata[$k]['track']['categories'][$i]['category']['category_name'] = $categorydata->name;
                    $SubCategories = SubCategories::where('cat_id',$catid)->get();
                    $j = 0;
                    $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'] = array();
                    foreach ($SubCategories as $SubCategoriesdata) {
                        $subcatid = $SubCategoriesdata->id;
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['id'] = $subcatid;
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['subcategory_name'] = $SubCategoriesdata->name;
                        $course = Course::where('sub_cat_id',$subcatid)->get();
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['courses'] = $course;
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['categoryname'] = $categorydata->name;
                        $j++;
                    }
                    $i++;
                }
                $k++;
            }
              $level = DB::table('course_difficulty')
               ->select('id','name')
                ->get();         
        return view('backend.learnings.index',compact('trainings','item','elementsdata','purchased_bundles','rating','level'));
    }
    
    public function selfEnrolled(){
         $rating = DB::table('reviews')
               ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                ->groupBy('reviewable_id')->get();
      
        $studentid = auth()->user()->id;
        $studentdetail  = Userdetail::where('user_id', $studentid)->first();
        $department_id =  $studentdetail->department_id;

        $track = DB::table('tracks')
            ->select('tracks.*')
            ->where('tracks.department_id', $department_id)
            ->get();

            $k = 0;
            $elementsdata = array();
            foreach($track as $trackdata){
                $trackid = $trackdata->id;
                $elementsdata[$k]['track']['id'] = $trackid;
                $elementsdata[$k]['track']['name'] = $trackdata->name;

               $category = DB::table('categories')
                ->join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
                ->select('categories.*')
                ->where('categories.track_id', $trackid)
                ->where('department_categories.department_id', $department_id)
                ->get();
                
                $i = 0;
                foreach ($category as $categorydata) {
                    $catid = $categorydata->id;
                    $elementsdata[$k]['track']['categories'][$i]['category']['id'] = $catid;
                    $elementsdata[$k]['track']['categories'][$i]['category']['category_name'] = $categorydata->name;
                    $SubCategories = SubCategories::where('cat_id',$catid)->get();
                    $j = 0;
                    $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'] = array();
                    foreach ($SubCategories as $SubCategoriesdata) {
                        $subcatid = $SubCategoriesdata->id;
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['id'] = $subcatid;
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['subcategory_name'] = $SubCategoriesdata->name;
                        $course = Course::where('sub_cat_id',$subcatid)->where('course_enrollment_type_id','1')->get();
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['courses'] = $course;
                        $elementsdata[$k]['track']['categories'][$i]['category']['subcategory'][$j]['categoryname'] = $categorydata->name;
                        $j++;
                    }
                    $i++;
                }
                $k++;
            }
                     $level = DB::table('course_difficulty')
               ->select('id','name')
                ->get();    
        return view('backend.learnings.index',compact('trainings','item','elementsdata','purchased_bundles','rating','level'));
    }
}
