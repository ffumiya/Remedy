@extends('layouts.app')

@section('content')
    <!-- PC版UI -->
<div class="remedy-pc">
    <div class="row customize">

        <!-- お医者さん画面 -->
        <div class="col-xs-8 ">
            <div class="relative">
                <img class="w-100-video" src="{{ asset('img/video/doctor-img.jpg') }}">
                <div class="talk-icons">
                    <button class="icon-button">
                        <span class="fa-stack fa-lg"  style="color:white;">
                            <i class="fa fa-circle fa-stack-2x" aria-hidden="true"></i>
                            <i class="fa fa-microphone fa-stack-1x my-skyblue" aria-hidden="true"></i>
                        </span>
                    </button>
                    <button class="icon-button">
                        <span class="fa-stack fa-lg"  style="color:white;">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-video-camera fa-stack-1x my-skyblue"></i>
                        </span>
                    </button><br>
                    <button class="icon-button">
                        <span class="fa-stack fa-lg"  style="color:white;">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-television fa-stack-1x my-skyblue"></i>
                        </span>
                    </button>
                    <button class="icon-button">
                        <span class="fa-stack fa-lg"  style="color:red;">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-phone fa-stack-1x fa-rotate-135 my-white"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>


        <!-- 現在時間と患者情報 -->
        <div class="col-xs-4">
            <div class="bg-grey h-32vh">
                <img class="remedy-logo-video-pc center-block" src="{{ asset('img/remedy-pc/logo.png') }}" align=""><br>
                <div class="text-center video-time">
                    10:43
                </div>
            </div> 

            <br/>
            <div style="color:#87CEEB; font-weight: bold; margin-left:20px;">患者金本情報</div>
            <hr class="blue-line">
            <table style="width:100%; margin:0 20px;">
                <tr class="myform">
                    <th>氏名</th>
                    <td>田中邦彦</tdstyle=>
                <tr class="myform">
                    <th>生年月日</th>
                    <td>昭和38年12月31日（57歳）</td>
                </tr>
                <tr class="myform">
                    <th>性別</th>
                    <td>男性</td>
                </tr>
                <tr class="myform">
                    <th>身長</th>
                    <td>167cm</td>
                </tr>
                <tr class="myform">
                    <th>体重</th>
                    <td>67kg</td>
                </tr>
            </table>
            </div>
        </div>

        <!-- お医者さん以外の映像 -->
        <div class="col-xs-8 nopadding">
            <img class="w-30 nopadding" src="{{ asset('img/video/nurse-img.png') }}">
            <img class="w-30" src="{{ asset('img/video/patient-img.png') }}">
            <img class="w-30" src="{{ asset('img/video/relative-img.png') }}" >
        </div>

        <!-- 参加者一覧 -->
        <div class="col-xs-4">
            <br/>
            <div style="color:#87CEEB; font-weight: bold; margin-left:20px;">診療参加者</div>
            <hr class="blue-line">

            <table style="width:100%; margin:0 20px;">
                <tr>
                    <td class="w-15">
                        <img class="icon-img" src="{{ asset('img/video/doctor-img.jpg') }}">
                    </td>
                    <td class="participant-name">田中 邦彦</td>
                    <td class="w-15">
                        <img class="icon-img" src="{{ asset('img/video/nurse-img.png') }}">
                    </td>
                    <td class="participant-name">広瀬 律子</td>
                </tr>

                <tr>
                    <td class="w-15 h-50px">
                        <img class="icon-img mgr-top-10" src="{{ asset('img/video/patient-img.png') }}">
                    </td>
                    <td style="height: 100px;" class="participant-name">
                        山根 忠政
                    </td>
                    <td class="w-15">
                        <img class="icon-img" src="{{ asset('img/video/relative-img.png') }}">
                    </td>
                    <td class="participant-name">山根 結衣</td>
                </tr>
            </table>
        </div>
    </div>
</div>




<!-- スマホ版UI -->
<div class="remedy-sp">
    <div class="row">

        <!-- ヘッダー -->
        <div class="bg-grey h-10vh row-100">
            <img class="remedy-logo-video-sp center-block" src="{{ asset('img/remedy-pc/logo.png') }}" align=""><br>
        </div>

        <!-- お医者さん画面 -->
        <div class="relative">
            <img class="doctor-video-sp" src="{{ asset('img/video/doctor-img.jpg') }}">
        </div>

        <!-- お医者さん以外の映像 -->

        <img class="others-video-sp" src="{{ asset('img/video/nurse-img.png') }}">
        <img class="others-video-sp" src="{{ asset('img/video/patient-img.png') }}">
        <img class="others-video-sp" src="{{ asset('img/video/relative-img.png') }}" >

        <!-- アイコンのあるフッター -->
        <div class="row-100 h-10vh bg-grey">
        <div style="text-align:center;">            
            <button class="icon-button">
                <span class="fa-stack fa-lg"  style="color:white;">
                    <i class="fa fa-circle fa-stack-2x" aria-hidden="true"></i>
                    <i class="fa fa-microphone fa-stack-1x my-skyblue" aria-hidden="true"></i>
                </span>
            </button>
            <button class="icon-button">
                <span class="fa-stack fa-lg"  style="color:white;">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-video-camera fa-stack-1x my-skyblue"></i>
                </span>
            </button>
            <button class="icon-button">
                <span class="fa-stack fa-lg"  style="color:white;">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-television fa-stack-1x my-skyblue"></i>
                </span>
            </button>
            <button class="icon-button">
                <span class="fa-stack fa-lg"  style="color:red;">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-phone fa-stack-1x fa-rotate-135 my-white"></i>
                </span>
            </button>
        </div>
        </div>
</div>
    </div>
</div>

@endsection