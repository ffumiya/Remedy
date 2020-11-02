@extends('layouts.app')

@include('header')

@section('content')
<div class="container">
    <div class="">
        <h1>アンケート詳細画面</h1>
    </div>
    <div class="list-group">
        <div class="list-group-item">
            <p>患者名：{{ $event->name }}</p>
        </div>
        <div class="list-group-item">
            <p>診療日時：{{ $event->start }}</p>
        </div>
        <div class="list-group-item">
            <p>回答日時：{{ $event->survey_received_at }}</p>
        </div>
        <div class="list-group-item">
            <p>満足度：{{ $event->survey_satisfaction_level }}</p>
        </div>
        <div class="list-group-item">
            <p>コメント１</p>
            <p>
                @isset($event->survey_comment_1)
                {{ $event->survey_comment_1}}
                @endisset
            </p>
        </div>
        <div class="list-group-item">
            <p>コメント２</p>
            <p>
                @isset($event->survey_comment_2)
                {{ $event->survey_comment_2}}
                @endisset
            </p>
        </div>
    </div>
</div>
@endsection

@include('footer')

@section('style')
<style>
    .list-group {
        border-style: solid;
        border-width: 0;
        border-left-width: 12px;
        border-left-color: #006092;
        border-radius: 2px;
    }

    .list-group-item {
        margin-bottom: 0;
    }
</style>

@endsection
