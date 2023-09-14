<?php

namespace Yazdan\Payment\App\Models;

use Illuminate\Database\Eloquent\Model;
use Yazdan\Discount\App\Models\Discount;
use Yazdan\Payment\Repositories\PaymentRepository;
use Yazdan\User\App\Models\User;

class Payment extends Model
{
    protected $table = 'payments';
    protected $guarded = [];

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, "discount_payment");
    }

    public function getConfirmStatusAttribute()
    {
        switch ($this->status) {
            case PaymentRepository::CONFIRMATION_STATUS_SUCCESS:
                return 'text-success';
                break;
            case PaymentRepository::CONFIRMATION_STATUS_FAIL:
                return 'text-error';
                break;
            default:
                return '';
                break;
        }
    }

}
