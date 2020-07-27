@extends('layouts.app')

@section('content')
<div class="continaer">
    @if($currentEvent == null)
        <h4>現在の予定はありません。</h4>
        <p>医師から診療予定が追加されるまでお待ちください。</p>
    @else
        <div class="row-100 bg-grey pad-5">
                <img class="center-block img-responsive remedy-logo bg-grey" src="{{ asset('img/remedy-pc/logo.png') }}" align="">
        </div>
        <div class="text-center mgr-btm-5">
            <img class="center-block img-responsive profile" src="{{ asset('img/patient_profile.png') }}" align="">
            <span style="color:black; font-size:1.5em;">{{ \Auth::user()->name }}さん<br></span>
        </div>

        <div class="bg-grey text-center"><br>
            <div class="blue-emphasis center-block">病院情報<br></div><br>
            <span style="font-size:13px; font-weight:bold; color:black; line-height:170%;">
                {{ $currentEvent->clinic_name }}<br>
                担当医：{{ $currentEvent->doctor_name }}<br>
                {{ $currentEvent->email}}<br>
            </span>
            <br>
            <div class="blue-emphasis center-block">次回診察日<br></div><br>
            <span style="color:black; font-size:22px; font-weight: bold; line-height:150%;">
                {{ $currentEvent->start }}</br>
            </span>
            <span style="font-size:8px; color: #FF3366; line-height:0px;">
                お時間になりましたら「ビデオ診察開始」を押してください<br>
            </span>
            <button class="btn-start">ビデオ診察開始</button>

        </div>
    @endif
</div>

<!-- 以下、編集前データ -->

<!-- <div class="continaer">
    <div class="row-100 bg-grey pad-5">
            <img class="center-block img-responsive remedy-logo bg-grey" src="{{ asset('img/remedy-pc/logo.png') }}" align="">
    </div>
    <div class="text-center mgr-btm-5">
        <img class="center-block img-responsive profile" src="{{ asset('img/patient_profile.png') }}" align="">
        <span style="color:black; font-size:1.5em;">{{ \Auth::user()->name }}さん<br></span>
    </div>

    <div class="bg-grey text-center"><br>
        <div class="blue-emphasis center-block">病院情報<br></div><br>
        <span style="font-size:13px; font-weight:bold; color:black; line-height:170%;">
            愛知県立病院<br>
            担当者：鈴木　隆信<br>
            020-1234-6789<br>
        </span>
        <br>
        <div class="blue-emphasis center-block">次回診察日<br></div><br>
        <span style="color:black; font-size:22px; font-weight: bold; line-height:150%;">
            2020年09月01日(水)<br>
            10時30分開始<br>
        </span>
        <span style="font-size:8px; color: #FF3366; line-height:0px;">
            お時間になりましたら「ビデオ診察開始」を押してください<br>
        </span>
        <button class="btn-start">ビデオ診察開始</button>

    </div>
</div> -->

<!-- 以上、編集前データ -->

@endsection
@include('footer')
