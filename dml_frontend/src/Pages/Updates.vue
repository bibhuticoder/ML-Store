<template>
  <div>
    <v-card class="models-container">
      <v-subheader>All Model Updates</v-subheader>
      <v-data-table :headers="headers" :items="updates" class="elevation-1">
        <template v-slot:items="props">
          <td>{{ props.item.id }}</td>
          <td>
            <router-link :to="{ path: 'models/' + props.item.model_id }">{{ props.item.model_name }}</router-link>
          </td>
          <td>Rs. {{ props.item.credits_earned }}</td>
          <td>{{ props.item.created_at }}</td>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Updates",
  components: {},
  data() {
    return {
      headers: [
        { text: "Id", value: "id" },
        { text: "Model", value: "model_name" },
        { text: "Credits", value: "credits_earned" },
        { text: "Date", value: "created_at" }
      ],

      updates: []
    };
  },

  methods: {},

  created() {
    this.$store.dispatch("getUpdates", {
      callback: updates => (this.updates = updates)
    });
  },

  computed: {}
};
</script>

<style scoped>
</style>
