<template>
    <section>
        <p>カレンダー</p>
        <FullCalendar
            :plugins="calendarPlugins"
            :events="events"
            :header="{
                left: 'title',
                center: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                right: 'prev today next'
            }"
            :weekends="true"
            :selectable="true"
            :dropable="true"
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
                        <h5 class="modal-title">予定の編集</h5>
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
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">
                            保存
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
                                name="start"
                                type="text"
                                class="form-control"
                                v-model="selectedEvent.start"
                            />
                            <input
                                name="title"
                                type="text"
                                class="form-control"
                                placeholder="タイトルを入力"
                                v-model="selectedEvent.title"
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
import draggable from "vuedraggable";
import axios from "axios";

class Event {}

export default {
    components: {
        FullCalendar,
        draggable
    },
    data() {
        return {
            options: {
                animation: 200
            },
            calendarPlugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            locale: jaLocale,
            eventTimeFormat: { hour: "numeric", minute: "2-digit" },
            businessHours: true,
            defaultView: "timeGridWeek",
            events: [],
            selectedEvent: null,
            height: 0,
            firstDay: 1,
            scrollTime: ""
        };
    },
    methods: {
        handleSelect(arg) {
            this.selectedEvent = arg;
            console.table(this.selectedEvent);
            jQuery("#modalForSelect").modal("show");
        },
        handleDateClick(arg) {},
        handleEventClick(calEvent, jsEvent, view) {
            jQuery("#modalForClick").modal("show");
        },
        handleEventResize(arg) {
            alert("handleEventResize");
        },
        handleEventDrop(arg) {
            alert("handleEventDrop");
        },
        resize() {
            this.height = innerHeight - 150;
        },
        getEvents(userID) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + Laravel.apiToken;
            axios
                .get(`api/events/${userID}`)
                .then(res => {
                    this.events = res.data;
                    console.log(this.events);
                })
                .catch(error => console.error(error));
        },
        getConfig(userID) {},
        getScrollTime(userID) {
            this.scrollTime = "7:00:00";
        },
        createEvent() {
            this.events.push({
                title: this.selectedEvent.title,
                start: this.selectedEvent.start,
                // allDay: this.selectedEvent.allDay,
                selectable: true,
                editable: true
            });
            jQuery("#modalForSelect").modal("hide");
            // axios.defaults.headers.common["Authorization"] =
            //     "Bearer " + Laravel.apiToken;
            console.log(this.selectedEvent);
            axios
                .post("/api/events", this.selectedEvent.toString())
                .then(res => {
                    console.log("completed post event");
                })
                .catch(err => {
                    console.error(err);
                    console.error("failed posting event");
                });
        }
    },
    created() {
        this.resize();
        this.getScrollTime();
        addEventListener("resize", this.resize);
        const userID = document
            .querySelector("meta[name='user-id']")
            .getAttribute("content");
        this.getConfig(userID);
        this.getEvents(userID);
    },
    mounted() {}
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
