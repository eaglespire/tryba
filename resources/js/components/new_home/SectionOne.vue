<template>
    <section class="bg-gray-100" >
        <div class="container overflow-hidden mx-auto py-14 px-4 lg:px-24">
            <div v-if="slides[0]" class="grid grid-rows-1 mx-6 lg:mx-0 gap-6 lg:place-items-center lg:gap-8 lg:grid-cols-12 relative animate__animated animate__fadeIn">
                <div class="flex justify-center lg:justify-start item-center py-3 lg:py-14 lg:col-span-7" >
                    <div>
                        <p class="font-extrabold text-center text-black lg:text-left text-2xl lg:text-5xl">
                            Your Banking,<br class="hidden lg:block">
                            Payments and Business<br class="hidden lg:block">
                            needs in one place
                        </p>
                        <p class="text-sm lg:text-base  text-center lg:text-left font-inter my-4 lg:my-4" >Intelligent banking built right into the heart <br class="hidden lg:block"> of business and payment.</p>
                        <div class="flex justify-center lg:justify-start lg:space-x-4 space-x-3 my-6 lg:my-8" >
                            <a v-if="!loggedIn" @click="openRegisterModal" href="javascript:void(0)" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-14 lg:px-8 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                <p>Open Account</p> 
                            </a>
                            <a v-else href="register" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-14 lg:px-8 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                <p>Open Account</p> 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-5" >
                    <div class="flex justify-end flex-grow w-full -mt-7 lg:-mt-14">
                        <img :src="asset + 'asset/new_homepage/images/header.png'" class="lg:h-96 w-auto object-fit" alt="">
                    </div>
                </div>
            </div>
            <div  v-if="slides[1]" class="grid grid-rows-1 gap-8 lg:mx-0 lg:gap-8 lg:grid-cols-12 relative animate__animated animate__fadeIn">
                <div class="flex justify-center lg:justify-start item-center py-3 lg:py-14 lg:col-span-6 " >
                    <div>
                        <p class="font-extrabold text-center mx-6 lg:mx-0 text-black lg:text-left text-2xl lg:text-5xl">
                            Get GBP & EUR <br>
                            Business accounts <br class="hidden lg:block">
                            & visa cards
                        </p>
                        <p class="text-sm lg:text-base text-center lg:text-left font-inter my-4 lg:my-4" >Tryba business accounts is equipped  <br class="hidden lg:block">with Visa cards for your business.</p>
                        <div class="flex justify-center lg:justify-start lg:space-x-4 space-x-3 my-6 lg:my-8" >
                            <a v-if="!loggedIn" @click="openRegisterModal" href="javascript:void(0)" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-14 lg:px-8 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                <p>Open Account</p> 
                            </a>
                            <a v-else href="register" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-14 lg:px-8 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                <p>Open Account</p> 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-grow items-center  w-full lg:col-span-6" >
                    <div class="flex justify-center lg:justify-end border-red right-0 top-10 w-full -mt-7 lg:-mt-14">
                        <img :src="asset + 'asset/new_homepage/images/header-2.png'" class="w-auto object-fit" alt="">
                    </div>
                </div>
            </div>  
            <div v-if="slides[2]" class="flex flex-col-reverse lg:grid lg-gap-8 lg:gap-0 lg:grid-cols-12 relative animate__animated animate__fadeIn">
                <div class="flex flex-grow items-center lg:col-span-6" >
                    <div class="px-6 flex flex-grow justify-start">
                        <img :src="asset + 'asset/new_homepage/images/header-3.png'" class="w-auto object-fit" alt="">
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end item-center py-3 mb-8 lg:mb-0 lg:py-14 lg:col-span-6 " >
                    <div>
                        <p class="font-extrabold text-center  mx-6 lg:mx-0 text-black lg:text-right text-2xl lg:text-5xl">
                            Business tools in one<br class="hidden lg:block">
                            place, ensure speed,<br class="hidden lg:block">
                            efficiency & profit
                        </p>
                        <p class="text-sm lg:text-base  text-center lg:text-right font-inter my-4 lg:my-4" >
                            With built-in web and storefront templates, payment <br class="hidden lg:block">
                            collection and settlement, off you go in 10mins.
                        </p>
                        <div class="flex justify-center lg:justify-end lg:space-x-4 space-x-3 my-6 lg:my-8" >
                            <a v-if="!loggedIn" @click="openRegisterModal" href="javascript:void(0)" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-8 lg:px-8 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                <p>Open Account</p> 
                            </a>
                            <a v-else href="register" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-8 lg:px-8 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                <p>Open Account</p> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex  justify-center space-x-2 my-6  lg:my-0">
                <div @click="slider" :class="{'bg-brand w-10': slides[0],'bg-gray-400 w-4': !slides[0]}" class=" h-1  rounded-3xl"></div>
                <div @click="slider" :class="{'bg-brand w-10': slides[1],'bg-gray-400 hidden w-4': !slides[1]}" class=" h-1  rounded-3xl"></div>
                <div @click="slider" :class="{'bg-brand w-10': slides[2],'bg-gray-400 hidden w-4': !slides[2]}" class=" h-1  rounded-3xl"></div>
            </div>
        </div>
    </section>
</template>

<script>
import 'animate.css';
export default {
    name:"Section",
    props:['asset'],
    emits:['openLoginModal','openRegisterModal'],
    data(){
        return{
            brandText:"business website",
            slides:[
                true,false,false,
            ],
            fullWidth:window.innerWidth,
            loggedIn: window.user.user,
        }
    },
    methods:{
        changeSlides(){
            setInterval(()=>{
                let index = this.slides.indexOf(true);
                let postion = index + 1   
                 this.slides[index] = false;             
                if(postion > 2){
                    this.slides[0] = true;
                }else{
                    this.slides[postion] = true;
                }        
            },8000)
             
        },
        openRegisterModal(){
            this.$emit('openRegisterModal')
        },
        slider(){
            let index = this.slides.indexOf(true);
            let postion = index + 1   
                this.slides[index] = false;             
            if(postion > 2){
                this.slides[0] = true;
            }else{
                this.slides[postion] = true;
            }           
        }
    },
     mounted(){
        // if(this.fullWidth > 700){
        //    this.changeSlides();        
        // }
    }
}
</script>

<style>

</style>