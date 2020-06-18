import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./views/Home.vue";
import Payment from "./views/Payment.vue";
import NotFound from "./views/NotFound.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/home",
            component: Home
        },
        {
            path: "/payment",
            component: Payment
        },
        {
            path: "*",
            component: NotFound
        }
    ]
});

export default router;
