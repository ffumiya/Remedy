@extends('layouts.app')

@section('content')
<div class="login-form">
    <form method="POST" action="{{ route('login') }}"><br><br>
        @csrf
        <h1 style="font-size: 2em; " class="text-center">ログイン</h1><br>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    placeholder="メールアドレス" value="{{ old('email') }}" required autocomplete="email" required="required"
                    autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="パスワード" name="password" required autocomplete="current-password">
            </div>
            @error('email')
            <span style="color:red;" class="invalid-feedback" role="alert">
                <strong>ログイン情報をお確かめください</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">ログイン</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input name="remember" type="checkbox"
                    {{ old('remember') ? 'checked' : '' }}> ログイン情報を記録</label><br>
            <a href="{{ route('password.request') }}" class="pull-right">パスワードを忘れた方</a><br>
            <a href="/register" class="pull-right">新規登録はこちら</a>
        </div>
        <br><br>
</div>

@include('footer')
@endsection
