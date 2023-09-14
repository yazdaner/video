<?php

namespace Yazdan\Course\App\Listeners;

use Yazdan\Course\App\Models\Course;
use Yazdan\Course\Repositories\CourseRepository;

class RegisterUserInTheCourse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $payment = $event->payment;
        if($payment->paymentable_type == Course::class){
            resolve(CourseRepository::class)->addStudentToCourse($payment->paymentable,$payment->user_id);
        }
    }
}
