<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        // $event = Event::where("id", $id)->first();
        // if (empty($event)) {
        //     // TODO: イベントが存在しない場合、Not Found 404. にリダイレクト
        //     return view("errors.404");
        // }

        // $stripeId = Auth::user()->stripe_id;
        // if (empty($stripeId)) {
        //     // Stripe未登録の場合
        //     $stripeCustomer = Auth::user()->createAsStripeCustomer();
        //     $stripeId = $stripeCustomer->id;
        // }

        // Log::channel('debug')->debug($event);

        // return view("payment.show", compact(["event"]));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    /**
     * Stripe決済処理
     */
    public function charge(Request $request)
    {
        // PaymentService::charge($request);
    }
}
