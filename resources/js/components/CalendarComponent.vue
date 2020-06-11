<template>
    <section>
        <p>カレンダー</p>
        <FullCalendar
            :plugins="calendarPlugins"
            :events="events"
            :header="{
                left: 'title',
                center: 'dayGridMonth, timeGridWeek, timeGridDay, listWeek',
                right: 'prev today next'
            }"
            :weekends="true"
            :selectable="true"
            @select="handleSelect"
        />
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
import axios from "axios";

export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            calendarPlugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
            events: ""
        };
    },
    methods: {
        handleSelect(arg) {
            console.log(arg);
        }
    }
};
</script>
