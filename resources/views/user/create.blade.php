@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <legend>ユーザー新規登録</legend>
            <form action="/user" method="POST">
                @csrf
                <label for="name">名前</label>
                <input name="name" type="text" class="form-control" value="{{ old('name') }}">
                <input type="submit" value="登録" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
@endsection
