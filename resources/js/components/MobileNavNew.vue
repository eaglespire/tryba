<template>
  <div @click.self="closeNav" class="fixed lg:relative lg:hidden top-0 left-0 h-full  w-full bg-overlay z-50">
    <div class="flex justify-end" >
      <div v-show="show" ref="menu" class="bg-brand text-gray-100 h-screen relative w-full px-3 transition-transform duration-300 translate-x-full" >
            <div class="py-10 px-4 flex justify-between flex-grow">
                    <div class="" >
                        <a href="/"><img :src="asset + 'asset/new_homepage/logo-white.svg'" class="lg:h-8 w-auto h-6"  alt="tryba"></a>
                    </div> 
                <button @click="closeNav">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <ul class="grid grid-rows-1 gap-8 pt-4 mt-4 font-inter px-4 font-semibold">
               <li class="pb-2 border-b border-white/20">
                    <a href="/" class="flex justify-between font-semibold">
                        <span class="block">Home</span>
                        <div class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </a> 
                </li>
                <li class="pb-2 border-b border-white/20">
                    <a href="features" class="flex justify-between font-semibold">
                        <span class="block">Features</span>
                        <div class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </a> 
                </li>
                <li class="pb-2 border-b border-white/20">
                    <a href="pricing" class="flex justify-between font-semibold">
                        <span class="block">Pricing</span>
                        <div class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </a> 
                </li>
                <li class="pb-2 border-b border-white/20">
                    <a href="https://tryba.io/blog" class="flex justify-between font-semibold">
                        <span class="block">Resources</span>
                        <div class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </a> 
                </li>
                <li class="pb-2 border-b border-white/20">
                    <a href="https://helpdesk.tryba.io/en/" class="flex justify-between font-semibold">
                        <span class="block">Support</span>
                        <div class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 -rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </a> 
                </li>
            </ul>
            <div class="font-inter absolute bottom-2 left-0 w-full my-4 px-6 grid grid-rows-2 gap-4" >
                <a v-if="!loggedIn" href="javascript:void(0)" @click="openLoginModal" class="text-brand text-center bg-white py-4 w-full rounded-lg">Sign in</a>
                <a v-else href="login" class="text-brand text-center bg-white py-4 w-full rounded-lg">Sign in</a>
            </div>
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