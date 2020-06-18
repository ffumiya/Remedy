<template>
    <div id="view" class="container-fluid">
        <div v-if="role < 100">
            <patient-home-component />
        </div>
        <div v-else>
            <doctor-home-component />
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            role: null
        };
    },
    methods: {
        getRole(userID) {
            axios
                .get(`api/role/${userID}`)
                .then(res => {
                    this.role = res.data.role;
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
