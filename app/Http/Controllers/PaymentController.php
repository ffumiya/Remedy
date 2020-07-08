<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where("id", $id)->first();
        if (empty($event)) {
            // TODO: イベントが存在しない場合、Not Found 404. にリダイレクト
            return view("errors.404");
        }

        $stripeId = \Auth::user()->stripe_id;
        if (empty($stripeId)) {
            // Stripe未登録の場合
            $stripeCustomer = \Auth::user()->createAsStripeCustomer();
            $stripeId = $stripeCustomer->id;
        }

        \Log::channel('debug')->debug($event);

        return view("payment.show", compact(["event"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Stripe決済処理
     */
    public function charge(Request $request)
    {
        PaymentService::charge($request);
    }
}
