<template> </template>

<script>
import moment from "moment";

const userID = document
    .querySelector("meta[name='user-id']")
    .getAttribute("content");

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

            const sended = this.sendNewEvent();
            if (sended) {
                this.getEvents(userID);
                jQuery("#modalForCreate").modal("hide");
                this.initializeEvent();
            }
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
            return axios
                .post("/api/event", Object.assign({}, this.event))
                .then(res => {
                    this.events.push(event);
                    console.log("completed post event");
                    return true;
                })
                .catch(err => {
                    console.error(err);
                    alert("オンライン診療の申込に失敗しました。");
                    console.error("failed to post event");
                    return false;
                });
        }
    },
    created() {
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
