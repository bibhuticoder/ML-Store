import Vue from "vue";
import Router from "vue-router";

import Login from "@/Pages/Login";
import Register from "@/Pages/Register";

import Home from "@/Pages/Home";
import ModelDetail from "@/Pages/ModelDetail";
import Run from "@/Pages/Run";
import Updates from "@/Pages/Updates";
import Profile from "@/Pages/Profile";

Vue.use(Router);

const router = new Router({
  routes: [
    { path: "/login", name: "Login", component: Login },
    { path: "/register", name: "Register", component: Register },

    { path: "/", name: "Home", component: Home },
    { path: "/models/:id", name: "ModelDetail", component: ModelDetail },
    { path: "/updates", name: "Updates", component: Updates },
    { path: "/models/:id/run", name: "Run", component: Run },
    { path: "/profile", name: "Profile", component: Profile },
  ]
});

export default router;
