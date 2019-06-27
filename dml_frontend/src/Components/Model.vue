<template>
  <div class="model" @click="navigateToDetail(model.id)">
    <img :src="model.thumbnail_path" class="thumbnail">
    <div class="ratings">
      <v-icon small color="yellow" v-for="(r,i) in parseInt(model.ratings + 1)" :key="i">star</v-icon>
    </div>
    <div class="model-title text-truncate">{{model.title}}</div>
    <div class="version">Version: {{model.version}}</div>
    <div class="credits">Credits: {{model.credits_per_training}} $</div>
  </div>
</template>

<script>
export default {
  name: "Model",
  props: ["model"],
  data() {
    return {};
  },
  methods: {
    navigateToDetail(id){
      this.$router.push(`/models/${id}`);
    }
  },
  computed: {}
};
</script>

<style scoped lang="scss">
.model{
  width: 150px;
  background-color: whitesmoke;
  box-shadow: -1px -1px 10px dimgrey;
  height: 160px;
  margin: 10px;
  border-radius: 2px;
  text-align: center;
  padding: 5px;
  cursor: pointer;
  float: left;

  .thumbnail{
    height: 50%;
    width: auto;
  }

  .model-title{
    text-align: left;
    font-weight: bold;
    color: #373737;
    font-size: 14px;
  }

  .version{
    font-size: 12px;
    text-align: left;
    color: grey;
  }

  .credits{
    font-size: 12px;
    text-align: left;
    color: grey;
  }
}
</style>
