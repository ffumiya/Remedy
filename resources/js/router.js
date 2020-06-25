import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./views/Home.vue";
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
