<?php

namespace Yazdan\Payment\Gateways\Zarinpal;

use Yazdan\Payment\App\Models\Payment;
use Yazdan\Payment\Contracts\GatewayContract;

class ZarinpalAdaptor implements GatewayContract
{

    private $url;
    private $client;

    public function request($amount, $description)
    {
        $MerchantID     = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $Amount         = $amount;
        $Description     = $description;
        $Email             = "";
        $Mobile         = "";
        $CallbackURL     = route('payment.callback');
        $ZarinGate         = false;
        $SandBox         = true;

        $this->client     = new zarinpal();
        $result = $this->client->request($MerchantID, $Amount, $Description, $Email, $Mobile, $CallbackURL, $SandBox, $ZarinGate);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            // Success and redirect to pay
            $this->url = $result["StartPay"];
            return $result["Authority"];
        } else {
            // error
            return [
                'status' => $result["Status"],
                'message' => $result["Message"]
            ];
        }
    }

    public function verify(Payment $payment)
    {

        $MerchantID     = "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx";
        $Amount         = $payment->amount;
        $SandBox         = true;
        $ZarinGate         = false;

        $this->client = new zarinpal();

        $result = $this->client->verify($MerchantID, $Amount, $SandBox, $ZarinGate);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            // Success
            return $result["RefID"];
        } else {
            // error
            return [
                'status' => $result["Status"],
                'message' => $result["Message"]
            ];
        }
    }

    public function redirect()
    {
        $this->client->redirect($this->url);
    }

    public function getName()
    {
        return 'zarinpal';
    }
}
