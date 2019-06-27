import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
Vue.use(Vuex);

// axios config
window.BASE_URL = "http://127.0.0.1:8000/api/";
var backendApi = axios.create({
  baseURL: BASE_URL
});

export const store = new Vuex.Store({
  state: {
    user: null
  },

  getters: {
    baseUrl(state) {
      return state.baseUrl;
    },
    user(state) {
      return state.user;
    }
  },

  mutations: {
    setUser(state, user) {
      state.user = user;
    }
  },

  actions: {

    validateToken(context, payload){
      backendApi.defaults.headers.Authorization = "Bearer " + payload.token;
      backendApi
        .get(BASE_URL + "auth/me")
        .then(response => {
          payload.callback(response.data);
        })
        .catch(error => {
          payload.handleError();
        });
    },

    register(context, payload) {
      backendApi
        .post(BASE_URL + "auth/register", {
          username: payload.username,
          email: payload.email,
          password: payload.password,
          password_confirmation: payload.rePassword,
          role: 'customer'
        })
        .then(response => {
          backendApi.defaults.headers.Authorization = "Bearer " + response.data.token;
          localStorage.setItem('token', response.data.token);
          backendApi.get("auth/me").then(response => {
            payload.callback(response.data);
          });
        })
        .catch(error => {
          payload.handleError();
        });
    },

    login(context, payload) {
      backendApi
        .post(BASE_URL + "auth/login", {
          email: payload.email,
          password: payload.password
        })
        .then(response => {
          backendApi.defaults.headers.Authorization = "Bearer " + response.data.token;
          localStorage.setItem('token', response.data.token);
          backendApi.get("auth/me").then(response => {
            payload.callback(response.data);
          });
        })
        .catch(error => {
          payload.handleError();
        });
    },

    getPopularModels(context, payload) {
      backendApi
        .get("models/popular")
        .then(response => payload.callback(response.data));
    },

    getOtherModels(context, payload) {
      backendApi
        .get("models")
        .then(response => payload.callback(response.data));
    },

    getModelDetail(context, payload) {
      backendApi
        .get("models/" + payload.id)
        .then(response => payload.callback(response.data));
    },

    getUpdates(context, payload) {
      backendApi
        .get("updates/")
        .then(response => payload.callback(response.data));
    },

    submitReview(context, payload) {
      backendApi
        .post("models/" + payload.model_id + "/reviews", payload.review)
        .then(response => payload.callback(response.data));
    },

    getReviewDetail(context, payload) {
      backendApi
        .get("model-reviews/" + payload.review_id)
        .then(response => payload.callback(response.data));
    },

    submitUpdates(context, payload) {
      backendApi
        .post(`/models/${payload.model_id}/updates`, payload.formdata)
        .then(response => payload.callback(response.data));
    },

    getFile(context, payload) {
      backendApi
        .get("file?filepath=" + payload.filepath)
        .then(response => payload.callback(response.data));
    }
  }
});
