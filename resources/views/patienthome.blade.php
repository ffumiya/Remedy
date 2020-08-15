@extends('layouts.app')

@include('header')

@section('content')

<div class="continaer">
    <!-- <div class="row-100 bg-grey pad-5">
        <img class="center-block img-responsive remedy-logo bg-grey" src="{{ asset('img/remedy-pc/logo.png') }}"
            align="">
    </div> -->
    @if($currentEvent == null)
        <div style="height: 75vh; padding-top: 35vh; text-align: center;">
            <h2>現在の予定はありません。<br>
            診療予定が追加されるまでお待ちください。
            </h2>
        </div>
    @else
        <div class="text-center mgr-btm-5">
            <img class="center-block img-responsive profile" src="{{ asset('img/patient_profile.png') }}" align="">
            <span style="color:black; font-size:1.5em;">{{ \Auth::user()->name }} さん<br></span>
        </div>

        <div class="bg-grey text-center"><br>
            <div class="blue-emphasis center-block">病院情報<br></div><br>
            <span style="font-size:13px; font-weight:bold; color:black; line-height:170%;">
                {{ $currentEvent->clinic_name }}<br>
                担当医：{{ $currentEvent->doctor_name }}<br>
                連絡先：{{ $currentEvent->tel}}<br>
            </span>
            <br>
            <div class="blue-emphasis center-block">次回診察日<br></div><br>
            <span style="color:black; font-size:22px; font-weight: bold; line-height:150%;">
                <?php $week = array("日", "月", "火", "水", "木", "金", "土"); ?>
                {{ $currentEvent->start->format('Y年m月d日') }}
                ({{ $week[$currentEvent->start->format('w')] }})<br>
                {{ $currentEvent->start->format('H時i分開始') }}<br>
            </span>
            <br>
            <span style="font-size:8px; color: #FF3366; line-height:0px;">
                お時間になりましたら「ビデオ診察開始」を押してください<br>
            </span>
            <a href="video/{{$currentEvent->event_id}}" class="btn btn-start" style="margin: 16px;">ビデオ診察開始</a>

        </div>
    @endif
</div>

@endsection

@include('footer')