@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('payment.charge') }}" class="card p-4 m-5" id="payment-form" method="POST">
        @csrf
        <input type="hidden" name="id" id="id" value="{{ $event->event_id }}">
        <div class="row m-2">
            <div class="col text-center">
                <h1>Remedy</h1>
                <div class="mt-5">
                    <div class="row">
                        <div class="col">
                            <label for="price">オンライン診療基本料金</label>
                        </div>
                        <div class="col">
                            <h2>{{ $event->price }}</h2>
                            <input type="hidden" name="price" value="{{ $event->price }}">
                        </div>
                    </div>
                </div>
                <p>お支払い期日：2020/6/30</p>
            </div>
        </div>
        <div class="row m-2">
            <div class="col">
                <label for="card-number">カード番号</label>
                <div id="card-number"></div>
            </div>
        </div>
        <div class="row m-2">
            <div class="col">
                <label for="card-holder-name">カード名義</label>
                <input class="form-control" id="card-holder-name" name="card-holder-name" type="text">
            </div>
        </div>
        <div class="row m-2">
            <div class="col">
                <label for="card-valid">有効期限</label>
                <div id="card-expiry"></div>
            </div>
            <div class="col">
                <label for="card-cvc">セキュリティコード</label>
                <div id="card-cvc"></div>
            </div>
        </div>
        {{-- <div class="row m-2">
            <div class="col">
                <label for="card-element">クレジットカード or デビットカード</label>
                <div id="card-element"></div>
            </div>
        </div> --}}
        <div class="row m-2">
            <div class="col">
                <div id="error-element"></div>
            </div>
        </div>
        <div class="row m-2">
            <div class="col">
                <button type="submit" class="btn btn-primary btn-block">お支払い</button>
                {{-- <div id="payment-request-button"></div> --}}
            </div>
        </div>

    </form>
</div>
@endsection


@section('script')
<script type="text/javascript" src="https://js.stripe.com/v3/" defer></script>
<script type="text/javascript" src="{{ asset('js/payment.js') }}" defer></script>
<script>
    const key = "{{ config('payment.stripe_key') }}";
</script>
@endsection
