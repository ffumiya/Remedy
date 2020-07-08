<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\Price;

class PaymentService extends BaseService
{
    public static function charge(Request $request)
    {
        try {
            $event_id = $request->id;
            $paymentMethodId = $request->paymentMethodId;
            $price = PriceService::calcIncludeTax($request->price);
            \Log::channel("debug")->debug($paymentMethodId);

            $stripeId = \Auth::user()->stripe_id;
            $user = Cashier::findBillable($stripeId);


            $stripeCharge = $user->charge($price, $paymentMethodId);
        } catch (Exception $e) {
            \Log::channel("debug")->debug($e);
        }
    }
}
