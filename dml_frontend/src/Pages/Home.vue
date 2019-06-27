<template>
  <div>
    <v-card class="models-container">
      <v-subheader>Popular Models</v-subheader>
      <div v-if="popularModels.length > 0">
        <Model v-for="(m, i) in popularModels" :key="i" :model="m"/>
      </div>
    </v-card>
    <br>
    <v-card class="models-container">
      <v-subheader>Other Models</v-subheader>
      <div v-if="otherModels.length > 0">
        <Model v-for="(m, i) in otherModels" :key="i" :model="m"/>
      </div>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import Model from "@/Components/Model.vue";

export default {
  name: "Home",
  components: { Model },
  data() {
    return {
      drawer: false,
      popularModels: [],
      otherModels: []
    };
  },

  methods: {
    checkUser(){
      if(!localStorage.getItem('token')) this.$router.push("/login");
    }
  },

  created() {
    this.checkUser();

    this.$store.dispatch("getPopularModels", {
      callback: models => {
        this.popularModels = models;
      }
    });

    this.$store.dispatch("getOtherModels", {
      callback: models => {
        this.otherModels = models;
      }
    });

  },

  computed: {
    user(){
      return this.$store.state.user;
    }
  }
};
</script>

<style scoped>
.models-container {
  float: left;
  width: 100%;
  overflow-x: auto;
  margin-bottom: 10px;
}
</style>
