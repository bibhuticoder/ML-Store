<template>
  <div>
    <template v-if="model">
      <div class="topbar">
        <h3>{{model.title}}</h3>

        <button class="btn btn-download-model" @click="downloadWeights">Download Weights</button>
        <button class="btn btn-download-model" @click="submitUpdate">Submit Update</button>
        <input type="file" class="file" @change="onFileChange">
      </div>
      <input
        hidden
        :value="'http://127.0.0.1:8000/api/file?filepath=' + model.model_path"
        id="model-path"
      >
      <div ref="app_container" class="app">Rendering...</div>
    </template>
    <template v-else>
      <Loading v-if="loading"/>
    </template>
  </div>
</template>

<script>
import Loading from "../Components/Loading.vue";

export default {
  name: "Run",
  components: {
    Loading
  },
  data() {
    return {
      model: null,
      loading: true,
      code: null,
      uploadedWeight: null
    };
  },

  methods: {
    attachScript() {
      this.$store.dispatch("getFile", {
        filepath: this.model.script_path,
        callback: data => {
          this.$refs.app_container.innerHTML = data;

          var script = document.createElement("script");
          script.type = "text/javascript";
          script.innerHTML = document.getElementById("code").value;
          document.body.appendChild(script);
          document.getElementById("code").value = "";
          document.getElementById("code").style.display = 'none';
        }
      });
    },

    downloadWeights() {
      window.model.save("downloads://model");
    },

    onFileChange(e) {
      if (e.target.files) {
        this.uploadedWeight = e.target.files[0];
      }
    },

    submitUpdate() {
      if (!this.uploadedWeight) {
        alert("Upload weights first");
        return;
      }
      var fd = new FormData();
      fd.append("weights", this.uploadedWeight);
      fd.append("model_id", this.model.id);
      fd.append("accuracy", 4);

      this.$store.dispatch("submitUpdates", {
        model_id: this.model.id,
        formdata: fd,
        callback: () => {
          alert("Weights Updated");
        }
      });
    }
  },

  mounted() {
    this.$store.dispatch("getModelDetail", {
      id: this.$route.params.id,
      callback: model => {
        this.model = model;
        this.loading = false;
        this.attachScript();
      }
    });
  },

  computed: {}
};
</script>

<style scoped>
.topbar {
  width: 100%;
  height: 50px;
  background-color: #373737;
  color: whitesmoke;
  line-height: 50px;
  padding-left: 20px;
}

h3 {
  float: left;
}

.btn {
  float: right;
  height: 30px;
  background-color: whitesmoke;
  color: #373737;
  border-style: solid;
  border-color: whitesmoke;
  border-width: 1px;
  margin: 5px;
  line-height: 20px;
  padding: 5px;
}

.file {
  float: right;
  width: 172px;
  height: 40px;
  margin: 5px;
}

.app{
  width: 100vw;
  height: calc(100vh - 50px);
}
</style>
