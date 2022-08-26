<template>
  <section id="header" class="z-50 text-sm sticky"  >
    <div class="container mx-auto py-4 lg:py-6 lg:px-14 px-3">
      <div class="flex justify-between items-center" >
          <div class="" >
               <a href="/"><img :src="asset + 'asset/new_homepage/logo.svg'" class="w-auto h-8"  alt="tryba"></a>
          </div>
          <div class="hidden lg:block" >
              <ul class="flex space-x-16 text-sm font-medium">
                  <li v-if="this.$route.name != 'Home'" class="relative">
                    <a href="/" class="flex space-x-2 items-center" >
                        <p :class="{'border-b-2 pb-1 border-brand': this.$route.name == 'Home'}">Home</p> 
                      </a>  
                  </li>
                  <li class="relative">
                    <a href="features" class="flex space-x-2 items-center" >
                        <p :class="{'border-b-2 pb-1 border-brand': this.$route.name == 'Features'}">Features</p> 
                      </a>  
                  </li>
                  <li>
                     <a href="pricing" class="flex space-x-2 items-center" >
                      <p :class="{'border-b-2 pb-1 border-brand': this.$route.name == 'Pricing'}">Pricing</p> 
                     </a>
                  </li>
                  <!-- <li class="relative">
                    <a href="https://tryba.io/blog" class="flex space-x-3 items-center" >
                      <p class="">Resources</p> 
                    </a>
                  </li> -->
                  <li class="relative">
                    <a href="https://helpdesk.tryba.io" class="flex space-x-2 items-center" >
                       <p :class="{'border-b-2 pb-1 border-brand': this.$route.name == 'Support'}">Support</p> 
                    </a>
                  </li>
                </ul>
          </div>
          <div id="mobileNavIcon" class="lg:hidden  top-2 right-2">
              <button @click="toogleNav" class="bg-brand rounded-full p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button> 
          </div>
          <div class="hidden lg:flex space-x-4">
            <div>
              <a v-if="!loggedIn" href="javascript:void(0)" @click="openLoginModal" class="border-brand border py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-brand transition duration-300  hover:opacity-70">Sign up</a>
              <a v-else href="login" class="border-brand border py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-brand transition duration-300  hover:opacity-70">Sign up</a>
            </div>
            <div>
              <a v-if="!loggedIn" href="javascript:void(0)" @click="openLoginModal" class="bg-brand py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-gray-100 transition duration-300  hover:opacity-70">Sign in</a>
              <a v-else href="login" class="bg-brand py-3 font-medium lg:px-6 px-4 text-sm lg:text-base rounded-md lg:rounded-lg text-gray-100 transition duration-300  hover:opacity-70">Sign in</a>
            </div>
          </div>
      </div>
    </div>
  </section>
  <MobileNav v-show="showNav" @RegisterModal="openRegisterModal" @LoginModal="openLoginModal" :showNav="showNav" :asset="asset" @scrollToFeatures="startScrolling" @closeNav="toogleNav"/>
</template>

<script>
import MobileNav from './MobileNav.vue'
import { scrollTo , scrollIntoView } from 'scroll-js';
export default {
  name:"Header",
  props:['asset'],
  components:{
    MobileNav
  },
  emits:['openLoginModal', 'openRegisterModal'],
  data(){
    return{
        showSolution:false,
        showTryba:false,
        showLearn:false,
        showNav:false,
        loggedIn: window.user.user,
    }
  },
  methods:{
    startScrolling(){
      if(this.$route.name == "Home"){
        let position = document.querySelector('#features')//.getBoundingClientRect().top;
        scrollIntoView(position, document.body, { behavior: 'smooth' })
      }else{
          let r = this.$router.resolve({
          name: 'Home',
        });
        window.location.assign(r.href)
      }
    },
    toogleNav(){
      this.showNav = !this.showNav
    },
    addBackground(){
       let scroll = window.scrollY;
        let menu = document.querySelector("#mobileNavIcon")
        if (scroll > 10) {
            menu.classList.add("fixed");
        }else{
            menu.classList.remove("fixed");
        }
    },
    openLoginModal(){
        this.$emit('openLoginModal')
    },
    openRegisterModal(){
       this.$emit('openRegisterModal')
    }
  },
  created(){
      window.addEventListener('scroll', this.addBackground);
  }
}
</script>

<style>

</style>