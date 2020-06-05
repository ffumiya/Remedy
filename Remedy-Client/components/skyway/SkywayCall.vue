<template>
  <section>
    <div>
      <div>
        <h2>オンライン診療(１：１)</h2>
        <div>
          <video id="their-video" width="200" autoplay playsinline></video>
          <video
            id="my-video"
            muted="true"
            width="200"
            autoplay
            playsinline
          ></video>
        </div>

        <div>
          マイク:
          <select v-model="selectedAudio" @change="onChange">
            <option disabled value>Please select one</option>
            <option
              v-for="(audio, key, index) in audios"
              v-bind:key="index"
              :value="audio.value"
              >{{ audio.text }}</option
            >
          </select>
        </div>

        <div>
          カメラ:
          <select v-model="selectedVideo" @change="onChange">
            <option disabled value>Please select one</option>
            <option
              v-for="(video, key, index) in videos"
              v-bind:key="index"
              :value="video.value"
              >{{ video.text }}</option
            >
          </select>
        </div>

        <div>
          <p>
            Your id:
            <span id="my-id">{{ peerId }}</span>
          </p>
          <p>他のブラウザでこのIDをコールしましょう。</p>
          <h3>コールする</h3>
          <input v-model="calltoid" placeholder="call id" />
          <button @click="makeCall" class="button--green">Call</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
let Peer;

if (process.client) {
  Peer = require("skyway-js");
}

export default {
  components: {},
  data() {
    return {
      APIKey: "",
      selectedAudio: "",
      selectedVideo: "",
      audios: [],
      videos: [],
      localStream: null,
      peerId: "",
      calltoid: ""
    };
  },
  methods: {
    // SkyWayのAPIキーを取得
    getAPIKey: function() {
      this.APIKey = "75a90790-44e1-48f3-bb81-6c8667867b98";
    },
    onChange: function() {
      if (this.selectedAudio != "" || this.selectedVideo != "") {
        this.connectLocalCamera();
      }
    },
    connectLocalCamera: async function() {
      const constraints = {
        audio: this.selectedAudio
          ? { deviceId: { exact: this.selectedAudio } }
          : false,
        video: this.selectedVideo
          ? { deviceId: { exact: this.selectedVideo } }
          : false
      };
      const stream = await navigator.mediaDevices.getUserMedia(constraints);
      document.getElementById("my-video").srcObject = stream;
      this.localStream = stream;
    },
    makeCall: function() {
      if (this.calltoid == "") {
        window.alert("Call先が見つかりません。");
        return;
      }
      const call = this.peer.call(this.calltoid, this.localStream);
      this.connect(call);
    },
    connect: function(call) {
      call.on("stream", stream => {
        const el = document.getElementById("their-video");
        el.srcObject = stream;
        el.play();
      });
    }
  },

  mounted: function() {
    // Skyway用Peerの生成
    this.getAPIKey();
    this.peer = new Peer({
      key: this.APIKey,
      debug: 3
    });
    // PeerIDの取得
    this.peer.on("open", () => {
      this.peerId = this.peer.id;
    });
    // 着信処理
    this.peer.on("call", call => {
      alert("着信がありました");
      call.answer(this.localStream);
      this.connect(call);
    });
    // エラー処理
    this.peer.on("error", err => {
      console.log(err.message);
    });
    // 切断処理
    this.peer.on("close", () => {
      console.log("通信が切断しました。");
    });
    //デバイスへのアクセス
    navigator.mediaDevices.enumerateDevices().then(deviceInfos => {
      for (let i = 0; i !== deviceInfos.length; ++i) {
        const deviceInfo = deviceInfos[i];
        if (deviceInfo.kind === "audioinput") {
          this.audios.push({
            text: deviceInfo.label || `Microphone ${this.audios.length + 1}`,
            value: deviceInfo.deviceId
          });
        } else if (deviceInfo.kind === "videoinput") {
          this.videos.push({
            text: deviceInfo.label || `Camera  ${this.videos.length - 1}`,
            value: deviceInfo.deviceId
          });
        }
      }
    });
  }
};
</script>
