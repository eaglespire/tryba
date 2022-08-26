<template>
  <div @click.self="closeNav" class="fixed lg:relative lg:hidden top-0 left-0 h-full  w-full bg-overlay z-50">
    <div class="flex justify-end" >
      <div v-show="show" ref="menu" class="bg-white h-screen w-264 px-3 transition-transform duration-300 translate-x-full" >
          <div class="py-5 px-3 flex justify-between flex-grow">
                <div class="" >
                    <a href="/"><img :src="asset + 'asset/new_homepage/logo.svg'" class="lg:h-8 w-auto h-6"  alt="tryba"></a>
                </div> 
              <button @click="closeNav">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
          </div>
          <div class="font-inter my-4 grid grid-rows-2 gap-4" >
              <a v-if="!loggedIn" href="javascript:void(0)" @click="openRegisterModal" class="bg-brand py-3 text-center w-full text-white rounded-lg">Open an account</a>
              <a v-else href="register" class="bg-brand py-3 text-center w-full text-white rounded-lg">Open an account</a>
              <a v-if="!loggedIn" href="javascript:void(0)" @click="openLoginModal" class="text-brand text-center border-brand border py-3 w-full rounded-lg">Log in</a>
              <a v-else href="login" class="text-brand text-center border-brand border py-3 w-full rounded-lg">Log in</a>
          </div>
          <ul class="grid grid-rows-1 gap-8 pt-4 mt-4 font-inter px-3 font-semibold">
               <li>
                    <a href="/" :class="{'text-brand': this.$route.name == 'Home'}" class="font-semibold flex space-x-3">
                       Home
                    </a> 
                </li>
              <li>
                    <a href="features" :class="{'text-brand': this.$route.name == 'Features'}" class="font-semibold flex space-x-3">
                       Features
                    </a> 
                </li>
                <li>
                    <a href="/pricing" :class="{'text-brand': this.$route.name == 'Pricing'}" class="font-semibold flex space-x-3">
                       Pricing
                    </a> 
                </li>
                <!-- <li>
                    <a href="https://tryba.io/blog" class="font-semibold flex space-x-3">
                       Resources
                    </a> 
                </li> -->
                <li>
                     <a href="https://helpdesk.tryba.io/en/" class="font-semibold flex space-x-3">
                        Support 
                    </a> 
                </li>
          </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    emits:['closeNav','scrollToFeatures','LoginModal','RegisterModal'],
    data(){
        return{
            loggedIn: window.user.user,
        }
    },
    props:['asset','showNav'],
    computed:{
        show(){
            if(this.showNav){
                this.openNav()
            }
            return this.showNav
        }
    },
    methods:{
        closeNav(){
            this.$refs.menu.classList.add('translate-x-full')
            setTimeout(()=>{
                this.$emit('closeNav')
            },300)
        },
        openNav(){
            setTimeout(()=>{
                this.$refs.menu.classList.remove('translate-x-full')
            },100)
        },
        scrollToFeatures(){
            this.$emit('scrollToFeatures')
            this.closeNav();
        },
        openLoginModal(){
            this.$emit('LoginModal')
        },
        openRegisterModal(){
            this.$emit('RegisterModal')
        }
    }
}
</script>

<style>
.bg-overlay{
    background: rgba(0, 0, 0, 0.8);
}
</style>