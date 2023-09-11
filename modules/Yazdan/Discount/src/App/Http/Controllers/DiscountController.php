<?php

namespace Yazdan\Discount\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Yazdan\Discount\App\Models\Discount;
use Yazdan\Common\Responses\AjaxResponses;
use Yazdan\Course\Repositories\CourseRepository;
use Yazdan\Discount\Repositories\DiscountRepository;
use Yazdan\Discount\App\Http\Requests\DiscountRequest;

class DiscountController extends Controller
{
    public function index()
    {
        $this->authorize('manage',Discount::class);
        $discounts = DiscountRepository::paginateAll();
        $courses = CourseRepository::getAll(CourseRepository::CONFIRMATION_STATUS_ACCEPTED);
        return view('Discount::admin.index',compact('courses','discounts'));
    }

    public function store(DiscountRequest $request)
    {
        $this->authorize('manage',Discount::class);

        DiscountRepository::store($request->all());

        newFeedbacks();

        return back();
    }

    public function edit(Discount $discount)
    {
        $this->authorize('manage',Discount::class);

        $courses = CourseRepository::getAll(CourseRepository::CONFIRMATION_STATUS_ACCEPTED);
        return view("Discount::admin.edit", compact("discount", "courses"));
    }

    public function update(Discount $discount, DiscountRequest $request)
    {
        $this->authorize('manage',Discount::class);

        DiscountRepository::update($discount->id, $request->all());
        newFeedbacks();
        return redirect()->route("admin.discounts.index");

    }

    public function destroy(Discount $discount)
    {
        $this->authorize('manage',Discount::class);

        $discount->delete();
        return AjaxResponses::SuccessResponses();
    }
}
