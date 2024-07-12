<?php

namespace App\Domain\Services;

use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Net\MPSearchRequest;

class MercadoPagoService
{

    public string $token = 'MP_TOKEN';
    public string $accessToken = 'MP_ACCESS_TOKEN';

    private PreferenceClient $client;
    private PaymentClient $payment;

    public function __construct()
    {
        MercadoPagoConfig::setAccessToken($this->accessToken);
        $this->client = new PreferenceClient();
        $this->payment = new PaymentClient();
    }

    public function checkPayments(int $paymentId): array
    {
        try {
            $payment = $this->payment->get($paymentId);

            return json_decode(json_encode($payment), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function searchPayment(string $external): array
    {
        try {
            $searchRequest = new MPSearchRequest(
                10,
                0,
                [
                    'external_reference' => $external
                ]
            );

            $payment = $this->payment->search($searchRequest);

            return json_decode(json_encode($payment), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
