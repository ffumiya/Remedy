@extends('layouts.app')

@section('content')
<div class="login-form">
    <form method="POST" action="{{ route('register') }}"><br>
        @csrf
        <h2 class="text-center">登録</h2><br> 
        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="名前" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>ユーザー名を確かめください</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="名前" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>ユーザー名を確かめください</strong>
            </span>
            @enderror
        </div>

		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="パスワード" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>パスワードをお確かめください</strong>
                </span>
                @enderror
            </div>
        </div>        
        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">ログイン</button>
        </div>
        <div class="clearfix">
            <label class="pull-left checkbox-inline"><input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}> ログイン情報を記録</label><br>
            <a href="{{ route('password.request') }}" class="pull-right">パスワードを忘れた方はこちら</a>
        </div>
        <br><br>
</div>

<!-- 以下、元の登録ページ -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
