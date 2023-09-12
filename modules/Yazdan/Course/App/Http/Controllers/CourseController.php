<?php

namespace Yazdan\Course\App\Http\Controllers;

use Yazdan\Payment\Gateways\Gateway;
use App\Http\Controllers\Controller;
use Yazdan\Course\App\Models\Course;
use Yazdan\Common\Responses\AjaxResponses;
use Yazdan\Media\Services\MediaFileService;
use Yazdan\Payment\Services\PaymentService;
use Yazdan\User\Repositories\UserRepository;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Course\Repositories\LessonRepository;

use Yazdan\Course\App\Http\Requests\CourseRequest;
use Yazdan\Category\Repositories\CategoryRepository;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class CourseController extends Controller
{

    public function index()
    {
        $this->authorize('index', Course::class);
        if (auth()->user()->hasPermissionTo(PermissionRepository::PERMISSION_MANAGE_COURSES) || auth()->user()->hasPermissionTo(PermissionRepository::PERMISSION_SUPER_ADMIN)) {
            $courses = CourseRepository::paginate(10);
        } else {
            $courses = CourseRepository::usersCoursepaginate(auth()->id(), 10);
        }
        return view('Course::index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);

        $types = CourseRepository::$types;
        $statuses = CourseRepository::$statuses;
        $confirmationStatuses = CourseRepository::$confirmationStatuses;

        $teachers = UserRepository::getTeachers();
        $categories = CategoryRepository::getAll();
        return view('Course::create', compact('teachers', 'categories', 'types', 'statuses', 'confirmationStatuses'));
    }

    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);
        if (isset($request->image)) {
            $images = MediaFileService::publicUpload($request->image);
            $request->request->add(['banner_id' => $images->id]);
        }
        CourseRepository::store($request);
        newFeedbacks();
        return redirect(route('admin.courses.index'));
    }

    public function edit($id)
    {
        $course = CourseRepository::findById($id);
        $this->authorize('edit', $course);

        $types = CourseRepository::$types;
        $statuses = CourseRepository::$statuses;
        $confirmationStatuses = CourseRepository::$confirmationStatuses;

        $teachers = UserRepository::getTeachers();
        $categories = CategoryRepository::getAll();

        return view('Course::edit', compact('course', 'teachers', 'categories', 'types', 'statuses', 'confirmationStatuses'));
    }

    public function update($id, CourseRequest $request)
    {
        $course = CourseRepository::findById($id);
        $this->authorize('edit', $course);

        if ($request->hasFile('image')) {

            if ($course->banner) {
                $course->banner->delete();
            }
            $images = MediaFileService::publicUpload($request->image);
            $request->request->add(['banner_id' => $images->id]);
        } else {
            if ($course->banner) {
                $request->request->add(['banner_id' => $course->banner->id]);
            }
        }
        CourseRepository::update($id, $request);
        newFeedbacks();
        return redirect(route('admin.courses.index'));
    }

    public function destroy($id)
    {
        $this->authorize('delete', Course::class);

        $course = CourseRepository::findById($id);

        if ($course->banner) {
            $course->banner->delete();
        }

        $course->delete();
        return AjaxResponses::SuccessResponses();
    }


    public function accepted($id)
    {
        $this->authorize('accepted', Course::class);

        if (CourseRepository::UpdateConfirmationStatus($id, CourseRepository::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function rejected($id)
    {
        $this->authorize('rejected', Course::class);

        if (CourseRepository::UpdateConfirmationStatus($id, CourseRepository::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function details($id)
    {
        $course = CourseRepository::findById($id);
        $this->authorize('details', $course);
        $lessons = LessonRepository::CourseLessonPaginate($course->id, 15);
        $this->authorize('details', $course);
        return view('Course::details', compact('course', 'lessons'));
    }

    public function buy($courseId)
    {
        $course = CourseRepository::findById($courseId);
        if (!$this->courseCanBePurchased($course)) {
            return back();
        }
        if (!$this->authUserCanPurchaseCourse($course)) {
            return back();
        }

        $user = auth()->user();
        $amount = $course->finalPrice(request()->code);
        if($amount <= 0){
            resolve(CourseRepository::class)->addStudentToCourse($course,$user);
            newFeedbacks();
            return redirect($course->path());
        }
        PaymentService::generate($course,$user,$amount);
        resolve(Gateway::class)->redirect();
    }

    private function courseCanBePurchased(Course $course)
    {
        if ($course->type == CourseRepository::TYPE_FREE) {
            newFeedbacks('نا موفق', 'این دوره قابل خریداری نیست', 'error');
            return false;
        }
        if ($course->status == CourseRepository::STATUS_LOCKED) {
            newFeedbacks('نا موفق', 'این دوره قابل خریداری نیست', 'error');
            return false;
        };
        if ($course->confirmation_status != CourseRepository::CONFIRMATION_STATUS_ACCEPTED) {
            newFeedbacks('نا موفق', 'این دوره قابل خریداری نیست', 'error');
            return false;
        };

        return true;
    }

    private function authUserCanPurchaseCourse(Course $course)
    {
        if (auth()->id() == $course->teacher_id) {
            newFeedbacks('نا موفق', 'شما مدرس این دوره هستید', 'error');
            return false;
        }

        if (auth()->user()->hasAccessToCourse($course)) {
            newFeedbacks('نا موفق', 'شما به دوره دسترسی دارید', 'error');
            return false;
        }

        return true;
    }
}
