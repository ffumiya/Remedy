<template>
    <section>
        <div>
            <div>
                <h2>オンライン診療(ルーム)</h2>

                <div>
                    <canvas id="concat" v-bind:style="videoStyle"></canvas>
                    <canvas id="canvas" v-bind:style="videoStyle"></canvas>
                </div>
                <div id="remoteVideos"></div>

                <div>
                    <!-- <v-switch
                        v-model="mute"
                        :label="`ミュート：${mute}`"
                    ></v-switch> -->
                    <button @click="joinToRoom" class="btn btn-success">
                        Join
                    </button>
                    <button @click="closeRoom" class="btn btn-danger">
                        Exit
                    </button>
                </div>
                <div style="margin-top: 20px;">
                    <!-- <button outlined color="red">
            <span>mdi-record-circle-outline</span>
            録画する
          </button> -->
                    <!-- <button class="primary">
            <span>mdi-monitor-share</span>
            画面共有
          </button> -->
                </div>
                <div style="margin-top: 20px;">
                    <button
                        @click="switchDrawable"
                        class="btn btn-outline-primary"
                    >
                        <!-- <span>mdi-grease-pencil</span> -->
                        書き込む
                    </button>
                    <button @click="clearPath" class="btn btn-outline-dark">
                        <!-- <span>mdi-delete</span> -->
                        クリア
                    </button>
                </div>

                <div>
                    <div style="margin-top: 100px;">
                        <h2>マイク・カメラ設定</h2>
                        <select
                            class="form-control"
                            v-on:change="onChange"
                            v-model="selectedAudio"
                        >
                            <option disabled selected value
                                >マイクを選択してください</option
                            >
                            <option
                                v-for="audio in audios"
                                v-bind:value="audio"
                                v-bind:key="audio"
                                >{{ audio }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <select
                            class="form-control"
                            v-on:change="onChange"
                            v-model="selectedVideo"
                        >
                            <option disabled selected value
                                >カメラを選択してください</option
                            >
                            <option
                                v-for="video in videos"
                                v-bind:value="video.value"
                                v-bind:key="video.text"
                                >{{ video.text }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<style>
#canvas {
    position: relative;
}
#concat {
    position: absolute;
}
</style>
<script>
import Peer from "skyway-js";

export default {
    components: {},
    data() {
        return {
            APIKey: "",
            roomName: "",
            room: null,
            audios: [],
            selectedAudio: "",
            videos: [],
            selectedVideo: "",
            localStream: null,
            mute: false,
            ctx: null,
            canvas: null,
            isDrawing: false,
            x: 0,
            y: 0,
            color: "red",
            canvasWidth: 270,
            canvasHeight: 200,
            canvasVisibility: false,
            videoStyle: {
                width: "270px",
                height: "200px"
            },
            framerate: 1000 / 10,
            drawable: false,
            videoIntarvalList: {}
        };
    },
    mounted: function() {
        // Skyway用Peerの生成
        this.getAPIKey();
        this.peer = new Peer({
            key: this.APIKey,
            debug: 3
        });
        //デバイスへのアクセス
        navigator.mediaDevices.enumerateDevices().then(deviceInfos => {
            for (let i = 0; i !== deviceInfos.length; ++i) {
                const deviceInfo = deviceInfos[i];
                console.table(deviceInfo);
                if (deviceInfo.kind === "audioinput") {
                    this.audios.push({
                        text:
                            deviceInfo.label ||
                            `Microphone ${this.audios.length + 1}`,
                        value: deviceInfo.deviceId
                    });
                } else if (deviceInfo.kind === "videoinput") {
                    this.videos.push({
                        text:
                            deviceInfo.label ||
                            `Camera  ${this.videos.length + 1}`,
                        value: deviceInfo.deviceId
                    });
                }
            }
        });
        this.canvas = document.getElementById("canvas");
        [this.canvas.width, this.canvas.height] = [
            this.canvasWidth,
            this.canvasHeight
        ];
        this.ctx = this.canvas.getContext("2d");
        this.canvas.addEventListener("mousedown", this.beginPath);
        this.canvas.addEventListener("mousemove", this.strokePath);
        this.canvas.addEventListener("mouseup", this.endPath);
    },
    methods: {
        // SkyWayAPIキー取得
        getAPIKey: function() {
            this.APIKey = "75a90790-44e1-48f3-bb81-6c8667867b98";
            console.log(`APIKEY = ${this.APIKey}`);
        },
        // ルーム名取得
        getRoomName: function() {
            this.roomName = "Remedy";
        },
        // カメラ選択
        onChange: function() {
            if (this.selectedAudio != "" || this.selectedVideo != "") {
                this.connectLocalCamera();
            }
        },
        // MediaStream取得
        connectLocalCamera: async function() {
            const constraints = {
                audio: this.selectedAudio
                    ? { deviceId: { exact: this.selectedAudio } }
                    : false,
                video: this.selectedVideo
                    ? { deviceId: { exact: this.selectedVideo } }
                    : false
            };
            const stream = await navigator.mediaDevices
                .getUserMedia(constraints)
                .catch(err => {
                    console.error(`getUserMedia() has failed ${err}`);
                });

            let localVideo = document.createElement("video");
            localVideo.srcObject = stream;
            localVideo.autoplay = true;
            localVideo.playsinline = true;
            // localVideo.muted = true;
            let framerate = this.framerate;
            let [canvasWidth, canvasHeight] = [
                this.canvasWidth,
                this.canvasHeight
            ];

            setInterval(async function() {
                //重ねたいvideo映像
                const canvasAsset = document.getElementById("canvas");
                const whiteCanvas = document.getElementById("concat");

                //canvas要素群のサイズを揃える
                [localVideo.width, localVideo.height] = [
                    whiteCanvas.width,
                    whiteCanvas.height
                ] = [canvasWidth, canvasHeight];

                // 出力先コンテキスト取得
                const whiteCtx = whiteCanvas.getContext("2d");

                whiteCtx.drawImage(localVideo, 0, 0, canvasWidth, canvasHeight);
                whiteCtx.drawImage(
                    canvasAsset,
                    0,
                    0,
                    canvasWidth,
                    canvasHeight
                );
            }, framerate);
            this.localStream = document
                .getElementById("concat")
                .captureStream(this.framerate);
        },
        // ルームへの参加
        joinToRoom: function() {
            if (!this.peer.open) {
                return;
            }
            this.getRoomName();
            // TODO: localStreamがnullにならないように修正
            this.room = this.peer.joinRoom(this.roomName, {
                mode: "mesh",
                stream: this.localStream
            });
            // 入室処理;
            this.room.on("open", () => {
                console.log("入室しました。");
            });
            // 参加処理
            this.room.on("peerJoin", peerId => {
                console.log("誰かが参加しました");
            });
            // Stream取得
            this.room.on("stream", async stream => {
                console.log("Streamを取得しました");
                this.addVideo(stream);
            });
            // 退出処理
            this.room.on("peerLeave", peerId => {
                console.log("誰かが退出しました。");
                const remoteVideo = remoteVideos.querySelector(
                    `[streem-peer-id=${peerId}]`
                );
                if (remoteVideo == null) {
                    return;
                }
                remoteVideo.srcObject = null;
                remoteVideo.remove();
                clearInterval(this.videoIntarvalList[peerId]);
            });
            // データ取得
            this.room.on("data", ({ data, src }) => {
                alert("データを取得しました");
                console.log(`data : ${data}`);
                console.log(`src : ${src}`);
            });
            // 退室処理
            this.room.on("close", () => {
                alert("退室しました。");
                Array.from(remoteVideos.children).forEach(remoteVideo => {
                    remoteVideo.srcObject = null;
                    remoteVideo.remove();
                });
            });
            this.room.on("error", err => {
                console.error(`room.on("error")でキャッチできるERROR : ${err}`);
            });
        },
        // ルームから退出
        closeRoom: function() {
            console.log("ルームから退出しました。");
            if (this.room == null) {
                return;
            }
            this.room.close();
            this.room = null;
        },
        // データの送信
        send: function(arg) {
            if (this.room == null) {
                return;
            }
            this.room.send(arg);
            alert("データを送信しました。");
        },
        // Videoの追加
        addVideo: async function(stream) {
            const newVideo = document.createElement("video");
            newVideo.srcObject = stream;
            newVideo.playsInline = true;
            newVideo.height = this.canvasHeight;
            newVideo.width = this.canvasWidth;
            newVideo.autoplay = true;
            const whiteCanvas = document.createElement("canvas");
            whiteCanvas.setAttribute("streem-peer-id", stream.peerId);
            let [canvasWidth, canvasHeight] = [
                this.canvasWidth,
                this.canvasHeight
            ];
            let framerate = this.framerate;
            let videoIntarval = setInterval(async function() {
                //canvas要素群のサイズを揃える
                [whiteCanvas.width, whiteCanvas.height] = [
                    canvasWidth,
                    canvasHeight
                ];

                // 出力先コンテキスト取得
                const whiteCtx = whiteCanvas.getContext("2d");

                whiteCtx.drawImage(newVideo, 0, 0, canvasWidth, canvasHeight);
            }, framerate);
            document.getElementById("remoteVideos").appendChild(whiteCanvas);
            this.videoIntarvalList[stream.peerId] = videoIntarval;
            console.log("Videoを追加しました。");
        },
        beginPath(e) {
            console.log("mouse down");
            if (!this.drawable) {
                return;
            }
            this.ctx.strokeStyle = this.color;
            this.ctx.lineWidth = 3;
            this.ctx.beginPath();
            this.isDrawing = true;
            let { x, y } = this.calcPos(e);
            this.ctx.moveTo(x, y);
        },
        strokePath(e) {
            if (!this.isDrawing) {
                return;
            }
            let { x, y } = this.calcPos(e);
            this.ctx.lineTo(x, y);
            // this.ctx.lineTo(e.clientX, e.clientY);
            this.ctx.stroke();
        },
        endPath(e) {
            console.log("mouse up");
            if (!this.drawable || !this.isDrawing) {
                return;
            }
            this.isDrawing = false;
            let { x, y } = this.calcPos(e);
            this.ctx.lineTo(x, y);
            this.ctx.stroke();
            this.ctx.closePath();
        },
        calcPos(e) {
            let rect = e.target.getBoundingClientRect();
            let x = e.clientX - rect.left;
            let y = e.clientY - rect.top;
            this.x = x;
            this.y = y;
            return { x, y };
        },
        clearPath() {
            this.ctx.clearRect(0, 0, this.canvasWidth, this.canvasHeight);
        },
        switchDrawable() {
            this.drawable = !this.drawable;
        }
    },

    // 後処理
    destroyed: function() {
        if (this.room) {
            this.closeRoom();
        }
    }
};
</script>
