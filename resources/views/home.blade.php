@extends('layouts.app')

@section('content')

<router-view />

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">予約内容</div>
                <div class="card-body">

                    <div class="row justify-center ">
                        <div class="col-md-6">
                            <p>予約1</p>
                            <li>日時：2020/7/1(水) 10:00 ~</li>
                            <li>内容：問診</li>
                            <li>担当医：田中先生</li>
                        </div>
                        <div class="col-md-6 align-self-end text-right">
                            <button onclick="location.href='/video'" class="btn btn-primary">ビデオチャット</button>
                        </div>
                    </div>

                    <div class="row justify-center ">
                        <div class="col-md-6">
                            <p>予約2</p>
                            <li>日時：2020/7/7(火) 12:00 ~</li>
                            <li>内容：問診</li>
                            <li>担当医：田中先生</li>
                        </div>
                        <div class="col-md-6 align-self-end text-right">
                            <div>
                                <button onclick="location.href='/video'" class="btn btn-dark" disabled>ビデオチャット</button>
                            </div>
                            <div>
                                <small class="text-danger">※20分前に有効になります。</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
