<?php

namespace Yazdan\Payment\App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Controllers\Controller;
use Yazdan\Payment\Gateways\Gateway;
use Yazdan\Payment\App\Models\Payment;
use Yazdan\Payment\Repositories\PaymentRepository;
use Yazdan\Payment\App\Events\PaymentWasSuccessful;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $repository = resolve(PaymentRepository::class);
        $payment = $repository->findByInvoiceId($request->Authority);

        // Error
        if (is_null($payment)) {
            newFeedbacks('نا موفق', 'تراکنش یافت نشد', 'error');
            return redirect('/');
        };

        $result = $gateway->verify($payment);

        if (is_array($result)) {
            // Error
            $repository->changeStatus($payment->id, $repository::CONFIRMATION_STATUS_FAIL);
            newFeedbacks('نا موفق', $result['message'], 'error');
        } else {
            // Success
            event(new PaymentWasSuccessful($payment));
            $repository->changeStatus($payment->id, $repository::CONFIRMATION_STATUS_SUCCESS);
            newFeedbacks('عملیات موفق', 'پرداخت با موفقیت انجام شد', 'success');
        }

        return redirect()->to($payment->paymentable->path());
    }

    public function index(PaymentRepository $paymentRepository, Request $request)
    {
        $this->authorize('index',Payment::class);
        $payments = $paymentRepository
            ->searchEmail($request->email)
            ->searchAmount($request->amount)
            ->searchInvoiceId($request->invoice_id)
            ->searchAfterDate(dateFromJalali($request->start_date))
            ->searchBeforeDate(dateFromJalali($request->end_date))
            ->paginate();
        $last30DaysTotal = $paymentRepository->lastNDaysSuccessTotal(-30);
        $totalSell = $paymentRepository->lastNDaysSuccessTotal();
        $todaySell = $paymentRepository->lastNDaysSuccessTotal(-1);
        $thisWeekSell = $paymentRepository->lastNDaysSuccessTotal(-7);
        $last30Days = CarbonPeriod::create(now()->addDays(-30),now());


        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }
        $successSummery =  $paymentRepository->getSuccessDailySummery($dates);
        $failSummery =  $paymentRepository->getFailDailySummery($dates);

        return view('Payment::admin.index',compact('payments','last30DaysTotal','totalSell','todaySell','thisWeekSell','last30Days','paymentRepository','dates','successSummery','failSummery'));
    }
}
