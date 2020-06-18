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
            <div>
                <div
                    class="card"
                    v-for="event in bookingEvents"
                    v-bind:key="event.id"
                >
                    <p>{{ event.title }}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 bg-white">
            <h1>カレンダーコンポーネント</h1>
            <calendar-component :events="bookedEvents" />
        </div>
    </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue";

export default {
    components: { FullCalendar },
    data() {
        return {
            viewHeight: "",
            allEvents: [],
            bookedEvents: [],
            bookingEvents: []
        };
    },
    methods: {
        resize() {
            this.viewHeight = `${innerHeight}px`;
        },
        getEvents(userID) {
            axios
                .get(`api/events/${userID}`)
                .then(res => {
                    console.table(res.data);
                    this.allEvents = res.data;
                    this.allEvents.forEach(event => {
                        if (event.start != null) {
                            this.bookedEvents.push(event);
                        }
                        if (event.start == null) {
                            this.bookingEvents.push(event);
                        }
                    });
                    console.table(this.bookedEvents);
                    console.table(this.bookingEvents);
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
        this.resize();
        addEventListener("resize", this.resize);
        this.getEvents(userID);
    }
};
</script>
