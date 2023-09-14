<?php

namespace Yazdan\Course\App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yazdan\Common\Responses\AjaxResponses;
use Yazdan\Course\App\Http\Requests\LessonRequest;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Course\Repositories\LessonRepository;
use Yazdan\Media\Services\MediaFileService;

class LessonController extends Controller
{
    public function create($courseId)
    {
        $course = CourseRepository::findById($courseId);
        $this->authorize('createLesson',$course);

        $seasons = LessonRepository::getSeasonsCourse($course->id);
        return view('Lesson::create', compact('seasons', 'course'));
    }

    public function store($courseId, LessonRequest $request)
    {
        $course = CourseRepository::findById($courseId);
        $this->authorize('createLesson',$course);

        if ($request->has('lesson_file')) {
            $request->request->add(['media_id' => MediaFileService::privateUpload($request->file('lesson_file'))->id]);
        }
        LessonRepository::store($request, $courseId);
        newFeedbacks();
        return redirect()->route('admin.courses.details', $courseId);
    }

    public function edit($id)
    {
        $lesson = LessonRepository::findById($id);
        $this->authorize('edit',$lesson);

        $seasons = LessonRepository::getSeasonsCourse($lesson->course->id);
        return view('Lesson::edit', compact('lesson','seasons'));
    }

    public function update($id,LessonRequest $request)
    {
        $lesson = LessonRepository::findById($id);
        $this->authorize('edit',$lesson);

        if($request->hasFile('lesson_file')){

            if($lesson->media) $lesson->media->delete();

            $file = MediaFileService::privateUpload($request->lesson_file);
            $request->request->add(['media_id' => $file->id]);

        }else{
            if($lesson->media) $request->request->add(['media_id' => $lesson->media->id]);
        }
        LessonRepository::update($id,$request);
        newFeedbacks();
        return redirect()->route('admin.courses.details', $lesson->course->id);
    }

    public function destroy($id)
    {
        $lesson = LessonRepository::findById($id);
        $this->authorize('destroy',$lesson);

        if ($lesson->media) {
            $lesson->media->delete();
        }
        $lesson->delete();
        return AjaxResponses::SuccessResponses();
    }

    public function destroyMultiple(Request $request)
    {
        $this->authorize('delete',Course::class);

        foreach ($request->ids as $id) {
            $lesson = LessonRepository::findById($id);
            if ($lesson->media) {
                $lesson->media->delete();
            }
            $lesson->delete();
        }
        return AjaxResponses::SuccessResponses();
    }

    public function accepted($id)
    {
        $this->authorize('accepted',Course::class);

        if (LessonRepository::UpdateConfirmationStatus($id, LessonRepository::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function acceptedMultiple(Request $request)
    {
        $this->authorize('accepted',Course::class);

        if (LessonRepository::UpdateConfirmationStatus($request->ids, LessonRepository::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function acceptAll($courseId)
    {
        $this->authorize('accepted',Course::class);

        LessonRepository::actionAll($courseId,LessonRepository::CONFIRMATION_STATUS_ACCEPTED);
        return AjaxResponses::SuccessResponses();
    }

    public function rejected($id)
    {
        $this->authorize('rejected',Course::class);


        if (LessonRepository::UpdateConfirmationStatus($id, LessonRepository::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function rejectedMultiple(Request $request)
    {
        $this->authorize('rejected',Course::class);

        if (LessonRepository::UpdateConfirmationStatus($request->ids, LessonRepository::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function rejectAll($courseId)
    {
        $this->authorize('rejected',Course::class);

        LessonRepository::actionAll($courseId,LessonRepository::CONFIRMATION_STATUS_REJECTED);
        return AjaxResponses::SuccessResponses();
    }

}
