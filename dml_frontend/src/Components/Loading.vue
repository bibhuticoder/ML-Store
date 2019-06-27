<template>
  <div class="loading">Loading...</div>
</template>

<script>
export default {
  components: {},
  name: "Loading",
  data() {
    return {};
  },
  methods: {},

  created() {},

  mounted() {},

  computed: {}
};
</script>

<style scoped>
.loading {
  position: absolute;
  top: calc(50% - 50px);
  left: calc(50% - 50px);
  height: 100px;
  width: 100px;
  text-align: center;
}
</style>
