<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\PaymentGateway\Services\PaymentGatewayService;
use Modules\PaymentGateway\Transformers\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    protected $paymentGatewayService;

    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->paymentGatewayService = $paymentGatewayService;
    }
    public function list()
    {
        $gateway_activations = $this->paymentGatewayService->gateway_activations()
            ->makeHidden([
                'module_status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
            ]);
        return PaymentMethodResource::collection($gateway_activations);
    }
}
