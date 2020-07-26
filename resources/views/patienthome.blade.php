@extends('layouts.app')
@include('header')

@section('content')
<div class="continaer">

    <div>
        名前：{{ \Auth::user()->name }}さん
    </div>
    @if($currentEvent == null)
    <h4>現在の予定はありません。</h4>
    <p>医師から診療予定が追加されるまでお待ちください。</p>
    @else
    <div>
        病院名：{{ $currentEvent->clinic_name }}
    </div>
    <div>
        担当医：{{ $currentEvent->doctor_name }}
    </div>
    <div>
        連絡先：{{ $currentEvent->email}}
    </div>
    <div>
        次回診察日
        <div>
            {{ $currentEvent->start }}
        </div>
        <div>
            <p>お時間になりましたら～</p>
        </div>
        <button class="btn btn-primary">
            診察開始
        </button>
    </div>
    @endif
</div>
@endsection
@include('footer')
