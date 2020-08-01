@extends('layouts.app')

@include('header')

@section('content')
<section class="bg-img1">
    <div class="text-center">
        <div class="not-found">404</div>
        <p class="text-center">
            お探しのページは見つかりません。一時的にアクセスでない状態か、<br />
            移動もしくは削除されてしまった可能性があります。
        </p>
        <a href="/" class="btn btn-primary" styele="text-align:center;">
            トップページに戻る
        </a>
    </div>
</section>
@endsection

@include('footer')
