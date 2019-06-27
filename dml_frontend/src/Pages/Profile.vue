<template>
<div class="profile-container">
  <div class="cover">
    <img src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-male-3-512.png" class="profile-img">
  </div>
  <br>
  <div class="details" v-if="user">
    <h2>Name: {{user.username}}</h2>
    <h2>Email: {{user.email}}</h2>
    <h2>Role: {{user.role ? 'ML Engineer' : 'Customer'}}</h2>
    <h2>Date Joined: {{user.created_at}}</h2>
    <br>
    <hr>
    <br>
    <h1>Credits: {{parseFloat(user.credits).toFixed(2)}} $</h1>
  </div>
</div>
</template>

<script>
export default {
  name: "Profile",
  components: {  },
  data() {
    return {
    };
  },

  methods: {

  },

  created() {
    this.$store.dispatch('validateToken', {
      token: localStorage.getItem('token'),
      callback: (user) => {
        this.$store.commit('setUser', user);
      }
    })
  },

  computed: {
    user() {
      return this.$store.state.user;
    }
  }
};
</script>

<style scoped lang="scss">
  .profile-container{
    width: 90%;
    margin: 0 auto;
    background-color: whitesmoke;

    .cover{
      width: 100%;
      height: 200px;
      background-image: url('http://s3.amazonaws.com/digitaltrends-uploads-prod/2017/07/machinelearning.jpg');
      background-size: cover;
      margin-top: 50px;
      text-align: center;


      .profile-img{
        height: 100px;
        width: 100px;
        border-radius: 50%;
        margin: 0 auto;
        margin-top: -40px;
        border: 5px solid grey;
      }

    }

  }
</style>
