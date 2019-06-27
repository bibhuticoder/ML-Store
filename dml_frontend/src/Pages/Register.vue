<template>
  <v-layout align-center justify-center>
    <v-flex xs12 sm8 md4>
      <br>
      <h1 style="text-align: center">Start using ML Store today</h1>
      <br>
      <br>
      <v-card class="elevation-12">
        <v-toolbar dark color="green">
          <v-toolbar-title>Register form</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-form>
            <v-text-field prepend-icon="person" v-model="username" label="Username" type="text"></v-text-field>
            <v-text-field prepend-icon="email" v-model="email" label="Email" type="email"></v-text-field>
            <v-text-field prepend-icon="lock" v-model="password" label="Password" type="password"></v-text-field>
            <v-text-field prepend-icon="lock" v-model="rePassword" label="Retype password" type="password"></v-text-field>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green" @click="register">Register</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import axios from "axios";

export default {
  name: "Register",
  components: {},
  data() {
    return {
      username: 'user1',
      email: 'user1@gmail.com',
      password: 'password',
      rePassword: 'password'
    };
  },

  methods: {
    register() {
      if(this.password !== this.rePassword){
        alert("Passwords does not match");
        return;
      }
      this.$store.dispatch("register", {
        username: this.username,
        email: this.email,
        password: this.password,
        rePassword: this.rePassword,
        callback: models => {
          this.$router.push('/');
        }
      });

    }
  },

  created() {

  },

  computed: {}
};
</script>

<style scoped>
</style>
