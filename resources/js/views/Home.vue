<template>
    <div id="view" class="container-fluid">
        <div v-if="role == 0">Now loading...</div>
        <div v-else-if="role >= 100">
            <doctor-home-component />
        </div>
        <div v-else>
            <patient-home-component />
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            role: 0
        };
    },
    methods: {
        getRole(userID) {
            axios
                .get(`api/role/${userID}`)
                .then(res => {
                    this.role = res.data;
                })
                .catch(error => console.error(error));
        },
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
        this.getRole(userID);
    }
};
</script>
