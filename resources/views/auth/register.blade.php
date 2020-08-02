@extends('layouts.app')

@include('header')

@section('content')
<div class="login-form">
    <form method="POST" action="{{ route('register') }}"><br>
        @csrf
        <h1 style="font-size:2em;"class="text-center">新規登録</h1><br> 
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
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="メールアドレス" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
            <strong>メールアドレスを確かめください</strong>
            </span>
            @enderror
        </div>

		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="パスワード" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>パスワードをお確かめください</strong>
                </span>
                @enderror
            </div>
        </div>        

		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">
                <i class="fa fa-lock"></i>
			    <i class="fa fa-check"></i>
                </span>
                <input id="password_confirmation" type="password" class="form-control" placeholder="パスワード（確認用)" name="password_confirmation" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>パスワードをお確かめください</strong>
                </span>
                @enderror
            </div>
        </div>        

        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">新規登録</button>
        </div>
        <div class="clearfix">
            <a href="/login" class="pull-right">既にアカウントをお持ちの方はこちら</a>
        </div>
        <br><br>
</div>

@include('footer')

<!-- 以下、元の登録ページ -->

<!-- <div class="container">
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
</div> -->
@endsection
