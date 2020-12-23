@extends('layouts.app')

@section('style')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('content')

<!--ヘッダー（PC版）ー-->

<!-- <div class="container"> -->

<div class="remedy-pc">
    <section class="section-divider1 textdivider divider11">
        <div class="container">
            <div class="row">
                <div class="col-xs-5" style="text-align: left;">
                </div>
            </div>
        </div>
    </section>
</div>


<!--3つの特徴（PC版）ー-->

<div class="remedy-pc">
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4 centered">
            <!-- <div style="text-align: center;"> -->
            <img class="img-responsive" src="{{ asset('img/remedy-pc/whatremedy.png') }}" align=""><br>

        </div>
        <div class="col-xs-4"></div>
        <div class="col-xs-10 col-xs-offset-1 centered">
            <p style="font-size: 20px; color: black; font-weight: 600;">セカンドオピニオン特化型オンライン診療サービスです。病院・医師の皆様が全国の<br>
                オンラインセカンドオピニオン希望者様へ医療サービスを提供できる環境を構築します</p>
        </div>
        <br><br><br><br>
        <div class="col-xs-1"></div>
        <div class="col-xs-10 col-xs-offset-1 centered">
            <div style="text-align: center;">
                <img class="img-responsive" src="{{ asset('img/remedy-pc/three.png') }}" align=""></br></br></br></br>
            </div>
        </div>
        </br></br>
    </div>
</div>


<!--4つの要素（PC版）ー-->

<div class="remedy-pc">
    <br><br><br><br>
    <section class="section-divider2 textdivider divider12 remedy-pc">
        <div class="container">
            <div class="col-xs-6 col-xs-offset-3 centered"></div>
            <div class="row"></div>
        </div>
        <br><br><br>
    </section>
</div>


<!--フロー(PC版)ー-->

<div class="row remedy-pc">
    <br><br><br><br><br><br><br>
    <div class="col-xs-4 col-xs-offset-4 centered remedy-pc">
        <p style="color: dimgray; font-size: 68px; font-weight: bold;">ご利用フロー</p>
    </div>
    <div class="col-xs-10 col-xs-offset-1 remedy-pc">
        <img style="margin-top: 70px;" class="img-responsive" src="{{ asset('img/remedy-pc/flow.png') }}"
            align=""></br></br /><br /><br />
    </div>
</div>


<!--無料募集(PC版)ー-->

<div class="remedy-pc">
    <br><br><br><br>
    <section class="section-divider3 textdivider divider13">
        <div class="remedy-pc">
            <p class="customize" style="text-align:center;"><a href="/register" target="_blank" class="btn btn-primary"
                    style="font-size: 0.6em;"><b>登録はこちらから</b></a></p>
            <br><br><br></br>
        </div>
    </section>
</div>


<!--START UP STUDIO(PC版)ー-->

<div class="row">
    <div class="center-block remedy-pc">
        <br><br><br>
        <p style="color: black; font-size: 40px; font-weight: bold;">お知らせ</p>
    </div>
</div>
<div class="row remedy-pc">
    <div class="col-xs-10 col-xs-offset-1 remedy-pc">
        <img style="margin-top: 50px;" class="img-responsive" src="{{ asset('img/remedy-pc/announcements.png') }}"
            align=""></br></br>
        <br><br><br><br>
    </div>
</div>

<!-- </div> -->













<!--ヘッダー（SP版）ー-->

<div class="remedy-sp">
    <section class="section-divider4 textdivider divider8">
        <br><br><br><br><br><br><br><br>
        <div class="container">
            <div class="row">
            </div>
        </div>
    </section>
</div>


<!--3つの特徴（SP版）ー-->

<div class="remedy-sp">
    <div class="row"><br>
        <div class="col-xs-6 col-xs-offset-3 centered"><br />
            <img class="img-responsive" src="{{ asset('img/remedy-sp/whatisremedy.png') }}" align=""><br />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <img class="img-responsive" src="{{ asset('img/remedy-sp/three.png') }}" align=""><br />
        </div>
        <br><br><br><br><br><br><br><br><br>
    </div>
</div>




<!--4つの要素（SP版）ー-->

<div class="col-lg-13 remedy-sp">
    <section class="section-divider5 textdivider divider9">
        <br><br><br><br><br><br>
        <div class="col-xs-12 centered"></br><br /><br><br>
        </div>
    </section>
</div>


<!--フロー(SP版)ー-->

<div class="row remedy-sp"><br>
    <div style="text-align:center;">
        <p style="color: dimgray; font-size: 24px; font-weight: bold;">ご利用フロー</p>
    </div>
    <div class="col-xs-10 col-xs-offset-1">
        <img class="img-responsive" src="{{ asset('img/remedy-sp/flow.png') }}" align=""></br></br />
    </div>
</div>


<!--無料募集(SP版)ー-->

<div class="remedy-sp">
    <section class="section-divider6 textdivider divider14">
        <div style="text-align: center;" class="remedy-sp">
            <p class="customize" style="text-align:center;"><a href="/register" target="_blank" class="btn btn-primary"
                    style="font-size: 0.5em;"><b>登録はこちらから</b></a></p>
        </div>
    </section>
</div>


<!--START UP STUDIO(SP版)ー-->

<div class="row">
    <div class="col-xs-11 col-xs-offset-1 remedy-sp"><br>
        <img class="img-responsive" src="{{ asset('img/remedy-sp/announcement.png') }}" align=""></br></br><br>
    </div>
</div>


@include('footer')



<!-- JavaScript Libraries -->
<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('lib/php-mail-form/validate.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>

<!-- Template Main Javascript File -->
<script src="{{ asset('js/main.js') }}"></script>


@endsection
