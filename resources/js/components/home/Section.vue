<template>
    <section class="container overflow-hidden mx-auto py-8 px-3 lg:px-14" >
        <div class="grid grid-rows-1 lg:grid-cols-3">
            <div class="flex item-center py-3 lg:py-24 lg:col-span-2 " >
                <div>
                    <p class="font-extrabold text-4xl lg:text-5xl">
                        Smart banking account that <br>
                        help you create your <br>
                        <span class="text-brand" >{{ brandText }}</span>
                        for free! <br>
                    </p>
                    <p class="text-2xl  lg:text-3xl font-bold my-2 lg:my-4" >Built for solo business owners</p>
                    <p class="font-inter lg:my-4 my-2 font-semibold">Tryba is a safe and secure platform to launch your storefront and accept <br> online payments with no chargebacks. </p>
                    <div class="flex justify-start lg:space-x-4 space-x-3 my-8" >
                        <a href="register" class="bg-brand flex text-sm lg:text-base space-x-5 lg:space-x-6 items-center px-4 lg:px-6 lg:py-3 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                            <p>Get started now</p> 
                            <div class="bg-gray-100 rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                        <a href="contact" class="flex space-x-5 lg:space-x-6 text-sm lg:text-base items-center px-2 lg:px-6 lg:py-3 py-3 rounded-lg font-inter font-normal transition duration-300  hover:opacity-70" >
                            <p>Book Demo</p> 
                            <div class="bg-black rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3  text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="flex justify-center lg:block" >
                    <div class="relative h-96 px-6">
                        <img :src="asset + 'asset/new_homepage/icons/vector.png'" class="opacity-0 lg:opacity-100" alt="">
                        <div ref="blur" class="absolute lg:top-10 lg:left-14 left-28 top-8 transition duration-3000 ease-in-out transform-gpu ">
                            <img :src="asset + 'asset/new_homepage/icons/blur-card.png'" alt="blur">
                        </div>
                        <div ref="phone" class="absolute -top-4 lg:left-6 left-24 transition duration-3000 ease-in-out transform-gpu">
                            <img :src="asset + 'asset/new_homepage/icons/phone.png'" class="drop-shadow-2xl" alt="App">
                        </div>
                        <div ref="card" class="absolute lg:bottom-0 bottom-4 lg:-left-16 left-12 transition duration-3000 ease-in-out transform-gpu">
                            <img :src="asset + 'asset/new_homepage/icons/card.png'" class="h-32 w-auto lg:h-auto object-cover" alt="Card">
                        </div> 
                    </div>
                </div>
                <div class="hidden space-x-4 mt-24 px-4" >
                    <div><a href="https://apps.apple.com/gb/app/tryba/id1590314942"><img :src="asset + 'asset/new_homepage/icons/app-store.png'" alt="App Store"></a></div>
                    <div><a href="https://play.google.com/store/apps/details?id=com.tryba.io"><img :src=" asset + 'asset/new_homepage/icons/google-play.png'" alt="Google play"></a></div>
                </div>     
            </div>
        </div>

    </section>
</template>

<script>
export default {
    name:"Section",
    props:['asset'],
    data(){
        return{
            brandText:"business website",
            allText:[
                'business website','storefront','invoices','booking/appointment','payment links'
            ]
        }
    },
    methods:{
        changeText(){
            setInterval(()=>{
                let index = this.allText.indexOf(this.brandText);
                 let postion = index + 1
                if(postion == this.allText.length){
                    this.brandText = this.allText[0]; 
                }else{
                    this.brandText = this.allText[postion]; 
                }        
            },1000)
             
        },
        addEffect(){
            setInterval(()=>{
                if(this.$refs.blur.classList.contains('-translate-x-16')){
                    this.$refs.blur.classList.remove('-translate-x-16')
                }else{
                    this.$refs.blur.classList.add('-translate-x-16')
                }
                //phone
                if(this.$refs.phone.classList.contains('-rotate-20')){
                    this.$refs.phone.classList.remove('-rotate-20')
                }else{
                    this.$refs.phone.classList.add('-rotate-20')
                }
                //card
                 if(this.$refs.card.classList.contains('rotate-20')){
                    this.$refs.card.classList.remove('rotate-20')
                }else{
                    this.$refs.card.classList.add('rotate-20')
                }
            },5000)
        }
    },
     mounted(){
        this.changeText()
        this.addEffect()
     }
}
</script>

<style>

</style>