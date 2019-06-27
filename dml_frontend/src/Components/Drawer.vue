<template>
  <v-navigation-drawer v-model="showMe" absolute temporary>
    <v-list class="pa-1">
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-male-3-512.png">
        </v-list-tile-avatar>

        <v-list-tile-content>
          <v-list-tile-title>{{user.username}}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
    <v-divider></v-divider>
    <v-list class="pt-0" dense>
      <v-list-tile v-for="(link, i) in links" :key="i">
        <v-list-tile-action>
          <v-icon>{{link.icon}}</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title @click="goto(link.link_to)">
            {{link.display_name}}
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  name: "Drawer",
  props: ["show", "user"],
  data() {
    return {
      links: [
        {
          display_name: "Dashboard",
          icon: "fa-th",
          link_to: "/"
        },
        {
          display_name: "My Updates",
          icon: "fa-shopping-basket",
          link_to: "/updates"
        },
        {
          display_name: "Profile",
          icon: "fa-user-circle",
          link_to: "/profile"
        },
        {
          display_name: "Logout",
          icon: "fa-sign-out-alt",
          link_to: "/login"
        }
      ]
    };
  },

  methods: {
    goto(path){
      if(path === '/logout'){
        localStorage.removeItem('token');
      }
      this.$router.push(path);
    }
  },

  computed: {
    showMe: {
      get() {
        return this.show;
      },
      set(value) {
        if (!value) this.$emit("hide");
      }
    }
  }
};
</script>

<style scoped lang="scss">
</style>
