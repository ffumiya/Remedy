<template>
    <div id="view" class="container-fluid">
        <stripe-component />
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {};
    },
    methods: {
        setAPIToken() {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + Laravel.apiToken;
        }
    },
    beforeCreate() {},
    created() {
        const userID = document
            .querySelector("meta[name='user-id']")
            .getAttribute("content");
        this.setAPIToken();
    }
};
</script>
