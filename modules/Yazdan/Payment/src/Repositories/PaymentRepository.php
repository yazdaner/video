<?php

namespace Yazdan\Payment\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Yazdan\Payment\App\Models\Payment;

class PaymentRepository
{
    const CONFIRMATION_STATUS_PENDING = 'pending';
    const CONFIRMATION_STATUS_SUCCESS = 'success';
    const CONFIRMATION_STATUS_FAIL = 'fail';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_SUCCESS, self::CONFIRMATION_STATUS_PENDING, self::CONFIRMATION_STATUS_FAIL];


    public function store($data)
    {
        return Payment::create([
            'user_id' => $data['user_id'],
            'paymentable_id' => $data['paymentable_id'],
            'paymentable_type' => $data['paymentable_type'],
            'amount' => $data['amount'],
            'invoice_id' => $data['invoice_id'],
            'gateway' => $data['gateway'],
            'status' => $data['status'],
            'seller_percent' => $data['seller_percent'],
            'seller_share' => $data['seller_share'],
            'site_share' => $data['site_share'],

        ]);
    }

    public function findByInvoiceId($invoiceId)
    {
        return Payment::where('invoice_id',$invoiceId)->first();
    }

    public function changeStatus($paymentId,string $status)
    {
        return Payment::where('id',$paymentId)->update([
            'status' => $status
        ]);

    }

    public function paginate()
    {
        return Payment::query()->latest()->paginate();
    }



    public function lastNDaysPayments(string $status,$days = null)
    {
        $query = Payment::query();
        if(!is_null($days))
        {
            $query = $query->where('created_at','>=',now()->addDays($days));
        }
        return $query->where('status',$status)->latest();
    }

    public function lastNDaysSuccessPayments($days = null)
    {
        return $this->lastNDaysPayments(self::CONFIRMATION_STATUS_SUCCESS,$days);
    }
    public function lastNDaysFailPayments($days = null)
    {
        return $this->lastNDaysPayments(self::CONFIRMATION_STATUS_FAIL,$days);
    }

    public function lastNDaysSuccessTotal($days = null)
    {
        return $this->lastNDaysSuccessPayments($days)->sum('amount');
    }

    public function getDayPayments($day,string $status)
    {
        return Payment::query()->whereDate('created_at',$day)->where('status',$status)->latest();
    }

    public function getDaySuccessPayments($day)
    {
        return $this->getDayPayments($day,self::CONFIRMATION_STATUS_SUCCESS);
    }

    public function getDayFailPayments($day)
    {
        return $this->getDayPayments($day,self::CONFIRMATION_STATUS_FAIL);
    }

    public function getDaySuccessPaymentsTotal($day)
    {
        return $this->getDaySuccessPayments($day)->sum('amount');
    }

    public function getDayFailPaymentsTotal($day)
    {
        return $this->getDayFailPayments($day)->sum('amount');
    }


    public function getAllSuccessTotal($days = null)
    {
        return $this->lastNDaysSuccessPayments($days)->sum("amount");
    }

    public function getAllFailTotal($days = null)
    {
        return $this->lastNDaysFailPayments($days)->sum("amount");
    }


    public function getSuccessDailySummery(Collection $dates)
    {
        return Payment::query()->where('status','success')->where("created_at", ">=", $dates->keys()->first())
        ->groupBy("date")
        ->orderBy("date")
        ->get([
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(amount) as totalAmount"),
        ]);
    }

    public function getFailDailySummery(Collection $dates)
    {
        return Payment::query()->where('status','fail')->where("created_at", ">=", $dates->keys()->first())
        ->groupBy("date")
        ->orderBy("date")
        ->get([
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(amount) as totalAmount"),
        ]);
    }

}



