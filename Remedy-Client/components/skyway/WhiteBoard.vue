<template>
  <div>
    <h1>ホワイトボード</h1>
    <canvas id="board"></canvas>
    <p>{{ x }},{{ y }}</p>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      ctx: null,
      canvas: null,
      isDrawing: false,
      x: 0,
      y: 0
    };
  },
  props: {
    width: 0,
    height: 0
  },
  methods: {
    beginPath(e) {
      console.log("mouse down");
      this.ctx.strokeStyle = "lightgreen";
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
      this.ctx.stroke();
    },
    endPath(e) {
      console.log("mouse up");
      this.isDrawing = false;
      let { x, y } = this.calcPos(e);
      this.ctx.lineTo(x, y);
      this.ctx.stroke();
      this.ctx.closePath();
    },
    calcPos(e) {
      let x = e.clientX - this.canvas.offsetLeft;
      let y = e.clientY - this.canvas.offsetTop - 50;
      this.x = x;
      this.y = y;
      return { x, y };
    }
  },
  mounted: function() {
    this.canvas = document.getElementById("board");
    this.canvas.width = this.width;
    this.canvas.height = this.height;
    this.ctx = this.canvas.getContext("2d");
    this.canvas.addEventListener("mousedown", this.beginPath);
    this.canvas.addEventListener("mousemove", this.strokePath);
    this.canvas.addEventListener("mouseup", this.endPath);
  }
};
</script>
