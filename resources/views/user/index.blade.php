@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <form action="/user" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <select name="user_role" class="form-control">
                                <option value="" @if (empty(old('user_role'))) selected @endif>すべて</option>
                                @foreach (config('role') as $key => $value)
                                @if($value['value'] != config('role.admin.value'))
                                <option @if (old('user_role')==$value['value']) selected @endif
                                    value="{{ $value['value'] }}">
                                    {{ $value['name'] }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input name="user_id" class="form-control" type="text" placeholder="idで検索"
                                value="{{ old('user_id') }}">
                        </div>
                        <div class="col">
                            <input name="user_name" class="form-control" type="text" placeholder="名前で検索"
                                value="{{ old('user_name') }}">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary">検索</button>
                        </div>
                    </div>
                </form>
            </div>
            <div>
                @if (isset($users))
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user) <tr>
                            <td>{{ $user->name }} 様</td>
                            <td><button class="btn btn-warning">編集</button></td>
                            <td><button class="btn btn-danger">削除</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
                @else
                <div class="alert alert-info text-center">
                    <p>ユーザーが登録されていません。</p>
                    <p>上にある新規登録ボタンから、登録を行ってください。</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
