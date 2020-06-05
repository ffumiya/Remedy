<template>
  <section>
    <div>
      <div>
        <h2>オンライン診療(ルーム)</h2>
        <div>
          <video
            class="secondary"
            id="my-video"
            muted="true"
            height="150"
            width="200"
            autoplay
            playsinline
          ></video>
          <div id="remoteVideos"></div>
        </div>

        <div>
          <v-switch v-model="mute" :label="`ミュート：${mute}`"></v-switch>
          <v-btn @click="joinToRoom" class="success">Join</v-btn>
          <v-btn @click="closeRoom" class="error">Exit</v-btn>
          <v-btn outlined color="red">
            <v-icon>mdi-record-circle-outline</v-icon>
            録画する
          </v-btn>
        </div>

        <div>
          <div style="margin-top: 100px;">
            <h2>マイク・カメラ設定</h2>
            <v-select
              v-on:change="onChange"
              v-model="selectedAudio"
              :items="audios"
              filled
              label="マイクを選択してください"
            ></v-select>
          </div>
          <div>
            <v-select
              v-on:change="onChange"
              v-model="selectedVideo"
              :items="videos"
              filled
              label="カメラを選択してください"
            ></v-select>
          </div>
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
      roomName: "",
      room: null,
      audios: [],
      selectedAudio: "",
      videos: [],
      selectedVideo: "",
      localStream: null,
      mute: false
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
  },
  methods: {
    // SkyWayのAPIキーを取得
    getAPIKey: function() {
      this.APIKey = "75a90790-44e1-48f3-bb81-6c8667867b98";
      console.log(`APIKEY = ${this.APIKey}`);
    },
    // ルーム名の取得
    getRoomName: function() {
      this.roomName = "Remedy";
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
      const stream = await navigator.mediaDevices
        .getUserMedia(constraints)
        .catch(err => {
          console.error(`getUserMedia() has failed ${err}`);
        });
      document.getElementById("my-video").srcObject = stream;
      this.localStream = stream;
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
        remoteVideo.srcObject.getTracks().forEach(track => track.stop());
        remoteVideo.srcObject = null;
        remoteVideo.remove();
        console.table(remoteVideos);
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
          remoteVideo.srcObject.getTracks().forEach(track => track.stop());
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
      newVideo.height = 150;
      newVideo.width = 200;
      newVideo.autoplay = true;
      newVideo.setAttribute("streem-peer-id", stream.peerId);
      document.getElementById("remoteVideos").appendChild(newVideo);
      console.log("Videoを追加しました。");
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
