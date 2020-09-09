@extends('layouts.app')

@section('content')
<!-- <div class="remedy-pc"> -->
<div class="row customize">

    <!-- メイン映像 -->
    <div class="col-xs-8 p-0">
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
                <td>{{ $guest->name }} さん</td>
                {{-- <tr class="myform">
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
            </tr> --}}
        </table>
    </div>
</div>

<!-- お医者さん以外の映像 -->
<div class="row">
    <div class="col-xs-12 col-md-8 p-0">
        <div class="row remote-streams p-0" id="js-remote-streams">

        </div>
    </div>
    <div class="col-md-4"></div>
    {{-- <div class="remote-streams col-sm-8 p-0" id="js-remote-streams">
            <img id="guest-canvas" class="w-30 p-0" src="{{ asset('img/video/nurse-img.png') }}">
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
        var audio = null;
        var video = null;

        clock.innerHTML = getFormatTime(new Date());
        setInterval(function() {
            var date = getFormatTime(new Date());
            clock.innerHTML = date;
        }, 1000);

        $('#modalForMessage').modal('show');

        // 画面サイズが変更された時の処理
        // $(window).resize(function() {
        //     var windowHeight = $(window).height();
        //     console.log(`Windowの高さは${windowHeight}pxです。`);
        //     var windowWidth = $(window).width();
        //     console.log(`Windowの幅は${windowWidth}pxです。`);
        // });

        (async function main() {

            console.log("async function main.");

            const peerId = {{ \Auth::id() }};
            const peer = new Peer(peerId, {key: "{{ config('skyway.api_key') }}" });
            console.log(peer);

            joinTrigger.addEventListener('click', async () => {
                var audios = null;
                var videos = null;
                await navigator.mediaDevices.enumerateDevices().then(deviceInfos => {
                    for (let i = 0; i !== deviceInfos.length; ++i) {
                        const deviceInfo = deviceInfos[i];
                        if (deviceInfo.deviceId == "") {
                            continue;
                        }
                        if (deviceInfo.kind === "audioinput") {
                            if (audios == null) audios = [];
                            audios.push({
                                text: deviceInfo.label || `Microphone ${audios.length + 1}`,
                                value: deviceInfo.deviceId
                            });
                        } else if (deviceInfo.kind === "videoinput") {
                            if (videos == null) videos = [];
                            videos.push({
                                text: deviceInfo.label || `Camera ${videos.length + 1}`,
                                value: deviceInfo.deviceId
                            });
                        }
                    }
                });
                console.log(audios);
                console.log(videos);
                const constraints = {
                    audio: false,
                    video: {width: 320, height: 240, frameRate: 10}
                    // audio: audios ? { deviceId: { exact: audios[0].value } } : false,
                    // video: videos ? { deviceId: { exact: videos[0].value } } : false
                };
                console.log(constraints);
                const localStream = await navigator.mediaDevices.getUserMedia(constraints).catch(function (err) {
                    alert('カメラと音声を取得できませんでした。');
                    console.error();
                });
                console.log(localStream);
                const newDiv = document.createElement('div');
                const newVideo = document.createElement('video');

                newVideo.muted = true; // ハウリング防止
                newVideo.srcObject = localStream;
                newVideo.playsInline = true;
                newVideo.classList.add('p-0');
                newVideo.classList.add('w-100');
                console.log(newVideo);
                console.log(remoteVideos);
                newDiv.classList.add('col-4');
                newDiv.classList.add('p-0');
                newDiv.classList.add('bg-dark');
                newDiv.append(newVideo);
                remoteVideos.append(newDiv);
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
                    console.log("hostId = {{ $host->id }}, guestId = {{ $guest->id }}");
                    if (stream.peerId == {{ $host->id }}) {
                        document.getElementById('wait-canvas').style.display = 'none';
                        document.getElementById('wait-message').style.display = 'none';
                        mainVideo.setAttribute('data-peer-id', stream.peerId);
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
                        mainVideo.setAttribute('data-peer-id', stream.peerId);
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
                        newVideo.classList.add('col-4');
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
                    console.log(`peerId${peerId}が退室しました。`);
                    console.log(`メイン映像のpeerIdは${mainVideo.getAttribute('data-peer-id')}です。`);
                    if (mainVideo.getAttribute('data-peer-id') == peerId) {
                        mainVideo.srcObject.getTracks().forEach(track => track.stop());
                        mainVideo.srcObject = null;
                        mainVideo.style.display = 'none';
                        // mainVideo.remove();
                        document.getElementById('wait-canvas').style.display = 'block';
                        document.getElementById('wait-message').style.display = 'block';
                    }
                    var remoteVideo = remoteVideos.querySelector(
                        `[data-peer-id="${peerId}"]`
                    );
                    if (remoteVideo != null) {
                        remoteVideo.video.srcObject.getTracks().forEach(track => track.stop());
                        remoteVideo.style.display = 'none';
                        // remoteVideo.srcObject = null;
                        remoteVideo.remove();
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
                        mainVideo.style.display = 'none';
                        // mainVideo.remove();
                        document.getElementById('wait-canvas').style.display = 'block';
                        document.getElementById('wait-message').style.display = 'block';
                    }
                    Array.from(remoteVideos.children).forEach(remoteDiv => {
                        Array.from(remoteDiv.children).forEach(remoteVideo => {
                        if (remoteVideo.srcObject) {
                            remoteVideo.srcObject.getTracks().forEach(track => track.stop());
                            remoteVideo.srcObject = null;
                            remoteVideo.remove();
                        }
                        });
                        remoteDiv.remove();
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
