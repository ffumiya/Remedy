<template>
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
            <div id="external-events">
                <div
                    class="card fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event"
                    v-for="event in bookingEvents"
                    v-bind:key="event.id"
                >
                    <p>患者ID：{{ event.id }}</p>
                    <p>患者名：{{ event.name }} 様</p>
                    <p>希望時間：{{ event.desired_time }}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 bg-white">
            <!-- <calendar-component :events="bookedEvents" /> -->
            <p>カレンダー</p>
            <FullCalendar
                :plugins="calendarPlugins"
                v-bind:events="bookedEvents"
                :header="{
                    left: 'title',
                    center: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    right: 'prev today next'
                }"
                :weekends="true"
                :selectable="true"
                :droppable="true"
                :locale="locale"
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
                            <div class="card">
                                <p>患者名</p>
                                <p>{{ selectedEvent.name }}</p>
                            </div>
                        </div>
                        <div class="modal-footer" v-if="selectedEvent">
                            <button
                                type="button"
                                class="btn btn-primary"
                                v-if="selectedEvent.payment_method_id != null"
                                v-on:click="toVideo"
                            >
                                ビデオ診療開始
                            </button>

                            {{ selectedEvent.payment_method_id }}
                            <button
                                type="button"
                                class="btn btn-primary"
                                v-if="!selectedEvent.payment_method_id"
                                disabled
                            >
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
                                    placeholder="患者名を入力"
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
        </div>
    </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import jaLocale from "@fullcalendar/core/locales/ja"; // 日本語化用
import axios from "axios";
import moment from "moment";

const userID = document
    .querySelector("meta[name='user-id']")
    .getAttribute("content");

// var Draggable = FullCalendar.Draggable;

export default {
    components: {
        FullCalendar,
        moment
    },
    data() {
        return {
            viewHeight: "",
            allEvents: [],
            bookedEvents: [],
            bookingEvents: [],
            calendarPlugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            locale: jaLocale,
            eventTimeFormat: { hour: "numeric", minute: "2-digit" },
            defaultView: "timeGridWeek",
            height: 0,
            firstDay: 1,
            scrollTime: "",
            selectedEvent: null
        };
    },
    methods: {
        resize() {
            this.viewHeight = `${innerHeight}px`;
        },
        getEvents(userID) {
            axios
                .get(`api/events?userID=${userID}`)
                .then(res => {
                    console.log(res);
                    this.allEvents = res.data;
                    this.allEvents.forEach(event => {
                        if (event.start != null) {
                            this.bookedEvents.push(event);
                        }
                        if (event.start == null) {
                            this.bookingEvents.push(event);
                        }
                    });
                })
                .catch(error => console.error(error));
        },
        setAPIToken() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + Laravel.apiToken;
        },
        handleSelect(arg) {
            this.selectedEvent = arg;
            jQuery("#modalForSelect").modal("show");
        },
        handleDateClick(arg) {},
        handleEventClick(arg) {
            this.selectedEvent = arg.event;
            console.log(this.selectedEvent);
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
                    this.bookingEvents.push(event);
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
            var payment_method_id = this.getPaidAt();
            var name = this.getPatientName();
            return {
                id: this.getOnetime_token(),
                host_id: userID,
                guest_id: 1,
                title: this.selectedEvent.title,
                start: this.selectedEvent.start,
                // start: new Date(),
                end: this.selectedEvent.end,
                extendedProps: this.selectedEvent.extendedProps,
                price: price,
                payment_method_id: payment_method_id,
                name: name,
                selectable: true,
                editable: true
            };
        },
        updateEvent() {
            var newEvent = this.buildEvent();
            jQuery("#modalForSelect").modal("hide");
            axios
                .put(`/api/events/${userID}`, Object.assign({}, newEvent))
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
                if (this.selectedEvent.extendedProps.payment_method_id) {
                    return this.selectedEvent.extendedProps.payment_method_id;
                }
            } catch (e) {
                return null;
            }
        },
        getPatientName() {
            try {
                if (this.selectedEvent.extendedProps.name) {
                    return this.selectedEvent.extendedProps.name;
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
    },
    created() {
        this.setAPIToken();
        this.resize();
        addEventListener("resize", this.resize);
        this.getEvents(userID);
        var containerEl = document.getElementById("external-events");
        new Draggable(containerEl, {
            itemSelector: ".fc-event",
            eventData: {
                title: "event"
            }
        });
    }
};
</script>
