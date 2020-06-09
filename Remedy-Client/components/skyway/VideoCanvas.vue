<template>
  <div>
    <canvas id="canvas"></canvas>
  </div>
</template>

<script>
export default {
  data() {
    return {
      canvas: null
    };
  },
  props: {
    width: 0,
    height: 0,
    stream: null,
    video: null
  },
  methods: {},
  mounted: function() {
    this.canvas = document.getElementById("canvas");
    let framerate = 1000 / 10; // 10fps
    setInterval(function() {
      this.canvas
        .getContext("2d")
        .drawImage(this.stream, 0, 0, this.width, this.height);
    }, framerate);
  }
};
</script>
