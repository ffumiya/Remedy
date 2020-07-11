<template>
    <div class="continaer">
        <h1>Remedy</h1>
        <div>
            <h3>予約一覧</h3>
            <div v-if="events.length == 0">
                <h4>現在の予定はありません。</h4>
                <p>医師から診療予定が追加されるまでお待ちください。</p>
            </div>
            <div class="card" v-for="event in events" v-bind:key="event.id">
                <div class="row">
                    <div class="col">
                        <p>{{ event.title }}</p>
                    </div>
                    <div class="col">
                        担当医：
                        <span v-if="event.host_id">{{ event.host_id }}</span>
                        <span v-else>調整中</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        開始時間：
                        <span v-show="event.start">
                            {{ event.start | moment("MM/DD HH:mm~") }}
                        </span>
                        <span v-show="!event.start">
                            日程調整中
                            <span v-show="event.desired_time"
                                >(希望時間：
                                <span>{{ event.desired_time }}</span>
                                ~)</span
                            >
                        </span>
                    </div>
                    <div
                        class="col"
                        v-if="
                            event.payment_method_id == null &&
                                event.start != null
                        "
                    >
                        <a
                            v-bind:href="`/payment/` + event.id"
                            class="btn btn-primary"
                        >
                            料金お支払い
                        </a>
                    </div>
                    <div
                        class="col"
                        v-if="
                            event.payment_method_id != null &&
                                event.start != null
                        "
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
            <div class="row">
                <div class="col m-5">
                    <button class="btn btn-primary" v-on:click="showModal">
                        オンライン診療を申込む
                    </button>
                </div>
            </div>

            <!-- Begin modal window for create event -->
            <div id="modalForCreate" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">オンライン診療申込</h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form v-if="event">
                                <label for="clinic"
                                    >診療を希望する病院を選択してください。</label
                                >
                                <select
                                    name="clinic"
                                    class="form-control"
                                    disabled
                                >
                                    <option value="0" selected
                                        >Remedy病院</option
                                    >
                                </select>
                                <label for="doctor"
                                    >診療を希望する医師を選択してください。</label
                                >
                                <select name="doctor" class="form-control">
                                    <option value="" disabled selected
                                        >---医師を選択してください---</option
                                    >
                                    <option value="0">○○先生</option>
                                    <option value="1">△△先生</option>
                                    <option value="2">××先生</option>
                                </select>
                                <label for="date"
                                    >診療を希望する日時を選択してください。<small
                                        >※診療時間は30分が目安です。</small
                                    ></label
                                >
                                <p v-show="event.date.err" class="text-danger">
                                    {{ event.date.err }}
                                </p>
                                <input
                                    type="datetime-local"
                                    name="date"
                                    class="form-control"
                                    placeholder="希望日時"
                                    v-model="event.date.datetime"
                                />
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-primary"
                                v-on:click="createEvent"
                            >
                                申し込む
                            </button>
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                キャンセル
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End modal window -->
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    components: { moment },
    data() {
        return {
            event: null,
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
        },
        showModal() {
            jQuery("#modalForCreate").modal("show");
        },
        createEvent(e) {
            console.log(this.event);
            if (this.event.date.datetime == "") {
                this.event.date.err = "日時を正しく指定してください。";
                return;
            }
            this.event.date.err = null;

            this.sendNewEvent();
            jQuery("#modalForSelect").modal("hide");
            this.initializeEvent();
        },
        initializeEvent() {
            this.event = {
                clinic: {
                    id: null,
                    name: "",
                    err: null
                },
                doctor: {
                    id: null,
                    name: "",
                    err: null
                },
                date: {
                    datetime: "",
                    err: null
                }
            };
        },
        sendNewEvent() {
            axios
                .post("/api/event", Object.assign({}, this.event))
                .then(res => {
                    this.events.push(event);
                    console.log("completed post event");
                })
                .catch(err => {
                    console.error(err);
                    alert("オンライン診療の申込に失敗しました。");
                    console.error("failed to post event");
                });
        }
    },
    created() {
        const userID = document
            .querySelector("meta[name='user-id']")
            .getAttribute("content");
        this.setAPIToken();
        this.getEvents(userID);
        this.initializeEvent();
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
