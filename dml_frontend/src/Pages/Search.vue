<template>
  <div>
    <v-card class="models-container">
      <v-subheader>Search Results</v-subheader>
      <div v-if="popularModels.length > 0">
        <Model v-for="(m, i) in popularModels" :key="i" :model="m"/>
      </div>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import Model from "@/Components/Model.vue";

export default {
  name: "Search",
  components: { Model },
  data() {
    return {
      popularModels: [],
      otherModels: []
    };
  },

  methods: {},

  created() {

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

  computed: {}
};
</script>

<style scoped>
.models-container {
  float: left;
  width: 100%;
  /* min-width: 100%; */
  /* max-width: 100%; */
  overflow-x: auto;
  margin-bottom: 10px;
}
</style>
