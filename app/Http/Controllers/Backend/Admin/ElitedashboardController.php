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
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;

class ElitedashboardController extends Controller {

    /**
     * Get invoice list of current user
     *
     * @param Request $request
     */
    public function index() {

        /* Check User */
        $userId = auth()->user()->id;
        $userRole = DB::table('user_details')->where('user_id', $userId)->select('organisationaldept_role','department_id')->first();
        
        $usrRole = 0;
        $departmentId = 0;
        if ($userRole != "") {
            $departmentId = $userRole->department_id;
            $usrRole = $userRole->organisationaldept_role;
        }
        $chkRole = DB::table('department_role')->where('id', $usrRole)->select('parent_id')->first();

        $deptRole = "";
        if ($chkRole != "") {
            foreach ($chkRole as $ckrkey => $ckrval) {
                if ($ckrval != 0) {
                    $chkRole1 = DB::table('department_role')->where('id', $ckrval)->select('parent_id')->first();
                    foreach ($chkRole1 as $ckrkey1 => $ckrval1) {
                        if ($ckrval1 != 0) {
                            $chkRole2 = DB::table('department_role')->where('id', $ckrval1)->select('parent_id')->first();
                            foreach ($chkRole2 as $ckrkey2 => $ckrval2) {
                                if ($ckrval2 != 0) {
                                    $chkRole3 = DB::table('department_role')->where('id', $ckrval2)->select('parent_id')->first();
                                    foreach ($chkRole3 as $ckrkey3 => $ckrval3) {
                                        if ($ckrval3 != 0) {
                                            
                                        } else {
                                            $deptRole = "EMP";
                                        }
                                    }
                                } else {
                                    $deptRole = "HOD";
                                }
                            }
                        } else {
                            $deptRole = "HOG";
                        }
                    }
                } else {
                    $deptRole = "DG";
                }
            }
        }
        $hogCount = 0;
        $sioCount = 0;
        $scoCount = 0;
        $deptroleArr = array();
        /* For DG */
        if ($deptRole == "DG") {
            /* HOG */
            /* CRT */
            $hogHirarchy = DB::select("SELECT GROUP_CONCAT(lv SEPARATOR ',') FROM (
			SELECT @pv:=(SELECT GROUP_CONCAT(id SEPARATOR ',') AS Hog_user FROM department_role WHERE parent_id IN (@pv)) AS lv FROM department_role
							JOIN
							(SELECT @pv:=7)tmp
							WHERE parent_id IN (@pv)) a;");

            $hogHirArr = array(7);
            foreach ($hogHirarchy[0] as $hhk => $hhval) {
                $hogDeptRole = explode(",", $hhval);
                foreach ($hogDeptRole as $i => $v) {
                    $hogHirArr[] = $v;
                }
            }
            $hogUsr = array();
            $cnt = 0;
            foreach ($hogHirArr as $deptUsrRole) {
                if ($deptUsrRole == 7) {
                    $hogUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', $deptUsrRole)
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();
                    $usrArr = array();
                    foreach ($hogUser as $key => $value) {
                        $usrArr[] = $value->id;
                    }
                    $hogUsr[] = $usrArr;
                } else {
                    $hogUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', $deptUsrRole)
                            ->whereIn('user_details.reportingmanager_id', $hogUsr[$cnt - 1])
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();

                    $usrArr = array();
                    foreach ($hogUser as $key => $value) {
                        $usrArr[] = $value->id;
                    }
                    $hogUsr[] = $usrArr;
                }
                $cnt = $cnt + 1;
            }
            $hogTrainingCnt = 0;
            $eLearning = 0;
            $seminarCnt = 0;
            $executiveBriefingCnt = 0;
            foreach ($hogUsr as $key => $users) {
//                $hogCount = DB::table('tab_training_status')->where('status', 1)->whereIn('user_id', $users)->count();
//                $hogTrainingCnt = $hogTrainingCnt + $hogCount;
                /*For Seminar and Executive Briefing*/
                $crts = DB::table('tab_training_status')
                        ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                        ->where('tab_training_status.status', 1)
                        ->whereIn('tab_training_status.user_id', $users)
                        ->select('crttrainings.training_type','tab_training_status.user_id')->get();
                
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $hogTrainingCnt = $hogTrainingCnt + 1;
                }
                }
                /* Course */
                foreach ($users as $i => $usr) {
                    $orders = Order::where('status', '=', 1)
                        ->where('user_id', $usr)
                        ->pluck('id');   
                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');
                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    if(count($purchased_courses)>0){
                        foreach($purchased_courses as $item){
                            /*For Course Progress*/
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $usr)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if(count($completed_lessons)>1){
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                }
                                else
                                {
                                    $progress = 100;
                                }

                            } else {
                                $progress = 0;
                            }
                            
                            /*isUserCertified*/
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $usr)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if($progress == 100 && $certifiedStatus == 1){
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
                }
                
                /*Course End*/
            }
            $hogCount = $hogTrainingCnt;
            $hogElearningCount = $eLearning;
            $hogSeminarCount = $seminarCnt;
            $hogExecutiveBriefingCount = $executiveBriefingCnt;
            /* HOD */
            /* CRT */
            $hodUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', 8)
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();
            $usrArr = array();
            $hodTrainingCnt = 0;
            $eLearning = 0;
            $seminarCnt = 0;
            $executiveBriefingCnt = 0;
            foreach ($hodUser as $key => $value) {
//                $hodCount = DB::table('tab_training_status')->where('status', 1)->where('user_id', $value->id)->count();
//                $hodTrainingCnt = $hodTrainingCnt + $hodCount;
                /*For Seminar and Executive Briefing*/
                $crts = DB::table('tab_training_status')
                        ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                        ->where('tab_training_status.status', 1)
                        ->where('tab_training_status.user_id', $value->id)
                        ->select('crttrainings.training_type','tab_training_status.user_id')->get();
                
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $hodTrainingCnt = $hodTrainingCnt + 1;
                }
                }
                
                /* Course */
//                foreach ($users as $i => $usr) {
                    $orders = Order::where('status', '=', 1)
                        ->where('user_id', $value->id)
                        ->pluck('id');   
                
                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    if(count($purchased_courses)>0){
                        foreach($purchased_courses as $item){
                            /*For Course Progress*/
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $value->id)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if(count($completed_lessons)>1){
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                }
                                else
                                {
                                    $progress = 100;
                                }

                            } else {
                                $progress = 0;
                            }
                            /*isUserCertified*/
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $value->id)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if($progress == 100 && $certifiedStatus == 1){
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
//                }
                
                /*Course End*/
            }
            $hodCount = $hodTrainingCnt;
            $hodElearningCount = $eLearning;
            $hodSeminarCount = $seminarCnt;
            $hodExecutiveBriefingCount = $executiveBriefingCnt;
                    
            
            /* SIO */
            /* CRT */
            $sioHirarchy = DB::select("SELECT GROUP_CONCAT(lv SEPARATOR ',') FROM (
			SELECT @pv:=(SELECT GROUP_CONCAT(id SEPARATOR ',') FROM department_role WHERE parent_id IN (@pv)) AS lv FROM department_role
							JOIN
							(SELECT @pv:=9)tmp
							WHERE parent_id IN (@pv)) a;");

            $sioHirArr = array(9);
            foreach ($sioHirarchy[0] as $hhk => $hhval) {
                $sioDeptRole = explode(",", $hhval);
                foreach ($sioDeptRole as $i => $v) {
                    $sioHirArr[] = $v;
                }
            }
            $sioUsr = array();
            $cnt = 0;
            foreach ($sioHirArr as $deptUsrRole) {
                if ($deptUsrRole == 9) {
                    $sioUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', $deptUsrRole)
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();
                    $usrArr = array();
                    foreach ($sioUser as $key => $value) {
                        $usrArr[] = $value->id;
                    }
                    $sioUsr[] = $usrArr;
                } else {
                    $sioUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', $deptUsrRole)
                            ->whereIn('user_details.reportingmanager_id', $sioUsr[$cnt - 1])
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();

                    $usrArr = array();
                    foreach ($sioUser as $key => $value) {
                        $usrArr[] = $value->id;
                    }
                    $sioUsr[] = $usrArr;
                }
                $cnt = $cnt + 1;
            }
            $sioTrainingCnt = 0;
            $eLearning = 0;
            $seminarCnt = 0;
            $executiveBriefingCnt = 0;
            foreach ($sioUsr as $key => $users) {
//                $sioCount = DB::table('tab_training_status')->where('status', 1)->whereIn('user_id', $users)->count();
//                $sioTrainingCnt = $sioTrainingCnt + $sioCount;
                /*For Seminar*/
                $crts = DB::table('tab_training_status')
                        ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                        ->where('tab_training_status.status', 1)
                        ->whereIn('tab_training_status.user_id', $users)
                        ->select('training_type')->get();
                
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $sioTrainingCnt = $sioTrainingCnt + 1;
                }
                }
                
                /* Course */
                foreach ($users as $i => $usr) {
                    $orders = Order::where('status', '=', 1)
                        ->where('user_id', $usr)
                        ->pluck('id');   
                
                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    if(count($purchased_courses)>0){
                        foreach($purchased_courses as $item){
                            /*For Course Progress*/
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $usr)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if(count($completed_lessons)>1){
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                }
                                else
                                {
                                    $progress = 100;
                                }

                            } else {
                                $progress = 0;
                            }
                            /*isUserCertified*/
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $usr)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if($progress == 100 && $certifiedStatus == 1){
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
                }
            }
            $sioCount = $sioTrainingCnt;
            $sioElearningCount = $eLearning;
            $sioSeminarCount = $seminarCnt;
            $sioExecutiveBriefingCount = $executiveBriefingCnt;
            
            /* SCO */
            /* CRT */
            $scoHirarchy = DB::select("SELECT GROUP_CONCAT(lv SEPARATOR ',') FROM (
			SELECT @pv:=(SELECT GROUP_CONCAT(id SEPARATOR ',') FROM department_role WHERE parent_id IN (@pv)) AS lv FROM department_role
							JOIN
							(SELECT @pv:=9)tmp
							WHERE parent_id IN (@pv)) a;");

            $scoHirArr = array(13);
            foreach ($scoHirarchy[0] as $hhk => $hhval) {
                $scoDeptRole = explode(",", $hhval);
                foreach ($scoDeptRole as $i => $v) {
                    $scoHirArr[] = $v;
                }
            }
            $scoUsr = array();
            $cnt = 0;
            foreach ($scoHirArr as $deptUsrRole) {
                if ($deptUsrRole == 13) {
                    $scoUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', $deptUsrRole)
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();
                    $usrArr = array();
                    foreach ($scoUser as $key => $value) {
                        $usrArr[] = $value->id;
                    }
                    $scoUsr[] = $usrArr;
                } else {
                    $scoUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->where('user_details.organisationaldept_role', $deptUsrRole)
                            ->whereIn('user_details.reportingmanager_id', $scoUsr[$cnt - 1])
                            ->where('users.active', 1)
                            ->select('users.id')
                            ->get();

                    $usrArr = array();
                    foreach ($scoUser as $key => $value) {
                        $usrArr[] = $value->id;
                    }
                    $scoUsr[] = $usrArr;
                }
                $cnt = $cnt + 1;
            }
            $scoTrainingCnt = 0;
            $eLearning = 0;
            $seminarCnt = 0;
            $executiveBriefingCnt = 0;
            foreach ($scoUsr as $key => $users) {
//                $scoCount = DB::table('tab_training_status')->where('status', 1)->whereIn('user_id', $users)->count();
//                $scoTrainingCnt = $scoTrainingCnt + $scoCount;
                /*For Seminar*/
                $crts = DB::table('tab_training_status')
                        ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                        ->where('tab_training_status.status', 1)
                        ->whereIn('tab_training_status.user_id', $users)
                        ->select('training_type')->get();
                
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $scoTrainingCnt = $scoTrainingCnt + 1;
                }
                }
                /* Course */
                foreach ($users as $i => $usr) {
                    $orders = Order::where('status', '=', 1)
                        ->where('user_id', $usr)
                        ->pluck('id');   
                
                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    if(count($purchased_courses)>0){
                        foreach($purchased_courses as $item){
                            /*For Course Progress*/
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $usr)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if(count($completed_lessons)>1){
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                }
                                else
                                {
                                    $progress = 100;
                                }

                            } else {
                                $progress = 0;
                            }
                            /*isUserCertified*/
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $usr)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if($progress == 100 && $certifiedStatus == 1){
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
                }
            }
            $scoCount = $scoTrainingCnt;
            $scoElearningCount = $eLearning;
            $scoSeminarCount = $seminarCnt;
            $scoExecutiveBriefingCount = $executiveBriefingCnt;
        } else {
            $userBricksArr = array();
            if ($usrRole != 0) {
                    $users = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                        ->join('department_role', 'user_details.organisationaldept_role', 'department_role.id')
                        ->where('users.id', $userId)
                        ->select('user_details.user_id', 'users.first_name', 'department_role.role_name')
                            ->get();
                    $userArr = array();
                    foreach ($users as $ukey => $uvalue) {
                        $userArr[$uvalue->user_id]['user_name'] = $uvalue->first_name;
                    $userArr[$uvalue->user_id]['dept_role'] = $usrRole;
                    $userArr[$uvalue->user_id]['dept_role_name'] = $uvalue->role_name;
                    }
                    foreach ($userArr as $uid => $udetail) {
                    $count = 0;
                    $eLearning = 0;
                    $seminarCnt = 0;
                    $executiveBriefingCnt = 0;

                    /* For Seminar and Executive Briefing */
                    $crts = DB::table('tab_training_status')->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $uid)->select('training_type')->get();

                    foreach ($crts as $crtkey => $crtvalue) {
                        /* Seminar Count */
                        if ($crtvalue->training_type == 5) {
                            $seminarCnt = $seminarCnt + 1;
                    }
                        /* Executive Briefing Count */
                        if ($crtvalue->training_type == 3) {
                            $executiveBriefingCnt = $executiveBriefingCnt + 1;
                }
                        /* CRT Training Count */
                        if ($crtvalue->training_type == 6) {
                            $count = $count + 1;
            }
        }
                    $userBricksArr[$uid]['name'] = $udetail['user_name'] . " (" . $udetail["dept_role_name"] . ")";
                    $userBricksArr[$uid]['dept_role'] = $udetail['dept_role'];

                    /* CRT Counts */
//                $deptroleArr[$uid]['count'] = $count;

                    /* Course */
                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $uid)
                            ->pluck('id');
                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    if (count($purchased_courses) > 0) {
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $uid)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $uid)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
                    $deptroleArr['crt']['name'] = $udetail['user_name'] . " (" . $udetail["dept_role_name"] . ")";
                    $deptroleArr['crt']['count'] = $count;
                    $deptroleArr['crt']['dept_role'] = $udetail['dept_role'];
                    $deptroleArr['crt']['user_id'] = $userId;
                    $deptroleArr['e_learning']['name'] = $udetail['user_name'] . " (" . $udetail["dept_role_name"] . ")";
                    $deptroleArr['e_learning']['count'] = $eLearning;
                    $deptroleArr['e_learning']['dept_role'] = $udetail['dept_role'];
                    $deptroleArr['e_learning']['user_id'] = $userId;
                    $deptroleArr['seminar']['name'] = $udetail['user_name'] . " (" . $udetail["dept_role_name"] . ")";
                    $deptroleArr['seminar']['count'] = $seminarCnt;
                    $deptroleArr['seminar']['dept_role'] = $udetail['dept_role'];
                    $deptroleArr['seminar']['user_id'] = $userId;
                    $deptroleArr['executive_briefing']['name'] = $udetail['user_name'] . " (" . $udetail["dept_role_name"] . ")";
                    $deptroleArr['executive_briefing']['count'] = $executiveBriefingCnt;
                    $deptroleArr['executive_briefing']['dept_role'] = $udetail['dept_role'];
                    $deptroleArr['executive_briefing']['user_id'] = $userId;
                }
                
                /*                 * * */

//                $ckRl = DB::table('department_role')->where('parent_id', $usrRole)->select('id')->get();
//                $deptAr = array();
//                if ($ckRl != "") {
//                    foreach ($ckRl as $dprk => $dprv) {
//                        $deptAr[] = $dprv->id;
//                    }
//                }
//                if (count($deptAr) > 0) {
//                    $users = DB::table('user_details')
//                            ->join('users', 'user_details.user_id', 'users.id')
//                            ->whereIn('user_details.organisationaldept_role', $deptAr)
//                            ->whereIn('user_details.reportingmanager_id', $userId)
//                            ->select('user_details.user_id', 'users.first_name', 'user_details.organisationaldept_role')
//                            ->get();
//                    $userArr = array();
//                    foreach ($users as $ukey => $uvalue) {
//                        $userArr[$uvalue->user_id]['user_name'] = $uvalue->first_name;
//                        $userArr[$uvalue->user_id]['dept_role'] = $uvalue->organisationaldept_role;
//                    }
//                    foreach ($userArr as $uid => $udetail) {
//                        $count = DB::table('tab_training_status')->where('status', 1)->where('user_id', $uid)->count();
//                        $deptroleArr[$uid]['name'] = $udetail['user_name'];
//                        $deptroleArr[$uid]['count'] = $count;
//                        $deptroleArr[$uid]['dept_role'] = $udetail['dept_role'];
//                    }
//                }
            }
        }
        
        /*Tabular Report*/
        /* Department Role*/
        $departmentRole = DB::table('organization_departments')
                            ->select('department_name','id')
                            ->where('department_id',$departmentId)
                            ->where('status',1)
                            ->pluck('department_name', 'id')->prepend('Department', '');
        /* Designation*/
        $designation = DB::table('designations')
                            ->select('designation','id')
                            ->where('department_id',$departmentId)
                            ->where('status',1)
                            ->pluck('designation', 'id')->prepend('Designation', '');
        /* State*/
        $state = DB::table('states')
                            ->select('state','id')
                            ->where('status',1)
                            ->pluck('state', 'id')->prepend('State', '');
        /* Training Types*/
//        $trainingTypes = DB::table('training_types')
//                            ->select('title','id')
//                            ->where('department_id',$departmentId)
//                            ->where('status',1)
//                            ->pluck('title', 'id')->prepend('Training Types', '');
        $trainingTypes = array("" => "Training Type","0" => "All","1" => "CRT Trainings","2" => "Seminar","3" => "Executive Breifing","4" => "Webinar","5" => "E-Learnings");
        
        return view('backend.elites.index', compact('hogCount', 'sioCount', 'scoCount', 'deptRole', 'deptroleArr', 'hogElearningCount', 'sioElearningCount', 'scoElearningCount','hogSeminarCount','sioSeminarCount','scoSeminarCount','hogExecutiveBriefingCount','sioExecutiveBriefingCount','scoExecutiveBriefingCount','hodCount','hodElearningCount','hodSeminarCount','hodExecutiveBriefingCount','departmentRole','designation','state','trainingTypes'));    }

    public function elitedashboard_chart() {
        /* --- Chart 1 --- */
        $param = explode(",", $_GET['id']);
        $id = $param[0];
        $level = 2;
        $tab = $param[2];
        if(isset($param[1])){
            $level = $param[1];
        }
//        $id = $_GET['id'];
        if($level == 1){
            $colorArr = array("#aedb7c", "#4bc0c0", "#ff9f40", "#36a2eb", "#11873c", "#e34a16", "#af8285", "#C0C0C0", "#808080", "#000000", "#FF0000", "#800000", "#FFFF00", "#808000", "#00FF00", "#008000", "#00FFFF", "#008080", "#0000FF", "#000080", "#FF00FF", "#800080");
            $user = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->join('departments', 'user_details.department_id', 'departments.id')
                            ->join('designations', 'user_details.designation_id', 'designations.id')
                            ->where('user_details.organisationaldept_role', $id)
                            ->where('users.active', 1)
                            ->select('users.first_name', 'users.id', 'users.emp_code','departments.department_name','designations.designation')->get();
            $labelArr = array();
            $chart1Arr = array();
            $chart2Arr = array();
            $dataArray = array();
            $dataset = array();
            $eLearning = 0;
            $cnt = 0;
            $crtCount = 0;
            foreach ($user as $labelkey => $userVal) {
//                $crtCount = DB::table('tab_training_status')->where('status', 1)->where('user_id', $userVal->id)->count();
                /*Chart 1 Data*/
                $chart1DataArr = array();
                $chart1DataArr['id'] = $userVal->id;
                $chart1DataArr['name'] = $userVal->first_name;
                $chart1DataArr['emp_code'] = $userVal->emp_code;
                $chart1DataArr['department'] = $userVal->department_name;
                $chart1DataArr['designation'] = $userVal->designation;
                /*E-learning*/
                $orders = Order::where('status', '=', 1)
                        ->where('user_id', $userVal->id)
                        ->pluck('id');
                $courses_id = OrderItem::whereIn('order_id', $orders)
                        ->where('item_type', '=', "App\Models\Course")
                        ->pluck('item_id');

                $purchased_courses = Course::whereIn('id', $courses_id)->get();
                if (count($purchased_courses) > 0) {
                    foreach ($purchased_courses as $item) {
                        /* For Course Progress */
                        $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $userVal->id)->get()->pluck('model_id')->toArray();

                        if (count($completed_lessons) > 0) {
                            if (count($completed_lessons) > 1) {
                                $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                            } else {
                                $progress = 100;
                            }
                        } else {
                            $progress = 0;
                        }
                        /* isUserCertified */
                        $certifiedStatus = 0;
                        $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $userVal->id)->first();
                        if ($certified != null) {
                            $certifiedStatus = 1;
                        }
                        if ($progress == 100 && $certifiedStatus == 1) {
                            $eLearning = $eLearning + 1;
                        }
                    }
                }
                /*For Seminar & Executive Briefing Count*/
                $executiveBriefingCnt = 0;
                $seminarCnt = 0;
                $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $userVal->id)->select('training_type')->get();
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $crtCount = $crtCount + 1;
                }
                }
                if($tab == "CRT"){
                    $dataArray[$userVal->first_name] = $crtCount;
                    $chart1DataArr['total_crt'] = $crtCount;
                }elseif($tab == "E-learning"){
                    $dataArray[$userVal->first_name] = $eLearning;
                    $chart1DataArr['total_crt'] = $eLearning;
                }elseif($tab == "seminar"){
                    $dataArray[$userVal->first_name] = $seminarCnt;
                    $chart1DataArr['total_crt'] = $seminarCnt;
                }elseif($tab == "Executive-Briefing"){
                    $dataArray[$userVal->first_name] = $executiveBriefingCnt;
                    $chart1DataArr['total_crt'] = $executiveBriefingCnt;
                }
                $chart1Arr[] = $chart1DataArr;
                
                /*Chart 2 Data*/
                $category = DB::table('categories')->where('status', 1)->select('id','name','short_name')->get();
                $chart2DataArr = array();
                $chart2DataArr['id'] = $userVal->id;
                $chart2DataArr['name'] = $userVal->first_name;
                $chart2DataArr['emp_code'] = $userVal->emp_code;
                $chart2DataArr['department'] = $userVal->department_name;
                $chart2DataArr['designation'] = $userVal->designation;
                foreach ($category as $key => $value) {
//                    $crtCnt = DB::table('tab_training_status')
//                            ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
//                            ->join('categories','crttrainings.category_id','categories.id')
//                            ->where('tab_training_status.status',1)
//                            ->where('tab_training_status.user_id',$userVal->id)
//                            ->where('crttrainings.category_id',$value->id)
//                            ->count();
                    
                    $seminarCntCat = 0;
                    $executiveBriefingCntCat = 0;
                    $eLearningCat = 0;
                    $crtCnt = 0;
                    $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $userVal->id)->where('crttrainings.category_id',$value->id)->select('training_type')->get();
                    foreach ($crts as $crtkey => $crtvalue) {
                        /*Seminar Count*/
                        if($crtvalue->training_type == 5){
                            $seminarCntCat = $seminarCntCat + 1;
                        }
                        /*Executive Briefing Count*/
                        if($crtvalue->training_type == 3){
                            $executiveBriefingCntCat = $executiveBriefingCntCat + 1;
                        }
                        /*CRT Training Count*/
                        if($crtvalue->training_type == 6){
                            $crtCnt = $crtCnt + 1;
                    }
                    }
                    /*For E-Learning*/
                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $userVal->id)
                            ->pluck('id');

                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id',$value->id)->get();
                    if (count($purchased_courses) > 0) {
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $userVal->id)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $userVal->id)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $eLearningCat = $eLearningCat + 1;
                            }
                        }
                    }
                       $chart2DataArr["_".$value->id."_"] = $crtCnt;
                       if($tab == "CRT"){
                            $chart2DataArr["_".$value->id."_"] = $crtCnt;
                        }elseif($tab == "E-learning"){
                            $chart2DataArr["_".$value->id."_"] = $eLearningCat;
                        }elseif($tab == "seminar"){
                            $chart2DataArr["_".$value->id."_"] = $seminarCntCat;
                        }elseif($tab == "Executive-Briefing"){
                            $chart2DataArr["_".$value->id."_"] = $executiveBriefingCntCat;
                        }
                }
                $chart2Arr[] = $chart2DataArr;


                $uarr = array();
                $categories = DB::table('categories')->where('status', 1)->select('short_name', 'id')->get();
                $catDataArr = array();
                foreach ($categories as $ckey => $cval) {
                    $attendedCrt = DB::table('tab_training_status')
                            ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
                            ->select('crttrainings.id')
                            ->where('tab_training_status.user_id', $userVal->id)
                            ->where('tab_training_status.status', 1)
                            ->where('crttrainings.category_id', $cval->id)
                            ->count();
                    $catDataArr[] = $attendedCrt;
                }

                $uarr['label'] = $userVal->first_name;
                $uarr['backgroundColor'] = $colorArr[$cnt];
                $uarr['data'] = $catDataArr;
                $dataset[] = $uarr;
                $cnt = $cnt + 1;
            }
            
            /* --- Chart 2 --- */
            $category = DB::table('categories')->where('status', 1)->select('short_name', 'id', 'name')->get();
            $categories = array();
            foreach ($category as $catKey => $catVal) {
                if ($catVal->short_name != "") {
                    $categories[] = $catVal->short_name;
                } else {
                    $categories[] = $catVal->name;
                }
            }
        }else{
            $colorArr = array("#aedb7c","#4bc0c0","#ff9f40","#36a2eb","#11873c","#e34a16","#af8285","#C0C0C0","#808080","#000000","#FF0000","#800000","#FFFF00","#808000","#00FF00","#008000","#00FFFF","#008080","#0000FF","#000080","#FF00FF","#800080");
            $user = DB::table('user_details')
                    ->join('users', 'user_details.user_id', 'users.id')
                    ->join('departments', 'user_details.department_id', 'departments.id')
                    ->join('designations', 'user_details.designation_id', 'designations.id')
                    ->where('user_details.user_id', $id)
                    ->where('users.active', 1)
                    ->select('users.first_name', 'users.id', 'users.emp_code','departments.department_name','designations.designation')->get();
            $labelArr = array();
            $chart1Arr = array();
            $chart2Arr = array();
            $dataArray = array();
            $dataset = array();
            $cnt = 0;
            $eLearning = 0;
            $crtCount = 0;
            foreach ($user as $labelkey => $userVal) {
//                $crtCount = DB::table('tab_training_status')->where('status', 1)->where('user_id', $userVal->id)->count();
                /*Chart 1 Data*/
                $chart1DataArr = array();
                $chart1DataArr['id'] = $userVal->id;
                $chart1DataArr['name'] = $userVal->first_name;
                $chart1DataArr['emp_code'] = $userVal->emp_code;
                $chart1DataArr['department'] = $userVal->department_name;
                $chart1DataArr['designation'] = $userVal->designation;
                /*E-learning*/
                $orders = Order::where('status', '=', 1)
                        ->where('user_id', $userVal->id)
                        ->pluck('id');
                $courses_id = OrderItem::whereIn('order_id', $orders)
                        ->where('item_type', '=', "App\Models\Course")
                        ->pluck('item_id');

                $purchased_courses = Course::whereIn('id', $courses_id)->get();
                if (count($purchased_courses) > 0) {
                    foreach ($purchased_courses as $item) {
                        /* For Course Progress */
                        $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $userVal->id)->get()->pluck('model_id')->toArray();

                        if (count($completed_lessons) > 0) {
                            if (count($completed_lessons) > 1) {
                                $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                            } else {
                                $progress = 100;
                            }
                        } else {
                            $progress = 0;
                        }
                        /* isUserCertified */
                        $certifiedStatus = 0;
                        $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $userVal->id)->first();
                        if ($certified != null) {
                            $certifiedStatus = 1;
                        }
                        if ($progress == 100 && $certifiedStatus == 1) {
                            $eLearning = $eLearning + 1;
                        }
                    }
                }
                /*For Seminar & Executive Briefing Count*/
                $executiveBriefingCnt = 0;
                $seminarCnt = 0;
                $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $userVal->id)->select('training_type')->get();
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $crtCount = $crtCount + 1;
                }
                }
                if($tab == "CRT"){
                    $dataArray[$userVal->first_name] = $crtCount;
                    $chart1DataArr['total_crt'] = $crtCount;
                }elseif($tab == "E-learning"){
                    $dataArray[$userVal->first_name] = $eLearning;
                    $chart1DataArr['total_crt'] = $eLearning;
                }elseif($tab == "seminar"){
                    $dataArray[$userVal->first_name] = $seminarCnt;
                    $chart1DataArr['total_crt'] = $seminarCnt;
                }elseif($tab == "Executive-Briefing"){
                    $dataArray[$userVal->first_name] = $executiveBriefingCnt;
                    $chart1DataArr['total_crt'] = $executiveBriefingCnt;
                }
                $chart1Arr[] = $chart1DataArr;
                
                /*Chart 2 Data*/
                $category = DB::table('categories')->where('status', 1)->select('id','name','short_name')->get();
                $chart2DataArr = array();
                $chart2DataArr['id'] = $userVal->id;
                $chart2DataArr['name'] = $userVal->first_name;
                $chart2DataArr['emp_code'] = $userVal->emp_code;
                $chart2DataArr['department'] = $userVal->department_name;
                $chart2DataArr['designation'] = $userVal->designation;
                foreach ($category as $key => $value) {
//                    $crtCnt = DB::table('tab_training_status')
//                            ->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')
//                            ->join('categories', 'crttrainings.category_id', 'categories.id')
//                            ->where('tab_training_status.status', 1)
//                            ->where('tab_training_status.user_id', $userVal->id)
//                            ->where('crttrainings.category_id', $value->id)
//                            ->count();
                    $seminarCntCat = 0;
                    $executiveBriefingCntCat = 0;
                    $eLearningCat = 0;
                    $crtCnt = 0;
                    $crts = DB::table('tab_training_status')->join('crttrainings', 'tab_training_status.crt_id', 'crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $userVal->id)->where('crttrainings.category_id', $value->id)->select('training_type')->get();
                    foreach ($crts as $crtkey => $crtvalue) {
                        /* Seminar Count */
                        if ($crtvalue->training_type == 5) {
                            $seminarCntCat = $seminarCntCat + 1;
                        }
                        /* Executive Briefing Count */
                        if ($crtvalue->training_type == 3) {
                            $executiveBriefingCntCat = $executiveBriefingCntCat + 1;
                        }
                        /* CRT Training Count */
                        if ($crtvalue->training_type == 6) {
                            $crtCnt = $crtCnt + 1;
                    }
                    }
                    /*E-learning*/
                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $userVal->id)
                            ->pluck('id');

                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id',$value->id)->get();
                    if (count($purchased_courses) > 0) {
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $userVal->id)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $userVal->id)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $eLearningCat = $eLearningCat + 1;
                            }
                        }
                    }
                    $chart2DataArr["_" . $value->id . "_"] = $crtCnt;
                    if ($tab == "CRT") {
                        $chart2DataArr["_" . $value->id . "_"] = $crtCnt;
                    } elseif ($tab == "E-learning") {
                        $chart2DataArr["_" . $value->id . "_"] = $eLearningCat;
                    } elseif ($tab == "seminar") {
                        $chart2DataArr["_" . $value->id . "_"] = $seminarCntCat;
                    } elseif ($tab == "Executive-Briefing") {
                        $chart2DataArr["_" . $value->id . "_"] = $executiveBriefingCntCat;
                    }


//                       $chart2DataArr["_".$value->id."_"] = $crtCnt;
                }
                $chart2Arr[] = $chart2DataArr;


                $uarr = array();
                $categories = DB::table('categories')->where('status', 1)->select('short_name','id')->get();
                $catDataArr = array();
                foreach ($categories as $ckey => $cval) {
                    $attendedCrt = DB::table('tab_training_status')
                            ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                            ->select('crttrainings.id')
                            ->where('tab_training_status.user_id', $userVal->id)
                            ->where('tab_training_status.status', 1)
                            ->where('crttrainings.category_id', $cval->id)
                            ->count();
                    $catDataArr[] = $attendedCrt;
                }


                $uarr['label'] = $userVal->first_name;
                $uarr['backgroundColor'] = $colorArr[$cnt];
                $uarr['data'] = $catDataArr;
                $dataset[] = $uarr;
                $cnt = $cnt + 1;
            }
            
            /* --- Chart 2 --- */
            $category = DB::table('categories')->where('status', 1)->select('short_name','id','name')->get();
            $categories = array();
            foreach ($category as $catKey => $catVal) {
                if($catVal->short_name != ""){
                    $categories[] = $catVal->short_name;
                }else{
                    $categories[] = $catVal->name;
                }
            }
        }
        
        arsort($dataArray);
        $dataArray = array_slice($dataArray, 0, 10, true);
        $labelArr = array();
        $dataArr = array();
        foreach ($dataArray as $key => $value) {
            $labelArr[] = $key;
            $dataArr[] = $value;
        }
        return view('backend.elites.elitedashboard_chart', compact('labelArr', 'dataArr', 'categories','dataset','chart1Arr','chart2Arr'));
    }

    public function elitedashboard_analytics() {
        return view('backend.elites.elitedashboard_analytics');
    }
    
    public function chart_ajax($id) {
        $param = explode(",", $id);
        $id = $param[0];
        $level = 2;
        $tab = $param[2];
        if(isset($param[1])){
            $level = $param[1];
        }
        if($level == 1){
            /* --- Chart 1 --- */
            $colorArr = array("#aedb7c","#4bc0c0","#ff9f40","#36a2eb","#11873c","#e34a16","#af8285","#C0C0C0","#808080","#000000","#FF0000","#800000","#FFFF00","#808000","#00FF00","#008000","#00FFFF","#008080","#0000FF","#000080","#FF00FF","#800080");
            $user = DB::table('user_details')->join('users', 'user_details.user_id', 'users.id')->where('organisationaldept_role', $id)->select('users.first_name', 'users.id')->get();
            $labelArr = array();
            $dataArr = array();
            $dataset = array();
            $seminarCnt = 0;
            $executiveBriefingCnt = 0;
            $cnt = 0;
            foreach ($user as $labelkey => $userVal) {
                $labelArr[] = $userVal->first_name;
                $crtCount = DB::table('tab_training_status')->where('status', 1)->where('user_id', $userVal->id)->count();
                $dataArr[] = $crtCount;


                $uarr = array();
                $categories = DB::table('categories')->where('status', 1)->select('short_name','id')->get();
                $catDataArr = array();
                foreach ($categories as $ckey => $cval) {
//                    $attendedCrt = DB::table('tab_training_status')
//                            ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
//                            ->select('crttrainings.id')
//                            ->where('tab_training_status.user_id', $userVal->id)
//                            ->where('tab_training_status.status', 1)
//                            ->where('crttrainings.category_id', $cval->id)
//                            ->count();
                    
                    /*For Seminar & Executive Briefing Count*/
                    $executiveBriefingCnt = 0;
                    $seminarCnt = 0;
                    $eLearning = 0;
                    $attendedCrt = 0;
                    $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $userVal->id)->where('crttrainings.category_id', $cval->id)->select('training_type')->get();
                    
                    foreach ($crts as $crtkey => $crtvalue) {
                        /*Seminar Count*/
                        if($crtvalue->training_type == 5){
                            $seminarCnt = $seminarCnt + 1;
                        }
                        /*Executive Briefing Count*/
                        if($crtvalue->training_type == 3){
                            $executiveBriefingCnt = $executiveBriefingCnt + 1;
                        }
                        /*CRT Training Count*/
                        if($crtvalue->training_type == 6){
                            $attendedCrt = $attendedCrt + 1;
                    }
                    }
                    /*For E-Learning*/
                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $userVal->id)
                            ->pluck('id');

                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id',$cval->id)->get();
                    if (count($purchased_courses) > 0) {
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $userVal->id)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $userVal->id)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
                    
                    if($tab == "CRT"){
                        $catDataArr[] = $attendedCrt;
                    }elseif($tab == "seminar"){
                        $catDataArr[] = $seminarCnt;
                    }elseif($tab == "Executive-Briefing"){
                        $catDataArr[] = $executiveBriefingCnt;
                    }elseif($tab == "E-learning"){
                        $catDataArr[] = $eLearning;
                    }
                }


                $uarr['label'] = $userVal->first_name;
                $uarr['backgroundColor'] = $colorArr[$cnt];
                $uarr['data'] = $catDataArr;
                $uarr['u_id'] = $userVal->id;
                $dataset[] = $uarr;
                $cnt = $cnt + 1;
            }
            /* --- Chart 2 --- */
            $category = DB::table('categories')->where('status', 1)->select('short_name','id', 'name')->get();
            $categories = array();
            foreach ($category as $catKey => $catVal) {
                if($catVal->short_name != ""){
                    $categories[] = $catVal->short_name;
                }else{
                    $categories[] = $catVal->name;
                }
            }
            $returnArr = array();
            $returnArr['category'] = $categories;
            $returnArr['dataset'] = $dataset;
        }else{
            /* --- Chart 1 --- */
            $colorArr = array("#aedb7c","#4bc0c0","#ff9f40","#36a2eb","#11873c","#e34a16","#af8285","#C0C0C0","#808080","#000000","#FF0000","#800000","#FFFF00","#808000","#00FF00","#008000","#00FFFF","#008080","#0000FF","#000080","#FF00FF","#800080");
            $user = DB::table('user_details')
                    ->join('users', 'user_details.user_id', 'users.id')
//                    ->where('organisationaldept_role', $id)
                    ->where('user_details.user_id', $id)
                    ->select('users.first_name', 'users.id')
                    ->get();
            $labelArr = array();
            $dataArr = array();
            $dataset = array();
            $cnt = 0;
            foreach ($user as $labelkey => $userVal) {
                $labelArr[] = $userVal->first_name;
                $crtCount = DB::table('tab_training_status')->where('status', 1)->where('user_id', $userVal->id)->count();
                $dataArr[] = $crtCount;


                $uarr = array();
                $categories = DB::table('categories')->where('status', 1)->select('short_name','id')->get();
                $catDataArr = array();
                foreach ($categories as $ckey => $cval) {
//                    $attendedCrt = DB::table('tab_training_status')
//                            ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
//                            ->select('crttrainings.id')
//                            ->where('tab_training_status.user_id', $userVal->id)
//                            ->where('tab_training_status.status', 1)
//                            ->where('crttrainings.category_id', $cval->id)
//                            ->count();
                    /*For Seminar & Executive Briefing Count*/
                    $executiveBriefingCnt = 0;
                    $seminarCnt = 0;
                    $eLearning = 0;
                    $attendedCrt = 0;
                    $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $userVal->id)->where('crttrainings.category_id', $cval->id)->select('training_type')->get();
                    
                    foreach ($crts as $crtkey => $crtvalue) {
                        /*Seminar Count*/
                        if($crtvalue->training_type == 5){
                            $seminarCnt = $seminarCnt + 1;
                        }
                        /*Executive Briefing Count*/
                        if($crtvalue->training_type == 3){
                            $executiveBriefingCnt = $executiveBriefingCnt + 1;
                        }
                        /*CRT Training Count*/
                        if($crtvalue->training_type == 6){
                            $attendedCrt = $executiveBriefingCnt + 1;
                    }
                    }
                    
                    /*For E-Learning*/
                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $userVal->id)
                            ->pluck('id');

                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id',$cval->id)->get();
                    if (count($purchased_courses) > 0) {
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $userVal->id)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $userVal->id)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $eLearning = $eLearning + 1;
                            }
                        }
                    }
                    
                    if($tab == "CRT"){
                        $catDataArr[] = $attendedCrt;
                    }elseif($tab == "seminar"){
                        $catDataArr[] = $seminarCnt;
                    }elseif($tab == "Executive-Briefing"){
                        $catDataArr[] = $executiveBriefingCnt;
                    }elseif($tab == "E-learning"){
                        $catDataArr[] = $eLearning;
                    }
//                    $catDataArr[] = $attendedCrt;
                }


                $uarr['label'] = $userVal->first_name;
                $uarr['backgroundColor'] = $colorArr[$cnt];
                $uarr['data'] = $catDataArr;
                $uarr['u_id'] = $userVal->id;
                $dataset[] = $uarr;
                $cnt = $cnt + 1;
            }
            /* --- Chart 2 --- */
            $category = DB::table('categories')->where('status', 1)->select('short_name','id','name')->get();
            $categories = array();
            foreach ($category as $catKey => $catVal) {
                if($catVal->short_name != ""){
                    $categories[] = $catVal->short_name;
                }else{
                    $categories[] = $catVal->name;
                }
            }
            $returnArr = array();
            $returnArr['category'] = $categories;
            $returnArr['dataset'] = $dataset;
        }
        
        
        
        return json_encode($returnArr, TRUE);
    }
    
    public function userAttendedTraining_ajax($id) {
        $crtDetail = DB::table('tab_training_status')
                    ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                    ->where('tab_training_status.user_id',$id)
                    ->where('tab_training_status.status',1)
                    ->select('title','start_date','end_date')
                    ->get();
        
        $returnArr = array();
            foreach ($crtDetail as $key => $value) {
                $crtDetails = array();
                $crtDetails['title'] = $value->title;
                $crtDetails['start_date'] = $value->start_date;
                $crtDetails['end_date'] = $value->end_date;
                $returnArr[] = $crtDetails;
            }
            
            return json_encode($returnArr, TRUE);
    }

    public function eliteTabFilter($param) {
        $params = explode(",", $param);
        $id = $params[0];
        $level = $params[1];
        $uId = $params[2];
        $tab = $params[3];
        $eLearning = 0;
        $seminarCnt = 0;
        $count = 0;
        $executiveBriefingCnt = 0;
        
        $deptroleArr = array();
        if ($level == 1) {
        
            $users = DB::table('user_details')
                    ->join('users', 'user_details.user_id', 'users.id')
                    ->join('department_role', 'user_details.organisationaldept_role', 'department_role.id')
                    ->where('user_details.organisationaldept_role', $id)
                    ->select('user_details.user_id', 'users.first_name','department_role.role_name')
                    ->get();
            $userArr = array();
            foreach ($users as $ukey => $uvalue) {
                $userArr[$uvalue->user_id]['user_name'] = $uvalue->first_name;
                $userArr[$uvalue->user_id]['dept_role'] = $id;
                $userArr[$uvalue->user_id]['dept_role_name'] = $uvalue->role_name;
            }
            foreach ($userArr as $uid => $udetail) {
                $eLearning = 0;
                $seminarCnt = 0;
                $executiveBriefingCnt = 0;
                
//                $count = DB::table('tab_training_status')->where('status', 1)->where('user_id', $uid)->count();
                /*For Seminar and Executive Briefing*/
                $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $uid)->select('training_type')->get();
                
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                    /*CRT Training Count*/
                    if($crtvalue->training_type == 6){
                        $count = $count + 1;
                }
                }
                $deptroleArr[$uid]['name'] = $udetail['user_name']." (".$udetail["dept_role_name"].")";
                $deptroleArr[$uid]['dept_role'] = $udetail['dept_role'];
                
                /* CRT Counts */
//                $deptroleArr[$uid]['count'] = $count;

                /* Course */
                $orders = Order::where('status', '=', 1)
                        ->where('user_id', $uid)
                        ->pluck('id');
                $courses_id = OrderItem::whereIn('order_id', $orders)
                        ->where('item_type', '=', "App\Models\Course")
                        ->pluck('item_id');

                $purchased_courses = Course::whereIn('id', $courses_id)->get();
                if (count($purchased_courses) > 0) {
                    foreach ($purchased_courses as $item) {
                        /* For Course Progress */
                        $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $uid)->get()->pluck('model_id')->toArray();

                        if (count($completed_lessons) > 0) {
                            if (count($completed_lessons) > 1) {
                                $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                            } else {
                                $progress = 100;
                            }
                        } else {
                            $progress = 0;
                        }
                        /* isUserCertified */
                        $certifiedStatus = 0;
                        $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $uid)->first();
                        if ($certified != null) {
                            $certifiedStatus = 1;
                        }
                        if ($progress == 100 && $certifiedStatus == 1) {
                            $eLearning = $eLearning + 1;
                        }
                    }
                }
                /* Course End */
                if ($tab == "CRT") {
                    /* CRT Counts */
                    $deptroleArr[$uid]['count'] = $count;
                } elseif ($tab == "E-learning") {
                    /* E-learning Counts */
                    $deptroleArr[$uid]['count'] = $eLearning;
                } elseif ($tab == "seminar") {
                    /* Seminar Counts */
                    $deptroleArr[$uid]['count'] = $seminarCnt;
                } elseif ($tab == "Executive-Briefing") {
                    /* Executive Briefing Counts */
                    $deptroleArr[$uid]['count'] = $executiveBriefingCnt;
                }
                
                $deptroleArr[$uid]['tab'] = $tab;
            }
        } elseif ($level == 2) {
            
            $deptRole = DB::table('department_role')->where('parent_id', $id)->select('id', 'role_name')->get();
            $userArr = array();
            foreach ($deptRole as $key => $value) {
                $users = DB::table('user_details')
                        ->join('users', 'user_details.user_id', 'users.id')
                        ->where('user_details.organisationaldept_role', $value->id)
                        ->where('user_details.reportingmanager_id', $uId)
                        ->where('users.active', 1)
                        ->select('user_details.user_id', 'users.first_name')
                        ->get();
                
                foreach ($users as $ukey => $uvalue) {
                    $userArr[$uvalue->user_id]['user_name'] = $uvalue->first_name;
                    $userArr[$uvalue->user_id]['dept_role'] = $value->id;
                    $userArr[$uvalue->user_id]['dept_role_name'] = $value->role_name;
                }
            }
            foreach ($userArr as $uid => $udetail) {
                $eLearning = 0;
                $seminarCnt = 0;
                $executiveBriefingCnt = 0;
            
                $count = DB::table('tab_training_status')->where('status', 1)->where('user_id', $uid)->count();
                /*For Seminar and Executive Briefing*/
                $crts = DB::table('tab_training_status')->join('crttrainings','tab_training_status.crt_id','crttrainings.id')->where('tab_training_status.status', 1)->where('tab_training_status.user_id', $uid)->select('training_type')->get();
                
                foreach ($crts as $crtkey => $crtvalue) {
                    /*Seminar Count*/
                    if($crtvalue->training_type == 5){
                        $seminarCnt = $seminarCnt + 1;
                    }
                    /*Executive Briefing Count*/
                    if($crtvalue->training_type == 3){
                        $executiveBriefingCnt = $executiveBriefingCnt + 1;
                    }
                }
                $deptroleArr[$uid]['name'] = $udetail['user_name']." (".$udetail["dept_role_name"].")";
//                $deptroleArr[$uid]['count'] = $count;
                $deptroleArr[$uid]['dept_role'] = $udetail['dept_role'];
                /* Course */
                $orders = Order::where('status', '=', 1)
                        ->where('user_id', $uid)
                        ->pluck('id');
               
                $courses_id = OrderItem::whereIn('order_id', $orders)
                        ->where('item_type', '=', "App\Models\Course")
                        ->pluck('item_id');
                $purchased_courses = Course::whereIn('id', $courses_id)->get();
                if (count($purchased_courses) > 0) {
                    
                    foreach ($purchased_courses as $item) {
                        /* For Course Progress */
                        $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $uid)->get()->pluck('model_id')->toArray();
                        if (count($completed_lessons) > 0) {
                            if (count($completed_lessons) > 1) {
                                $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                            } else {
                                $progress = 100;
                            }
                        } else {
                            $progress = 0;
                        }                        
                        /* isUserCertified */
                        $certifiedStatus = 0;
                        $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $uid)->first();
                        if ($certified != null) {
                            $certifiedStatus = 1;
                        }
                        if ($progress == 100 && $certifiedStatus == 1) {
                            $eLearning = $eLearning + 1;
                        }
                    }
                }
                /* Course End */
                if ($tab == "CRT") {
                    /* CRT Counts */
                    $deptroleArr[$uid]['count'] = $count;
                } elseif ($tab == "E-learning") {
                    /* E-learning Counts */
                    $deptroleArr[$uid]['count'] = $eLearning;
                } elseif ($tab == "seminar") {
                    /* Seminar Counts */
                    $deptroleArr[$uid]['count'] = $seminarCnt;
                } elseif ($tab == "Executive-Briefing") {
                    /* Executive Briefing Counts */
                    $deptroleArr[$uid]['count'] = $executiveBriefingCnt;
                }
                $deptroleArr[$uid]['tab'] = $tab;
            }
        }
        
        return json_encode($deptroleArr);
    }
    
    public function chart1user_ajax($param){
        $params = explode(",", $param);
        $id = $params[0];
        $tab = $params[1];
        if($tab == "CRT"){
            $crtDetails = DB::table('tab_training_status')
                ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                ->join('venues','crttrainings.venue_id','venues.id')
                ->join('users','tab_training_status.user_id','users.id')
                ->where('tab_training_status.status', 1)
                ->where('tab_training_status.user_id', $id)
                ->where('crttrainings.training_type', 6)
                ->select('users.first_name','crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')
                ->get();
        }elseif($tab == "seminar"){
            $crtDetails = DB::table('tab_training_status')
                ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                ->join('venues','crttrainings.venue_id','venues.id')
                ->join('users','tab_training_status.user_id','users.id')
                ->where('tab_training_status.status', 1)
                ->where('tab_training_status.user_id', $id)
                ->where('crttrainings.training_type', 5)
                ->select('users.first_name','crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')
                ->get();
        }elseif($tab == "Executive-Briefing"){
            $crtDetails = DB::table('tab_training_status')
                ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                ->join('venues','crttrainings.venue_id','venues.id')
                ->join('users','tab_training_status.user_id','users.id')
                ->where('tab_training_status.status', 1)
                ->where('tab_training_status.user_id', $id)
                ->where('crttrainings.training_type', 3)
                ->select('users.first_name','crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')
                ->get();
        }elseif($tab=="E-learning"){
            $courseArr=array();
            $orders = Order::where('status', '=', 1)
                    ->where('user_id', $id)
                    ->pluck('id');

            $courses_id = OrderItem::whereIn('order_id', $orders)
                    ->where('item_type', '=', "App\Models\Course")
                    ->pluck('item_id');

            $purchased_courses = Course::whereIn('id', $courses_id)->get();
            if (count($purchased_courses) > 0) {
                $courseData = array();
                foreach ($purchased_courses as $item) {
                    /* For Course Progress */
                    $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $id)->get()->pluck('model_id')->toArray();

                    if (count($completed_lessons) > 0) {
                        if (count($completed_lessons) > 1) {
                            $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                        } else {
                            $progress = 100;
                        }
                    } else {
                        $progress = 0;
                    }
                    /* isUserCertified */
                    $certifiedStatus = 0;
                    $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $id)->first();
                    if ($certified != null) {
                        $certifiedStatus = 1;
                    }
                    if ($progress == 100 && $certifiedStatus == 1) {
                        $courseData['title'] = $item->title;
                        $courseArr[] = $courseData;
                    }
                }
            }
        }
        
        if($tab=="E-learning"){
            $user = DB::table('users')->where('id',$id)->select('first_name')->first();
            $return = array();
            $return['name'] = $user->first_name;
            $return['tab'] = $tab;
            $return['crt_data'] = $courseArr;
            return json_encode($return);
        }else{
            $returnArr = array();
            $userName = "";
            foreach ($crtDetails as $i => $crtData) {
                    $dataArr = array();
                    $userName = $crtData->first_name;
                    $dataArr['title'] = $crtData->title;
                    $dataArr['duration'] = $crtData->start_date." - ".$crtData->end_date;
                    $dataArr['venue'] = $crtData->address;
                    $returnArr[] = $dataArr;
                }
            $return = array();
            $return['name'] = $userName;
            $return['tab'] = $tab;
            $return['crt_data'] = $returnArr;
            return json_encode($return);
        }
        
        
        
    }
    
    public function chart2user_ajax($param){
        $params = explode(",", $param);
        $id = $params[0];
        $cat_id = $params[1];
        $tab = $params[2];
        
        if($tab == "CRT"){
            $crtDetails = DB::table('tab_training_status')
                ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                ->join('venues','crttrainings.venue_id','venues.id')
                ->join('users','tab_training_status.user_id','users.id')
                ->where('tab_training_status.status', 1)
                ->where('tab_training_status.user_id', $id)
                ->where('crttrainings.category_id', $cat_id)
                ->where('crttrainings.training_type', 6)
                ->select('users.first_name','crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')
                ->get();
        }elseif($tab == "seminar"){
            $crtDetails = DB::table('tab_training_status')
                ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                ->join('venues','crttrainings.venue_id','venues.id')
                ->join('users','tab_training_status.user_id','users.id')
                ->where('tab_training_status.status', 1)
                ->where('tab_training_status.user_id', $id)
                ->where('crttrainings.category_id', $cat_id)
                ->where('crttrainings.training_type', 5)
                ->select('users.first_name','crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')
                ->get();
           
        }elseif($tab == "Executive-Briefing"){
            $crtDetails = DB::table('tab_training_status')
                ->join('crttrainings','tab_training_status.crt_id','crttrainings.id')
                ->join('venues','crttrainings.venue_id','venues.id')
                ->join('users','tab_training_status.user_id','users.id')
                ->where('tab_training_status.status', 1)
                ->where('tab_training_status.user_id', $id)
                ->where('crttrainings.category_id', $cat_id)
                ->where('crttrainings.training_type', 3)
                ->select('users.first_name','crttrainings.title','crttrainings.start_date','crttrainings.end_date','venues.address')
                ->get();
        }elseif($tab=="E-learning"){
            $courseArr=array();
            $orders = Order::where('status', '=', 1)
                    ->where('user_id', $id)
                    ->pluck('id');

            $courses_id = OrderItem::whereIn('order_id', $orders)
                    ->where('item_type', '=', "App\Models\Course")
                    ->pluck('item_id');

            $purchased_courses = Course::whereIn('id', $courses_id)->where('category_id',$cat_id)->get();
            if (count($purchased_courses) > 0) {
                $courseData = array();
                foreach ($purchased_courses as $item) {
                    /* For Course Progress */
                    $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $id)->get()->pluck('model_id')->toArray();

                    if (count($completed_lessons) > 0) {
                        if (count($completed_lessons) > 1) {
                            $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                        } else {
                            $progress = 100;
                        }
                    } else {
                        $progress = 0;
                    }
                    /* isUserCertified */
                    $certifiedStatus = 0;
                    $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $id)->first();
                    if ($certified != null) {
                        $certifiedStatus = 1;
                    }
                    if ($progress == 100 && $certifiedStatus == 1) {
                        $courseData['title'] = $item->title;
                    }
                }
                $courseArr[] = $courseData;
            }
        }
        if($tab=="E-learning"){
            $user = DB::table('users')->where('id',$id)->select('first_name')->first();
            $return = array();
            $return['name'] = $user->first_name;
            $return['tab'] = $tab;
            $return['crt_data'] = $courseArr;
            return json_encode($return);
        }else{
            $returnArr = array();
            $userName = "";
            foreach ($crtDetails as $i => $crtData) {
                    $dataArr = array();
                    $userName = $crtData->first_name;
                    $dataArr['title'] = $crtData->title;
                    $dataArr['duration'] = $crtData->start_date." - ".$crtData->end_date;
                    $dataArr['venue'] = $crtData->address;
                    $returnArr[] = $dataArr;
                }
            $return = array();
            $return['name'] = $userName;
            $return['tab'] = $tab;
            $return['crt_data'] = $returnArr;
            return json_encode($return);
        }
        
        
        
    }

    public function getData(Request $request){
        $deptRole = 0;
        $designation = 0;
        $state = 0;
        $trainingType = 0;
        $userArr = array();
        $deptRoleQry = "";
        $desgQry = "";
        $stateQry = "";
        $usrLocation = "";
        $bricksCrt = 0;
        $bricksSeminar = 0;
        $bricksExeBrief = 0;
        $bricksWebinar = 0;
        $bricksElearning = 0;
        
        $userId = auth()->user()->id;
        $userRole = DB::table('user_details')->where('user_id', $userId)->select('organisationaldept_role','department_id')->first();
        $ogDeptRole = 0;
        if($userRole !=""){
        $ogDeptRole = $userRole->organisationaldept_role;
        }
        
        $deptRoleArr = array();
        $loginUsrChild = DB::table('department_role')->where('parent_id',$ogDeptRole)->select('id')->get();  
        foreach ($loginUsrChild as $ud) {
            $deptRoleArr[] = $ud->id;
        }
        
        $hogUser = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->whereIn('user_details.organisationaldept_role', $deptRoleArr)
                            ->where('user_details.reportingmanager_id', $userId)
                            ->where('users.active', 1)
                            ->select('users.id','user_details.organisationaldept_role')
                            ->get();
        
        $usArr = array($userId);
        foreach ($hogUser as $udata) {
            $drArr = array();
            $userChild = DB::table('department_role')->where('parent_id',$udata->organisationaldept_role)->select('id')->get();  
            foreach ($userChild as $ud) {
                $drArr[] = $ud->id;
            }
            $hogUser1 = DB::table('user_details')
                            ->join('users', 'user_details.user_id', 'users.id')
                            ->whereIn('user_details.organisationaldept_role', $drArr)
                            ->where('user_details.reportingmanager_id', $udata->id)
                            ->where('users.active', 1)
                            ->select('users.id','user_details.organisationaldept_role')
                            ->get();
            $usArr[] = $udata->id;
                foreach ($hogUser1 as $udata1) {
                    $usArr[] = $udata1->id;
                }
        }
        $userQry = "";
        $userQryCourse = "";
        $filteruserQry = "";
        if($ogDeptRole != 6){
            $userQry = ' AND tts.user_id IN ('.  implode(",", $usArr).')';
            $userQryCourse = ' AND o.user_id IN ('.  implode(",", $usArr).')';
            $filteruserQry = ' AND ud.user_id IN ('.  implode(",", $usArr).')';
        }
        
        if (isset($request->deptRole) && $request->deptRole != "") {
            $deptRole = $request->deptRole;
            $deptRoleQry = ' AND ud.organisationaldept_id = ' . $deptRole;
}
        if (isset($request->designation) && $request->designation != "") {
            $designation = $request->designation;
            $desgQry = ' AND ud.designation_id = ' . $designation;
        }
        if (isset($request->state) && $request->state != "") {
            $state = $request->state;
            $stateQry = ' AND crt.state_id = ' . $state;
            
            /*For Course*/
            $courseState = array();
            $location = DB::table('locations')->where('state_id',$state)->select('id')->get();
            foreach ($location as $key => $value) {
                $courseState[] = $value->id;
            }
            if(count($courseState) > 0){
               $usrLocation = ' AND ud.office_id IN ('.implode(",", $courseState).')';
            }else{
                $usrLocation = ' AND ud.office_id IN (0)';
            }
            
        }
        
        $filterUser = DB::select("SELECT u.id FROM users AS u JOIN user_details AS ud ON (ud.user_id = u.id) WHERE active = 1". $deptRoleQry . $desgQry . $usrLocation . $filteruserQry);
        
        
        if (isset($request->trainingType) && $request->trainingType != "" && $request->trainingType != 0) {
            $trainingType = $request->trainingType;
//            
//            if ($trainingType == 5) {
//                $orders = DB::select("SELECT o.user_id, o.id, ud.organisationaldept_id FROM orders AS o
//                                        JOIN user_details AS ud ON (ud.user_id = o.user_id)
//                                        WHERE o.status = 1" . $deptRoleQry . $desgQry . $usrLocation . $userQryCourse);
//                $courseuser = array();
//                foreach ($orders as $okey => $orderVal) {
//                    $courseuser[] = (object) array('user_id' => $orderVal->user_id);
//                }
//            } else {
//                if ($trainingType == 1) {
//                    $training = 6;
//                } elseif ($trainingType == 2) {
//                    $training = 5;
//                } elseif ($trainingType == 3) {
//                    $training = 3;
//                } elseif ($trainingType == 4) {
//                    $training = 4;
//                }
//                
//                $crt = DB::select("SELECT tts.user_id FROM crttrainings AS crt
//                    JOIN tab_training_status AS tts ON (crt.id = tts.crt_id)
//                    JOIN user_details AS ud ON (ud.user_id = tts.user_id)
//                    WHERE tts.status = 1" . $deptRoleQry . $desgQry . $stateQry . $userQry . " AND crt.training_type =" . $training);
//            }
            } else {
//            $crt = DB::select("SELECT tts.user_id FROM crttrainings AS crt
//                    JOIN tab_training_status AS tts ON (crt.id = tts.crt_id)
//                    JOIN user_details AS ud ON (ud.user_id = tts.user_id)
//                    WHERE tts.status = 1" . $deptRoleQry . $desgQry . $stateQry . $userQry);
//            
//            $orders = DB::select("SELECT o.user_id, o.id FROM orders AS o
//                                        JOIN user_details AS ud ON (ud.user_id = o.user_id)
//                                        WHERE o.status = 1" . $deptRoleQry . $desgQry . $usrLocation . $userQryCourse);
//
//            $courseuser = array();
//            foreach ($orders as $okey => $orderVal) {
//                $courseuser[] = (object) array('user_id' => $orderVal->user_id);
//            }
                }
            
//        if (isset($crt)) {
//            foreach ($crt as $userData) {
//                if (!in_array($userData->user_id, $userArr)) {
//                    $userArr[] = $userData->user_id;
//                }
//            }
//        }
        foreach ($filterUser as $fuser) {
            if (!in_array($fuser->id, $userArr)) {
                $userArr[] = $fuser->id;
            }
        }
        $tabularArr = array();
        if ($trainingType == 0 || $trainingType == "") {
//            if (count($courseuser) > 0) {
//                foreach ($courseuser as $key => $value) {
//                    if (!in_array($value->user_id, $userArr)) {
//                        $userArr[] = $value->user_id;
//                    }
//                }
//            }
            if (count($userArr) > 0) {
                foreach ($userArr as $user_data) {
                    $crtCnt = 0;
                    $seminarCnt = 0;
                    $executive_breifingCnt = 0;
                    $webinarCnt = 0;
                    $e_learningCnt = 0;
                    $crtDetails = DB::table('crttrainings')
                                    ->join('tab_training_status', 'crttrainings.id', 'tab_training_status.crt_id')
                                    ->where('tab_training_status.user_id', $user_data)
                                    ->where('tab_training_status.status', 1)
                                    ->select('crttrainings.training_type', 'tab_training_status.crt_id', 'tab_training_status.user_id')->get();
                    foreach ($crtDetails as $crtkey => $crtValue) {
                        if ($crtValue->training_type == 6) {
                            /* CRT Count */
                            $crtCnt = $crtCnt + 1;
                            $bricksCrt = $bricksCrt + 1;
                        } elseif ($crtValue->training_type == 5) {
                            /* Seminar Count */
                            $seminarCnt = $seminarCnt + 1;
                            $bricksSeminar = $bricksSeminar + 1;
                        } elseif ($crtValue->training_type == 3) {
                            /* Executive Briefing Count */
                            $executive_breifingCnt = $executive_breifingCnt + 1;
                            $bricksExeBrief = $bricksExeBrief + 1;
                        } elseif ($crtValue->training_type == 4) {
                            /* Webinar Count */
                            $webinarCnt = $webinarCnt + 1;
                            $bricksWebinar = $bricksWebinar + 1;
                        }
                    }
                    
                    /*Course Count*/
                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $user_data)
                            ->pluck('id');

                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    if (count($purchased_courses) > 0) {
                        $courseData = array();
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $user_data)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $user_data)->first();
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $e_learningCnt = $e_learningCnt + 1;
                                $bricksElearning = $bricksElearning + 1;
                            }
                        }
                    }
                    
                    $usersData = DB::table('users')
                            ->join('user_details', 'users.id', 'user_details.user_id')
                            ->join('designations', 'user_details.designation_id', 'designations.id')
                            ->join('organization_departments', 'user_details.organisationaldept_id', 'organization_departments.id')
                            ->where('users.id', $user_data)
                            ->select('users.emp_code', 'users.first_name', 'organization_departments.department_name', 'designations.designation')
                            ->first();

                    if ($usersData != "") {
                        $tabularArr[$user_data]['emp_code'] = $usersData->emp_code;
                        $tabularArr[$user_data]['user_name'] = $usersData->first_name;
                        $tabularArr[$user_data]['designation'] = $usersData->designation;
                        $tabularArr[$user_data]['department'] = $usersData->department_name;
                        $tabularArr[$user_data]['crt'] = $crtCnt;
                        $tabularArr[$user_data]['seminar'] = $seminarCnt;
                        $tabularArr[$user_data]['executive_breifing'] = $executive_breifingCnt;
                        $tabularArr[$user_data]['webinar'] = $webinarCnt;
                        $tabularArr[$user_data]['e_learning'] = $e_learningCnt;
                    }
                }
            }
        } elseif ($trainingType == 5) {
//            if (count($courseuser) > 0) {
//                $userArr = array();
//                foreach ($courseuser as $key => $value) {
//                    if (!in_array($value->user_id, $userArr)) {
//                        $userArr[] = $value->user_id;
//                    }
//                }
                foreach ($userArr as $ck => $cval) {
                    $courseCnt = 0;
                    $crtCnt = 0;
                    $seminarCnt = 0;
                    $executive_breifingCnt = 0;
                    $webinarCnt = 0;

                    $orders = Order::where('status', '=', 1)
                            ->where('user_id', $cval)
                            ->pluck('id');

                    $courses_id = OrderItem::whereIn('order_id', $orders)
                            ->where('item_type', '=', "App\Models\Course")
                            ->pluck('item_id');

                    $purchased_courses = Course::whereIn('id', $courses_id)->get();
                    $cflg=0; 
                    if (count($purchased_courses) > 0) {
                        $courseData = array();
                        foreach ($purchased_courses as $item) {
                            /* For Course Progress */
                            $completed_lessons = DB::table('chapter_students')->where('course_id', $item->id)->where('user_id', $cval)->get()->pluck('model_id')->toArray();

                            if (count($completed_lessons) > 0) {
                                if (count($completed_lessons) > 1) {
                                    $progress = intval(count($completed_lessons) / $item->courseTimeline->count() * 100);
                                } else {
                                    $progress = 100;
                                }
                            } else {
                                $progress = 0;
                            }
                            /* isUserCertified */
                            $certifiedStatus = 0;
                            $certified = DB::table('certificates')->where('course_id', '=', $item->id)->where('user_id', $cval)->first();
                            
                            if ($certified != null) {
                                $certifiedStatus = 1;
                            }
                            if ($progress == 100 && $certifiedStatus == 1) {
                                $courseCnt = $courseCnt + 1;
                                $bricksElearning = $bricksElearning + 1;
                                $cflg=1;
                            }
                        }
                    }
                    if($cflg==1){
                    $usersData = DB::table('users')
                            ->join('user_details', 'users.id', 'user_details.user_id')
                            ->join('designations', 'user_details.designation_id', 'designations.id')
                            ->join('organization_departments', 'user_details.organisationaldept_id', 'organization_departments.id')
                            ->where('users.id', $cval)
                            ->select('users.emp_code', 'users.first_name', 'organization_departments.department_name', 'designations.designation')
                            ->first();

                    if (isset($usersData) && $usersData != "") {
                        $tabularArr[$cval]['emp_code'] = $usersData->emp_code;
                        $tabularArr[$cval]['user_name'] = $usersData->first_name;
                        $tabularArr[$cval]['designation'] = $usersData->designation;
                        $tabularArr[$cval]['department'] = $usersData->department_name;
                        $tabularArr[$cval]['crt'] = $crtCnt;
                        $tabularArr[$cval]['seminar'] = $seminarCnt;
                        $tabularArr[$cval]['executive_breifing'] = $executive_breifingCnt;
                        $tabularArr[$cval]['webinar'] = $webinarCnt;
                        $tabularArr[$cval]['e_learning'] = $courseCnt;
                    }
                }
            }
//            }
        } else {
            if ($trainingType == 1) {
                $training = 6;
            } elseif ($trainingType == 2) {
                $training = 5;
            } elseif ($trainingType == 3) {
                $training = 3;
            } elseif ($trainingType == 4) {
                $training = 4;
            }
            if (count($userArr) > 0) {
                foreach ($userArr as $user_data) {
                    $crtCnt = 0;
                    $seminarCnt = 0;
                    $executive_breifingCnt = 0;
                    $webinarCnt = 0;
                    $e_learningCnt = 0;
                    $crtDetails = DB::table('crttrainings')
                                    ->join('tab_training_status', 'crttrainings.id', 'tab_training_status.crt_id')
                                    ->where('tab_training_status.user_id', $user_data)
                                    ->where('tab_training_status.status', 1)
                                    ->where('crttrainings.training_type', $training)
                                    ->select('crttrainings.training_type', 'tab_training_status.crt_id', 'tab_training_status.user_id')->get();
                    if(count($crtDetails) > 0){
                    foreach ($crtDetails as $crtkey => $crtValue) {
                        if ($crtValue->training_type == 6) {
                            /* CRT Count */
                            $crtCnt = $crtCnt + 1;
                            $bricksCrt = $bricksCrt + 1;
                        } elseif ($crtValue->training_type == 5) {
                            /* Seminar Count */
                            $seminarCnt = $seminarCnt + 1;
                            $bricksSeminar = $bricksSeminar + 1;
                        } elseif ($crtValue->training_type == 3) {
                            /* Executive Briefing Count */
                            $executive_breifingCnt = $executive_breifingCnt + 1;
                            $bricksExeBrief = $bricksExeBrief + 1;
                        } elseif ($crtValue->training_type == 4) {
                            /* Webinar Count */
                            $webinarCnt = $webinarCnt + 1;
                            $bricksWebinar = $bricksWebinar + 1;
                        }
                    }
                    $usersData = DB::table('users')
                            ->join('user_details', 'users.id', 'user_details.user_id')
                            ->join('designations', 'user_details.designation_id', 'designations.id')
                            ->join('organization_departments', 'user_details.organisationaldept_id', 'organization_departments.id')
                            ->where('users.id', $user_data)
                            ->select('users.emp_code', 'users.first_name', 'organization_departments.department_name', 'designations.designation')
                            ->first();

                    if ($usersData != "") {
                        $tabularArr[$user_data]['emp_code'] = $usersData->emp_code;
                        $tabularArr[$user_data]['user_name'] = $usersData->first_name;
                        $tabularArr[$user_data]['designation'] = $usersData->designation;
                        $tabularArr[$user_data]['department'] = $usersData->department_name;
                        $tabularArr[$user_data]['crt'] = $crtCnt;
                        $tabularArr[$user_data]['seminar'] = $seminarCnt;
                        $tabularArr[$user_data]['executive_breifing'] = $executive_breifingCnt;
                        $tabularArr[$user_data]['webinar'] = $webinarCnt;
                        $tabularArr[$user_data]['e_learning'] = $e_learningCnt;
                    }
                }
            }
        }
        }
        $returnArr = array();
        $returnArr['tabular_data'] = $tabularArr;
        $returnArr['crt_cnt'] = $bricksCrt;
        $returnArr['seminar_cnt'] = $bricksSeminar;
        $returnArr['exeBrief_cnt'] = $bricksExeBrief;
        $returnArr['webinar_cnt'] = $bricksWebinar;
        $returnArr['elearning_cnt'] = $bricksElearning;

        return json_encode($returnArr);
    }

}
