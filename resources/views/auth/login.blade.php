@extends('layouts.app')

@include('header')

@section('content')
<div class="login-form">
    <form method="POST" action="{{ route('login') }}"><br><br>
        @csrf
        <h2 class="text-center">ログイン</h2><br>
        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="メールアドレス" value="{{ old('email') }}" required autocomplete="email" required="required" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                </span>
                @enderror
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="パスワード" name="password" required autocomplete="current-password">
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
            <label class="pull-left checkbox-inline"><input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}> ログイン情報を記録</label><br>
            <a href="{{ route('password.request') }}" class="pull-right">パスワードを忘れた方</a><br>
            <a href="/register" class="pull-right">新規登録はこちら</a>
        </div>
        <br><br>
</div>

<!-- 元のログインページ -->

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('login') }}</div>

                <div class="card-body">
                    <form method="post" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('e-mail address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('remember me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('login') }}
                                </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('forgot your password?') }}
                                    </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@include('footer')
@endsection
