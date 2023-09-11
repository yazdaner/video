<?php

namespace Yazdan\Course\App\Http\Controllers;


use App\Http\Controllers\Controller;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\App\Models\Season;
use Yazdan\Common\Responses\AjaxResponses;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Course\Repositories\SeasonRepository;
use Yazdan\Course\App\Http\Requests\SeasonRequest;
use Yazdan\Course\App\Policies\SeasonPolicy;

class SeasonController extends Controller
{
    public function store(SeasonRequest $request, $courseId)
    {
        $course = CourseRepository::findById($courseId);
        $this->authorize('createSeason', $course);
        SeasonRepository::store($request, $courseId);
        newFeedbacks();
        return back();
    }

    public function edit($id)
    {
        $season = SeasonRepository::findById($id);
        $this->authorize('edit', $season);

        return view('Season::edit', compact('season'));
    }

    public function update(SeasonRequest $request, $id)
    {
        $season = SeasonRepository::findById($id);
        $this->authorize('edit', $season);

        SeasonRepository::update($request, $id);
        newFeedbacks();
        return redirect()->route('admin.courses.details', $season->course->id);
    }

    public function destroy($id)
    {
        $course = SeasonRepository::findById($id);
        $this->authorize('delete', $course);
        $course->delete();
        return AjaxResponses::SuccessResponses();
    }

    public function accepted($id)
    {
        $this->authorize('accepted', Season::class);
        if (SeasonRepository::UpdateConfirmationStatus($id, SeasonRepository::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }

    public function rejected($id)
    {
        $this->authorize('rejected', Season::class);
        if (SeasonRepository::UpdateConfirmationStatus($id, SeasonRepository::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponses();
        }
        return AjaxResponses::ErrorResponses();
    }
}
