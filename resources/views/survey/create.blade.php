@extends('layouts.app')

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
                <input type="hidden" name="role" value="{{ $role }}">
                <div class="form-group mt-5 mb-5">
                    <label for="name">お名前を入力してください</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="例：山田花子"
                        value="{{ old('name', $name) }}">
                </div>
                <div class="form-group mt-5 mb-5">
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
                    <p>
                        現在選択中の数字：
                        <strong id="slider-value">6</strong>
                    </p>
                </div>
                <div class="form-group mt-5 mb-5">
                    <label for="comment">問２：質問したいことはありますか？(300文字以内)</label>
                    <textarea class="form-control" name="comment" id="comment" cols="30" rows="10" maxlength="300"
                        placeholder="質問したいことを入力してください" onkeydown="showLength(value)"></textarea>
                    <div class="text-right">
                        <p id="comment-length">0文字</p>
                    </div>
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

@section('script')
<script>
    function showLength(str) {
        document.getElementById("comment-length").innerHTML = str.length + "文字";
    }
    document.addEventListener( 'DOMContentLoaded' , function( e ) {
        window.open("{{$zoom_url}}");

        var elem = document.getElementById('satisfaction_level');
        var target = document.getElementById('slider-value');
        var rangeValue = (elem, target) => {
            return function(evt){
            target.innerHTML = elem.value;
            }
        }
        elem.addEventListener('input', rangeValue(elem, target));
    });
</script>
@endsection
