@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        <h1>アンケート詳細画面</h1>
    </div>
    @foreach($surveys as $survey)
    <div class="list-group mt-5">
        <div class="list-group-item">
            <p>
                お名前：{{ $survey->name }}
                @if ($survey->role == config('role.patient.value'))
                (ご本人)
                @endif
            </p>
        </div>
        <div class="list-group-item">
            <p>診療日時：{{ $event->start }}</p>
        </div>
        <div class="list-group-item">
            <p>更新日時：{{ $survey->updated_at }}</p>
        </div>
        <div class="list-group-item">
            <p>満足度：{{ $survey->satisfaction_level }}</p>
        </div>
        <div class="list-group-item">
            <p>コメント</p>
            <p>
                {{ $survey->comment}}
            </p>
        </div>
    </div>
    @endforeach
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
