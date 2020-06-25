<template>
    <div class="continaer">
        <h1>Remedy</h1>
        <div>
            <h3>予約一覧</h3>
            <div class="card" v-for="event in events" v-bind:key="event.id">
                <div class="row">
                    <div class="col">
                        <p>{{ event.title }}</p>
                    </div>
                    <div class="col">担当医：{{ event.host_id }}</div>
                </div>
                <div class="row">
                    <div class="col">
                        開始時間：
                        <span v-if="event.start != null">
                            {{ event.start | moment("MM/DD HH:mm~") }}
                        </span>
                        <span v-if="event.start == null">
                            日程調整中
                        </span>
                    </div>
                    <div
                        class="col"
                        v-if="event.paid_at == null && event.start != null"
                    >
                        <!-- <router-link
                            v-bind:to="{
                                name: 'payment',
                                params: { id: event.id }
                            }"
                            class="btn btn-primary"
                        >
                            料金お支払い
                        </router-link> -->
                        <a
                            v-bind:href="`/payment/` + event.id"
                            class="btn btn-primary"
                        >
                            料金お支払い
                        </a>
                    </div>
                    <div
                        class="col"
                        v-if="event.paid_at != null && event.start != null"
                    >
                        <router-link
                            v-bind:to="{
                                name: 'video',
                                params: { id: event.id }
                            }"
                            class="btn btn-primary"
                            >ビデオ診療開始</router-link
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    components: { moment },
    data() {
        return {
            events: [],
            userid: 1
        };
    },
    methods: {
        getEvents(userID) {
            axios
                .get(`api/events?userID=${userID}`)
                .then(res => {
                    console.table(res.data);
                    this.events = res.data;
                })
                .catch(error => console.error(error));
        },
        setAPIToken() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + Laravel.apiToken;
        }
    },
    created() {
        const userID = document
            .querySelector("meta[name='user-id']")
            .getAttribute("content");
        this.setAPIToken();
        this.getEvents(userID);
    },
    filters: {
        moment(value, format) {
            let time = "";
            time = moment(value).format(format);
            if (time.toString() === "Invalid date") {
                return "";
            }
            return time;
        }
    }
};
</script>
