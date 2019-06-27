<template>
  <div>
    <v-toolbar color="#4CAF50" :fixed="true" dense>
      <template v-if="navbarType === 'Home' || navbarType === null">
        <v-btn icon>
          <v-icon color="white" @click="$emit('drawerHandlerClicked')">fa-bars</v-icon>
        </v-btn>
        <v-toolbar-title class="white--text">ML Store</v-toolbar-title>
        <v-spacer></v-spacer>

        <v-btn v-if="!searchBox" icon @click="enableSearch">
          <v-icon color="white">search</v-icon>
        </v-btn>
        <v-slide-x-transition>
          <v-text-field
            autofocus
            v-if="searchBox"
            height="50px"
            prepend-inner-icon="search"
            placeholder="Search..."
            single-line
            solo
            hide-details
            @keyup.enter="search"
            @keyup.esc="searchBox = false"
          ></v-text-field>
        </v-slide-x-transition>

        <v-menu offset-y>
          <template v-slot:activator="{ on }">
            <v-btn icon v-on="on">
              <v-icon color="white">more_vert</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-tile @click="logout()">
              <v-list-tile-title>Logout</v-list-tile-title>
            </v-list-tile>
          </v-list>
        </v-menu>
      </template>

      <template v-else-if="navbarType === 'ModelDetail' || navbarType === 'Updates' || navbarType === 'Profile'">
        <v-btn icon @click="$router.go(-1)">
          <v-icon color="white">fa-arrow-left</v-icon>
        </v-btn>
      </template>
    </v-toolbar>
  </div>
</template>

<script>


export default {
  components: { },
  name: "navbar",
  props: ["navbarType"],
  data() {
    return {
      searchBox: false
    };
  },
  methods: {
    enableSearch() {
      this.searchBox = true;
    },

    search() {
      this.searchBox = false;
    },

    logout(){
      localStorage.removeItem('token');
      this.$router.push('/login');
    }
  },

  created() {},

  mounted() {},

  computed: {
    loggedIn() {
      return this.$store.getters.user !== null;
    }
  },

};
</script>

<style scoped>
.navbar {
  border-radius: 0px !important;
  z-index: 500;
  background-color: #24292e;
  box-shadow: -1px 1px 2px gray;
  height: 50px;
  width: 100%;
}
</style>
