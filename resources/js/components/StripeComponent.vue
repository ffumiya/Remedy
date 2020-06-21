<template>
    <div>
        <h1>Stripe</h1>
        {{ $route.params.id }}
        <button class="btn btn-primary" v-on:click="pay">支払う</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            eventID: null
        };
    },
    methods: {
        pay() {
            axios
                .post(`/api/events/${this.eventID}`)
                .then(res => {
                    this.$router.push({ name: "home" });
                })
                .catch(error => console.error(error));
        },
        setAPIToken() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + Laravel.apiToken;
        }
    },
    created() {
        this.eventID = this.$route.params.id;
        const userID = document
            .querySelector("meta[name='user-id']")
            .getAttribute("content");
        this.setAPIToken();
    }
};
</script>
