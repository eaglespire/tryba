<template>
  <div class="font-poppins text-sm lg:text-base">
    <router-view @openLoginModal="toggleLogin" @openRegisterModal="toggleRegister"/>
  </div>
  <Login v-if="showLogin"  @openRegisterModal="toggleRegister" @closeLoginModal="toggleLogin" />
  <Register v-if="showRegister" @openLoginModal="toggleLogin" @closeRegisterModal="toggleRegister"/>
</template>
<script>
import Login from './components/Login.vue';
import Register from './components/Register.vue';
export default {
  name:"App",
  components:{
    Login,Register
  },
  data(){
      return{
        showLogin:(window.location.pathname == '/login' ) ? true : false,
        showRegister:(window.location.pathname == '/register' ) ? true : false
      }
  },
  computed:{
      getRouteName(){
        return this.$route.name
      }
  },
  methods:{
      toggleLogin(){
          this.showLogin = !this.showLogin
          this.showRegister = false; 
      },
      toggleRegister(){
        this.showRegister = !this.showRegister
        this.showLogin = false;
      }
  }

}
</script>

<style>
button{
    -webkit-tap-highlight-color: rgba(0,0,0,0);
}
button,
a{
 -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
 -webkit-tap-highlight-color: transparent;
 -webkit-user-select: none;
 -khtml-user-select: none;
 -moz-user-select: none;
 -ms-user-select: none;
  user-select: none;
}
</style>
