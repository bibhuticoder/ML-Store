<template>
  <v-app>
    <Drawer v-if="user" :show="drawer" @hide="drawer = false" :user="user" />
    <template v-if="loading">
      <Loading />
    </template>

    <template v-else>
      <template v-if="navbarType === 'Run'">
        <Run/>
      </template>

      <template v-else>
        <navbar :navbarType="navbarType" @drawerHandlerClicked="drawer = true"/>
        <br>
        <br>
        <v-content>
          <v-container fluid>
            <router-view></router-view>
          </v-container>
        </v-content>
        <v-footer app></v-footer>
      </template>
    </template>
  </v-app>
</template>

<script>
import Navbar from "./Components/Navbar.vue";
import Run from "./Pages/Run.vue";
import Loading from './Components/Loading.vue';
import axios from "axios";
import Drawer from "@/Components/Drawer.vue";

export default {
  components: {
    Navbar,
    Run,
    Loading,
    Drawer
  },
  name: "app",
  data() {
    return {
      drawer: false,
      navbarType: null,
      loading: false
    };
  },

  methods: {},

  created() {
    this.navbarType = this.$route.name;
    this.loading = true;
    if(localStorage.getItem("token")){
      // proceed
      this.$store.dispatch('validateToken', {
        token: localStorage.getItem("token"),
        callback: (user) => {
          console.log(user);
          this.$store.commit('setUser', user);
          this.loading = false;
          this.$router.push("/");
        },
        handleError: () => {
          this.$router.push("/login");
          this.loading = false;
        }
      });
    } else{
      // goto login page
      this.$router.push("/login");
      this.loading = false;
    }
  },

  computed: {
    user() {
      return this.$store.getters.user;
    }
  },
  watch: {
    $route(to, from) {
      if(to) this.navbarType = to.name;
    }
  }
};
</script>
