@extends('layouts.app')

@include('header')

@section('content')

<div class="continaer m-5">
    <div class="row">
        <div class="col" style="height: 0;">
        </div>
        <div class="col-md-6">
            <div class="text-center pb-3">
                <h2>
                    オンライン診療についてのアンケートにご協力ください
                </h2>
                <small>
                    ※このアンケートは病院側に提出されます。
                </small>
            </div>
            <form action="{{ route('survey.store') }}" method="POST">
                @csrf
                <input type="hidden" name="survey_token" value="{{ $survey_token }}">
                <div class="form-group">
                    <label for="satisfaction_level">問１：本日の診療はどの程度ご理解できましたか？</label>
                    <div class="row justify-content-between mt-3">
                        <div class="col text-left">
                            <label for="satisfaction_level">
                                1(全く分からなかった)
                            </label>
                        </div>
                        <div class="col text-right">
                            <label for="satisfaction_level">(完全に理解した)10</label>
                        </div>
                    </div>
                    <input type="range" class="custom-range" min="1" max="10" id="satisfaction_level"
                        name="satisfaction_level">
                </div>
                <div class="form-group">
                    <label for="comment1">問２：追加で質問したいことはありますか？</label>
                    <textarea class="form-control" name="comment1" id="comment1" cols="30" rows="10"></textarea>
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-primary btn-lg" value="送信">
                </div>
            </form>
        </div>
        <div class="col" style="height: 0;"></div>
    </div>
</div>

@endsection

@include('footer')
