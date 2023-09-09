<?php

namespace Yazdan\Front\App\Http\Controllers;

use Yazdan\User\App\Models\User;
use App\Http\Controllers\Controller;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\RolePermissions\Repositories\RoleRepository;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class FrontController extends Controller
{

    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug)
    {
        $course = CourseRepository::findBySlug($slug);
        if($course == null){
            return abort(404);
        }
        if(request()->lesson){
            $lesson = CourseRepository::getLesson($course->id,request()->lesson);
        }
        else{
            $lesson = CourseRepository::getFirstLesson($course->id);
        }
        $lessons = CourseRepository::getLessons($course->id);
        return view('Front::singleCourse',compact('course','lessons','lesson'));
    }

    public function singleTutor($username)
    {
        $tutor = User::permission(PermissionRepository::PERMISSION_TEACH)->where('username',$username)->first();
        if($tutor == null){
            abort(404);
        }
        return view('Front::tutor',compact('tutor'));
    }
}
