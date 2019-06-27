<template>
  <v-layout align-center justify-center>
    <v-flex xs12 sm8 md4>
      <br>
      <h1 class="header">ML Store: Decentralized machine learning platform</h1>
      <br>
      <br>
      <v-card class="elevation-12">
        <v-toolbar dark color="green">
          <v-toolbar-title>Login to ML Store</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <v-text-field prepend-icon="person" name="login" label="Login" type="text" v-model="email"></v-text-field>
            <v-text-field
              prepend-icon="lock"
              name="password"
              label="Password"
              id="password"
              type="password"
              v-model="password"
            ></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green" @click="login">Login</v-btn>
        </v-card-actions>
      </v-card>
      <br>
      <br>
      <p style="text-align: center">Don't have an account ? Register 
        <router-link to="/register"> here </router-link>
      </p>
    </v-flex>
  </v-layout>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  components: {},
  data() {
    return {
      email: 'bibhutipd@gmail.com',
      password: 'password'
    };
  },

  methods: {
    login() {
      this.$store.dispatch('login', {
        email: this.email,
        password: this.password,
        callback: () => {
          this.$router.push("/");
        },
        handleError: () => {
          alert("Error logging in");
        }
      })
    }
  },

  created() {
  },

  computed: {}
};
</script>

<style scoped>

.header{
  text-align: center;
  color: #373737;
}
</style>
