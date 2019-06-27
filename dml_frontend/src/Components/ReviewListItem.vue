<template>
  <v-list-tile avatar>
    <v-list-tile-avatar>
      <img
        src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-male-3-512.png"
      >
    </v-list-tile-avatar>

    <v-list-tile-content>
      <v-list-tile-title>{{review.username}}</v-list-tile-title>
      <v-list-tile-sub-title>
        {{review.content}}
        <v-btn icon @click="$emit('moreClicked')">
          <v-icon small>fa-ellipsis-h</v-icon>
        </v-btn>
      </v-list-tile-sub-title>
    </v-list-tile-content>
  </v-list-tile>
</template>



<script>
export default {
  name: "ReviewListItem",
  props: ["review"]
};
</script>

<style scoped lang="scss">
</style>
