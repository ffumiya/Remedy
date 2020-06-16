import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./views/Home.vue";
import NotFound from "./views/NotFound.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/home",
            component: Home
        },
        {
            path: "*",
            component: NotFound
        }
    ]
});

export default router;
