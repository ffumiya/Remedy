<template>
    <div id="view" class="container-fluid">
        <div class="row">
            <div
                class="col-xs-12 col-md-6 bg-light"
                v-bind:style="{ height: viewHeight }"
            >
                <div>
                    <h1>Remedy</h1>
                    <h3>診察スケジュール一覧</h3>
                </div>
                <p>説明文</p>
                <div>
                    <div class="card">
                        <div class="row">
                            <div class="col">
                                <p class="card-text">01</p>
                            </div>
                            <div class="col">
                                <p>患者名</p>
                            </div>
                            <div class="col">
                                都道府県？
                            </div>
                            <div class="col">
                                病名
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col">
                                <p class="card-text">01</p>
                            </div>
                            <div class="col">
                                <p>患者名</p>
                            </div>
                            <div class="col">
                                都道府県？
                            </div>
                            <div class="col">
                                病名
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col">
                                <p class="card-text">01</p>
                            </div>
                            <div class="col">
                                <p>患者名</p>
                            </div>
                            <div class="col">
                                都道府県？
                            </div>
                            <div class="col">
                                病名
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 bg-white">
                <h1>カレンダーコンポーネント</h1>
                <calendar-component />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            viewHeight: ""
        };
    },
    methods: {
        resize() {
            this.viewHeight = `${innerHeight}px`;
        }
    },
    created() {
        this.resize();
        addEventListener("resize", this.resize);
    }
};
</script>
