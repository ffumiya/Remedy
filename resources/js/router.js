import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./views/Home.vue";
import Payment from "./views/Payment.vue";
import NotFound from "./views/NotFound.vue";
import Video from "./views/Video.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/home",
            name: "home",
            component: Home
        },
        {
            path: "/payment/:id",
            name: "payment",
            component: Payment
        },
        {
            path: "/video/:id",
            name: "video",
            component: Video
        },
        {
            path: "*",
            component: NotFound
        }
    ]
});

export default router;
