<template>
    <section>
        <p>カレンダー</p>
        <FullCalendar
            :plugins="calendarPlugins"
            v-bind:events.sync="eventsProrperty"
            :header="{
                left: 'title',
                center: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                right: 'prev today next'
            }"
            :weekends="true"
            :selectable="true"
            :dropable="true"
            :locale="locale"
            :timeZone="timeZone"
            :eventTimeFormat="eventTimeFormat"
            :defaultView="defaultView"
            :height="height"
            :firstDay="firstDay"
            :scrollTime="scrollTime"
            @select="handleSelect"
            @dateClick="handleDateClick"
            @eventClick="handleEventClick"
            @eventResize="handleEventResize"
            @eventDrop="handleEventDrop"
        />

        <!-- Begin modal window for click event -->
        <div id="modalForClick" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">予定の詳細</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="selectedEvent != null">
                        <div class="card">
                            <p>診察日程</p>
                            <p>
                                {{
                                    selectedEvent.start
                                        | moment("YYYY.MM.DD HH:mm")
                                }}
                                ～
                                {{ selectedEvent.end | moment("HH:mm") }}
                            </p>
                        </div>
                        <div v-if="guestInfo">
                            <div class="card">
                                <p>患者名</p>
                                <p>{{ guestInfo.name }}</p>
                            </div>
                        </div>
                        <div v-else>
                            <div class="card">
                                <p>患者情報を取得できませんでした。</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="selectedEvent">
                        <button
                            type="button"
                            class="btn btn-primary"
                            v-if="guestInfo && selectedEvent.paid_at != null"
                            v-on:click="toVideo"
                        >
                            ビデオ診療開始
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            v-if="!selectedEvent.paid_at"
                            disabled
                        >
                            {{ selectedEvent.paid_at }}
                            料金支払い待ち
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            閉じる
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal window -->

        <!-- Begin modal window for select -->
        <div id="modalForSelect" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">予定の新規作成</h5>
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
                        <form v-if="selectedEvent != null">
                            <input
                                name="title"
                                type="text"
                                class="form-control"
                                placeholder="タイトルを入力"
                                v-model="selectedEvent.title"
                            />
                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                placeholder="金額を入力"
                                v-model="selectedEvent.price"
                            />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            v-on:click="createEvent"
                        >
                            作成
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
    </section>
</template>

<script>
require("@fullcalendar/core/main.min.css");
require("@fullcalendar/daygrid/main.min.css");
require("@fullcalendar/timegrid/main.min.css");

import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import jaLocale from "@fullcalendar/core/locales/ja"; // 日本語化用
import axios from "axios";
import moment from "moment";

export default {
    props: {
        events: null
    },
    components: {
        FullCalendar,
        moment
    },
    data() {
        return {
            userID: null,
            options: {
                animation: 200
            },
            calendarPlugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            locale: jaLocale,
            timeZone: "Asia/Tokyo",
            eventTimeFormat: { hour: "numeric", minute: "2-digit" },
            businessHours: true,
            defaultView: "timeGridWeek",
            selectedEvent: null,
            height: 0,
            firstDay: 1,
            scrollTime: "",
            guestInfo: null
        };
    },
    methods: {
        handleSelect(arg) {
            this.selectedEvent = arg;
            jQuery("#modalForSelect").modal("show");
        },
        handleDateClick(arg) {},
        handleEventClick(arg) {
            this.selectedEvent = arg.event;
            axios
                .get(
                    `/api/patient/${this.selectedEvent.extendedProps.guest_id}`
                )
                .then(res => {
                    this.guestInfo = res.data;
                    console.log("Get patient data");
                })
                .catch(err => {
                    this.guestInfo = null;
                    console.error(err);
                    console.error("failed to get patient data");
                });
            jQuery("#modalForClick").modal("show");
        },
        handleEventResize(arg) {
            this.selectedEvent = arg.event;
            this.updateEvent();
        },
        handleEventDrop(arg) {
            this.selectedEvent = arg.event;
            this.updateEvent();
        },
        resize() {
            this.height = innerHeight - 150;
        },
        getConfig(userID) {},
        getScrollTime() {
            this.scrollTime = "7:00:00";
        },
        createEvent() {
            var event = this.buildEvent();
            if (!event.title) {
                return;
            }
            console.log(event.start);
            jQuery("#modalForSelect").modal("hide");
            axios
                .post("/api/events", Object.assign({}, event))
                .then(res => {
                    this.events.push(event);
                    console.log("completed post event");
                })
                .catch(err => {
                    console.error(err);
                    alert("予定の作成に失敗しました。");
                    console.error("failed to post event");
                });
        },
        getOnetime_token() {
            if (this.selectedEvent.id) {
                return this.selectedEvent.id;
            } else {
                return moment(new Date())
                    .unix()
                    .toString();
            }
        },
        buildEvent() {
            var price = this.getPrice();
            var paid_at = this.getPaidAt();
            return {
                id: this.getOnetime_token(),
                host_id: this.userID,
                guest_id: 1,
                title: this.selectedEvent.title,
                start: this.selectedEvent.start,
                // start: new Date(),
                end: this.selectedEvent.end,
                extendedProps: this.selectedEvent.extendedProps,
                price: price,
                paid_at: paid_at,
                selectable: true,
                editable: true
            };
        },
        updateEvent() {
            var newEvent = this.buildEvent();
            jQuery("#modalForSelect").modal("hide");
            axios
                .put(`/api/events/${this.userID}`, Object.assign({}, newEvent))
                .then(res => {
                    this.events.forEach(event => {
                        if (event.id == newEvent) {
                            event = newEvent;
                        }
                    });
                    console.log("completed move event");
                })
                .catch(err => {
                    console.error(err);
                    alert("予定の変更に失敗しました。");
                    console.error("failed to post event");
                });
        },
        toVideo() {
            jQuery("#modalForClick").modal("hide");
            this.$router.push({
                name: "video",
                params: { id: this.selectedEvent.id }
            });
        },
        getPaidAt() {
            try {
                if (this.selectedEvent.paid_at) {
                    return this.selectedEvent.paid_at;
                }
            } catch (e) {
                return null;
            }
        },
        getPrice() {
            try {
                if (this.selectedEvent.price) {
                    return this.selectedEvent.price;
                }
            } catch (e) {
                return 0;
            }
        }
    },
    created() {
        try {
            this.resize();
            this.getScrollTime();
            addEventListener("resize", this.resize);
            this.userID = document
                .querySelector("meta[name='user-id']")
                .getAttribute("content");
            this.getConfig(this.userID);
        } catch (err) {
            console.log(err);
        }
    },
    mounted() {},
    computed: {
        eventsProrperty: {
            get() {
                return this.events;
            },
            set(value) {
                this.$emit("update:events", value);
            }
        }
    },
    filters: {
        moment(value, format) {
            var time = "";
            time = moment(value).format(format);
            if (time.toString() === "Invalid date") {
                return "";
            }
            return time;
        },
        exceptUserID(value) {
            return value.replace("/\([0-9].*\)/g");
        }
    }
};
</script>

<style>
.item {
    display: inline-block;
    margin: 10px;
    padding: 10px;
    border: 1px solid #7f7f7f;
    border-radius: 10px;
    background-color: #ffffff;
}
.item:hover {
    cursor: grab;
}
.item:active {
    cursor: grabbing;
}
td.fc-sat {
    background-color: #eaf4ff;
}
td.fc-sun {
    background-color: #ffeaea;
}
</style>
