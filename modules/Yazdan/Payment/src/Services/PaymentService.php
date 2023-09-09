<?php

namespace Yazdan\Payment\Services;

use Yazdan\User\App\Models\User;
use Yazdan\Payment\Gateways\Gateway;
use Yazdan\Payment\Repositories\PaymentRepository;

class PaymentService {

    public static function generate($paymentable,User $user,$amount)
    {

        if($amount <= 0 || is_null($paymentable->id) || is_null($user->id) ) return false;

        $gateway = resolve(Gateway::class);
        $invoice_id = $gateway->request($amount,$paymentable->title);

        if(is_array($invoice_id)){
            dd($invoice_id);
        }

        if(isset($paymentable->percent)){
            $seller_percent = $paymentable->percent;
            $seller_share = ($amount * $seller_percent) / 100;
            $site_share = $amount - $seller_share;

        }else{
            $seller_percent = $seller_share = 0;
            $site_share = $amount;
        }

        return resolve(PaymentRepository::class)->store([
            'user_id' => $user->id,
            'paymentable_id' => $paymentable->id,
            'paymentable_type' => get_class($paymentable),
            'amount' => $amount,
            'invoice_id' => $invoice_id,
            'gateway' => $gateway->getName(),
            'status' => PaymentRepository::CONFIRMATION_STATUS_PENDING,
            'seller_percent' => $seller_percent,
            'seller_share' => $seller_share,
            'site_share' => $site_share,
        ]);
    }

}
