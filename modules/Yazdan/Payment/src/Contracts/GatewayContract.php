<?php

namespace Yazdan\Payment\Contracts;

use Yazdan\Payment\App\Models\Payment;

interface GatewayContract
{
    public function request($amount,$description);

    public function verify(Payment $payment);

    public function redirect();
    public function getName();

}
