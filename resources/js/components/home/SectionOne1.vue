<template>
    <section class="-mt-24">
        <div :style="'background-image:url('+ asset + 'asset/new_homepage/images/image-header.png' + ')'" class="relative bg-cover bg-black/90 lg:bg-[center_center] bg-[70%_center] h-screen">      
            <div class="container h-full w-full flex lg:items-center item-end mx-auto py-2 lg:py-6 lg:px-14 px-3 text-white">
                <div class="grid grid-rows-1 lg:grid-cols-2 lg:mt-36">
                    <div class="flex lg:items-center items-end py-3 mb-24 lg:mb-0 lg:py-16 lg:col-span-2 " >
                        <div>
                            <p class="font-extrabold text-3xl lg:text-5xl">  
                                 Your banking, payments <br class="hidden lg:block">and business needs <br class="hidden lg:block">
                                <span class="text-brand">all in one place.</span>
                            </p>
                            <p class="lg:text-xl text-base  font-inter my-2 lg:my-4" >Sign up for a tryba business account and you get a debit <br class="hidden lg:block"> card and all the tools to grow your business, from website <br class="hidden lg:block"> and storefront to booking, expenses and invoicing.</p>
                            <div class="flex justify-start flex-grow space-x-3 lg:space-x-4 my-8" >
                                <a v-if="!loggedIn" href="javascript:void(0)"  @click="openRegisterModal" class="bg-white border-white border flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-4 lg:px-6 lg:py-3 py-3 rounded-lg text-brand font-inter font-normal transition duration-300  hover:opacity-70" >
                                    <p>Open an account</p> 
                                    <div class="bg-brand rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                                <a v-else href="register" class="bg-white border-white border flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-4 lg:px-6 lg:py-3 py-3 rounded-lg text-brand font-inter font-normal transition duration-300  hover:opacity-70" >
                                    <p>Open an account</p> 
                                    <div class="bg-brand rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                                <a v-if="!loggedIn" @click="openLoginModal"  class="flex space-x-5 lg:space-x-6 text-sm lg:text-base items-center px-2 lg:px-6 lg:py-3 py-3 rounded-lg font-inter font-normal transition duration-300  hover:opacity-70" >
                                    <p>Log in</p> 
                                    <div class="bg-white rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3  text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                                <a v-else href="login" class="flex space-x-5 lg:space-x-6 text-sm lg:text-base items-center px-2 lg:px-6 lg:py-3 py-3 rounded-lg font-inter font-normal transition duration-300  hover:opacity-70" >
                                    <p>Log in</p> 
                                    <div class="bg-white rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3  text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>
            </div>
            <div class="absolute hidden bottom-10 lg:bottom-20 w-full">
                <div class="flex justify-center" >
                    <button @click="startScrolling('started')" >
                        <div ref="firstArrow" class="transition duration-200 ease-in-out" >
                            <img :src="asset + 'asset/new_homepage/icons/arrow-down.svg'" alt="">
                        </div>
                        <div ref="bouncing" class="transition duration-200 -translate-y-3 opacity-0 ease-in-out">
                            <img :src="asset + 'asset/new_homepage/icons/arrow-down.svg'" alt="">
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { scrollTo , scrollIntoView } from 'scroll-js';
export default {
    name:"Section",
    props:['asset'],
    emits:['openLoginModal','openRegisterModal'],
    data(){
        return{
            showComingSoon:true,
            loggedIn: window.user.user,
        }
    },
    methods:{
        bounceArrow(){
            setInterval(()=>{
                if (this.$refs.bouncing.classList.contains('-translate-y-3') && this.$refs.bouncing.classList.contains('opacity-0') ) {
                    this.$refs.bouncing.classList.remove('-translate-y-3');
                    this.$refs.bouncing.classList.remove('opacity-0');
                    this.$refs.bouncing.classList.add('translate-y-0.5');
                    this.$refs.firstArrow.classList.add('translate-y-1');
                    this.$refs.bouncing.classList.add('opacity-100');
                }else{
                     this.$refs.firstArrow.classList.remove('translate-y-1');
                    this.$refs.bouncing.classList.remove('translate-y-0.5');
                    this.$refs.bouncing.classList.remove('opacity-100');
                    this.$refs.bouncing.classList.add('-translate-y-3');
                    this.$refs.bouncing.classList.add('opacity-0'); 
                }
                
            },500)
            
        },
        startScrolling(elem){
            let position = document.querySelector('#'+elem)//.getBoundingClientRect().top;
            // scrollTo(document.body, { top:position + 50 , easing: 'ease-in' ,'duration' :500 })
            scrollIntoView(position, document.body, { behavior: 'smooth' })
        },
        closeComingSoon(){
            this.showComingSoon = !this.showComingSoon
        },
        openLoginModal(){
            this.$emit('openLoginModal')
        },
        openRegisterModal(){
            this.$emit('openRegisterModal')
        },
    },
    mounted(){
        this.bounceArrow();
    }
}
</script>

<style>

</style>