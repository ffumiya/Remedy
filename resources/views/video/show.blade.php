@extends('layouts.app')

@section('content')
<!-- <div class="remedy-pc"> -->
    <div class="row customize">

        <!-- お医者さん画面 -->
        <div class="col-xs-8 ">
            <div class="relative">
                {{-- <img id="host-canvas" class="w-100-video" src="{{ asset('img/video/doctor-img.jpg') }}"> --}}
                <div id="wait-canvas" style="background-color: black" class="w-100-video ">
                    <p id="wait-message" class="text-white text-center">相手が参加するまでお待ちください。</p>
                </div>
                <video id="js-main-stream" class="w-100-video" style="display: none"></video>
                <div class="talk-icons">
                    {{-- ミュート --}}
                    {{-- <button class="icon-button" onclick="toggleMute()">
                        <span class="fa-stack fa-lg" style="color:white;">
                            <i class="fa fa-circle fa-stack-2x" aria-hidden="true"></i>
                            <i class="fa fa-microphone fa-stack-1x my-skyblue" aria-hidden="true"></i>
                        </span>
                    </button> --}}
                    {{-- <button class="icon-button">
                        <span class="fa-stack fa-lg" style="color:white;">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-video-camera fa-stack-1x my-skyblue"></i>
                        </span>
                        </button><br>
                        <button class="icon-button">
                        <span class="fa-stack fa-lg" style="color:white;">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-television fa-stack-1x my-skyblue"></i>
                        </span>
                        </button> --}}
                    <button id="js-leave-trigger" class="icon-button">
                        <span class="fa-stack fa-lg" style="color:red;">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-phone fa-stack-1x fa-rotate-135 my-white"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>


        <!-- 現在時間と患者情報 -->
        <div class="col-xs-4 remedy-pc">
            <div class="bg-grey h-32vh">
                <img class="remedy-logo-video-pc center-block" src="{{ asset('img/remedy-pc/logo.png') }}" align=""><br>
                <div class="text-center video-time" id="clock">
                </div>
            </div>

            <br />
            <div style="color:#87CEEB; font-weight: bold; margin-left:20px;">患者基本情報</div>
            <hr class="blue-line">
            <table style="width:100%; margin:0 20px;">
                <tr class="myform">
                    <th>氏名</th>
                    <td>{{ $guest->name }}</td>
                <tr class="myform">
                    <th>生年月日</th>
                    @if($guest->birthday)
                    <td>{{ $guest->birthday }}</td>
                    @else
                    <td>不明</td>
                    @endif
                </tr>
                <tr class="myform">
                    <th>性別</th>
                    @if($guest->sex)
                    <td>{{ $guest->sex }}</td>
                    @else
                    <td>不明</td>
                    @endif
                </tr>
                <tr class="myform">
                    <th>身長</th>
                    @if($guest->height)
                    <td>{{ $guest->height }}cm</td>
                    @else
                    <td>不明</td>
                    @endif
                </tr>
                <tr class="myform">
                    <th>体重</th>
                    @if($guest->weight)
                    <td>{{ $guest->weight }}kg</td>
                    @else
                    <td>不明</td>
                    @endif
                </tr>
            </table>
        </div>
    </div>

    <!-- お医者さん以外の映像 -->
    <div class="">
        {{-- <div class="remote-streams col-sm-8 nopadding" id="js-remote-streams">
            <img id="guest-canvas" class="w-30 nopadding" src="{{ asset('img/video/nurse-img.png') }}"> 
            <img class="w-30" src="{{ asset('img/video/patient-img.png') }}"> 
            <img class="w-30" src="{{ asset('img/video/relative-img.png') }}"> 
        </div> --}}
    </div>

    <!-- 参加者一覧 -->
    {{-- <div class="col-xs-4 remedy-pc">
        <br />
        <div style="color:#87CEEB; font-weight: bold; margin-left:20px;">診療参加者</div>
        <hr class="blue-line">

        <table style="width:100%; margin:0 20px;">
            <tr>
                <td class="w-15">
                    <img class="icon-img" src="{{ asset('img/video/doctor-img.jpg') }}">
    </td>
    <td class="participant-name">{{ $host->name }}</td>
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
</div> --}}
<!-- </div> -->


<!-- Begin modal window for show message -->
<div id="modalForMessage" class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="margin-top: 130%;">
            <button id="js-join-trigger" class="btn btn-primary btn-lg">開始する</button>
        </div>
    </div>
</div>
<!-- End modal window -->





<!-- スマホ版UI -->
<!-- <div class="remedy-sp">
    <div class="row"> -->

        <!-- ヘッダー -->
        <!-- <div class="bg-grey h-10vh row-100">
            <img class="remedy-logo-video-sp center-block" src="{{ asset('img/remedy-pc/logo.png') }}" align=""><br>
        </div> -->

        <!-- お医者さん画面 -->
        <!-- <div class="relative">
            <img class="doctor-video-sp" src="{{ asset('img/video/doctor-img.jpg') }}">
        </div> -->

        <!-- お医者さん以外の映像 -->

        <!-- <img class="others-video-sp" src="{{ asset('img/video/nurse-img.png') }}">
        <img class="others-video-sp" src="{{ asset('img/video/patient-img.png') }}">
        <img class="others-video-sp" src="{{ asset('img/video/relative-img.png') }}"> -->

        <!-- アイコンのあるフッター -->
        <!-- <div class="row-100 h-10vh bg-grey">
            <div class="customize" style="text-align:center;">
                <button class="icon-button">
                    <span class="fa-stack fa-lg" style="color:white;">
                        <i class="fa fa-circle fa-stack-2x" aria-hidden="true"></i>
                        <i class="fa fa-microphone fa-stack-1x my-skyblue" aria-hidden="true"></i>
                    </span>
                </button>
                <button class="icon-button">
                    <span class="fa-stack fa-lg" style="color:white;">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-video-camera fa-stack-1x my-skyblue"></i>
                    </span>
                </button>
                <button class="icon-button">
                    <span class="fa-stack fa-lg" style="color:white;">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-television fa-stack-1x my-skyblue"></i>
                    </span>
                </button>
                <button class="icon-button">
                    <span class="fa-stack fa-lg" style="color:red;">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-phone fa-stack-1x fa-rotate-135 my-white"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
</div> -->

@endsection

@section('script')
<script src="https://cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
<script defer>
    window.onload = function() {

        const roomKey = "{{ $roomKey }}";
        const localVideo = document.getElementById('js-local-stream');
        const joinTrigger = document.getElementById('js-join-trigger');
        const leaveTrigger = document.getElementById('js-leave-trigger');
        const mainVideo = document.getElementById('js-main-stream');
        const remoteVideos = document.getElementById('js-remote-streams');
        const localText = document.getElementById('js-local-text');
        const sendTrigger = document.getElementById('js-send-trigger');
        const sdkSrc = document.querySelector('script[src*=skyway]');
        const clock = document.getElementById('clock');
        var streamCount = 0;

        clock.innerHTML = getFormatTime(new Date());
        setInterval(function() {
            var date = getFormatTime(new Date());
            clock.innerHTML = date;
        }, 1000);

        $('#modalForMessage').modal('show');

        (async function main() {

        console.log("async function main.");

        // デバッグ用にコメントアウト
        // const peerId = {{ \Auth::id() }};
        const peerId = null;
        const peer = new Peer(peerId, {key: "{{ config('skyway.api_key') }}" });
        console.log(peer);

        joinTrigger.addEventListener('click', async () => {
            const localStream = await navigator.mediaDevices.getUserMedia({
                audio: false,
                video: { frameRate: { ideal: 10, max: 15 } }
            }).catch(console.error);
            const newVideo = document.createElement('video');
            newVideo.srcObject = localStream;
            newVideo.playsInline = true;
            newVideo.classList.add('w-30');
            newVideo.classList.add('nopadding');
            remoteVideos.append(newVideo);
            await newVideo.play().catch(console.error);

            $('#modalForMessage').modal('hide');
            if (!peer.open) {
                return;
            }
            if (!peer.options.key) {
                alert("通信エラーが発生しました。");
                // リダイレクトする？
            }

            const room = peer.joinRoom(roomKey, {
                mode: "mesh",
                stream: localStream
            });

            room.once('open', () => {
                console.log("you joined.");
            });

            room.on('peerJoin', peerId => {
                console.log(`${peerId} joined.`);
            })

            // streamを取得した際の処理
            room.on('stream', async stream => {
                console.log('get stream.');

                // 自機デバッグ用
                // mainVideo.muted = true;
                // mainVideo.srcObject = stream;
                // mainVideo.playsInline = true;
                // await mainVideo.play().catch(console.error);

                // 取得したstreamが医師の場合はメインに配置
                if (stream.peerId == {{ $host->id }}) {
                    document.getElementById('wait-canvas').style.display = 'none';
                    document.getElementById('wait-message').style.display = 'none';
                    mainVideo.style.display = 'block';
                    mainVideo.srcObject = stream;
                    mainVideo.playsInline = true;
                    await mainVideo.play().catch(console.error);
                    return ;
                }
                // 取得したstreamが患者かつ、ユーザーが医師の場合はメインに配置
                console.log("{{\Auth::user()->role}}");
                if (stream.peerId == {{ $guest->id }} && {{ \Auth::user()->role }} == {{ config('role.doctor.value') }}) {
                    document.getElementById('wait-canvas').style.display = 'none';
                    document.getElementById('wait-message').style.display = 'none';
                    mainVideo.style.display = 'block';
                    mainVideo.srcObject = stream;
                    mainVideo.playsInline = true;
                    await mainVideo.play().catch(console.error);
                    return;
                }
                // その他のstreamはlocalStreamの横に順に配置
                if (streamCount < 3) {
                    streamCount++;
                    const newVideo = document.createElement('video');
                    newVideo.srcObject = stream;
                    newVideo.playsInline = true;
                    newVideo.setAttribute('data-peer-id', stream.peerId);
                    newVideo.classList.add('w-30');
                    remoteVideos.append(newVideo);
                    await newVideo.play().catch(console.error);
                } else {
                    console.log("人数オーバーです。");
                    return;
                }
            })

            // チャット受信
            // room.on('data', ({data, src}) => {
            //     console.log(data);
            //     console.log(src);
            // })

            // 他人が退室した際の処理
            room.on('peerLeave', peerId => {
                if (mainVideo.srcObject) {
                    mainVideo.srcObject.getTracks().forEach(track => track.stop());
                    mainVideo.srcObject = null;
                    mainVideo.remove();
                    document.getElementById('wait-canvas').style.display = 'block';
                    document.getElementById('wait-message').style.display = 'block';
                }
                const remoteVideo = remoteVideos.querySelector(
                    `[data-peer-id="${peerId}"]`
                );
                if (remoteVideo.srcObject) {
                    remoteVideo.srcObject.getTracks().forEach(track => track.stop());
                    remoteVideo.srcObject = null;
                    remoteVideo.remove();
                    remoteVideo = null;
                    console.log(remoteVideo);
                    streamCount--;
                }
                console.log('leave other member.');
            })

            // 自分が退室した際の処理
            room.once('close', () => {
                console.log('close yourself.');
                if (mainVideo.srcObject) {
                    mainVideo.srcObject.getTracks().forEach(track => track.stop());
                    mainVideo.srcObject = null;
                    mainVideo.remove();
                    document.getElementById('wait-canvas').style.display = 'block';
                    document.getElementById('wait-message').style.display = 'block';
                }
                Array.from(remoteVideos.children).forEach(remoteVideo => {
                    if (remoteVideo.srcObject) {
                        remoteVideo.srcObject.getTracks().forEach(track => track.stop());
                        remoteVideo.srcObject = null;
                        remoteVideo.remove();
                    }
                });
                streamCount = 0;
                $('#modalForMessage').modal('show');
            })

            leaveTrigger.addEventListener('click', () => room.close(), {once: true});

            // チャット送信
            // sendTrigger.addEventListener('click', onClickSend);
            // function onClickSend() {
            //     room.send(localText.value);
            //     console.log('send message.');
            // }

        });

        peer.on('error', console.error);

    }) ();
}

function getFormatTime(dt) {
    var h = dt.getHours();
        var m = dt.getMinutes();
        var s = dt.getSeconds();

        if (h < 10) h='0' + h;
        if (m < 10) m='0' + m;
        // if (s < 10) s='0' + s;

        var hm=h + ':' + m;
        return hm;
}

function toggleMute() {
    var localVideo = document.getElementById('js-local-stream');
    if (localVideo.muted) {
        localVideo.muted = false;
    } else {
        localVideo.muted = true;
    }
    console.log(`ミュート：${localVideo.muted}`);
}

</script>

<!-- Scripts -->
<script>
    function toggleFullScreen() {
        console.log(screen.width);
        if(screen.width > 414){
            var doc = window.document;
            var docEl = doc.documentElement;

            var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
            var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

            if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
            requestFullScreen.call(docEl);
            }
            else {
            cancelFullScreen.call(doc);
            }
        }else{
            alert('お使いのデバイスは全画面表示に対応しておりません。')
        }
    }

</script>

@endsection