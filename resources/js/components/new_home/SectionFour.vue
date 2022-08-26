<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                A Tryba story
            </div>
            <div class="text-center text-2xl hidden lg:block font-semibold">
              This is the story of how Tryba is helping small businesses to kickstart and scale. 
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl mt-4">
               This is the story <br> of how Tryba is <br> helping small <br> businesses to <br>
               <p class="p-3 bg-[#E8CA91] inline-block mt-2">Kickstart & scale</p>
           </div>
            <div :class="{
                    'bg-brand/20 ring-brand/10': slides[0], 
                    'bg-[#E0633914] ring-[#E0633914]/10': slides[1],
                    'bg-[#513FC814] ring-[#513FC814]/10': slides[2],
                    'bg-[#DFA92C14]/20 ring-[#DFA92C14]/10': slides[3] 
                 }" 
                class="my-8 hidden lg:block rounded-2xl p-16 ring-8 relative ">
                <div v-show="slides[0]" class="grid grid-cols-3 place-items-center">
                    <div class="col-span-2">
                        <h1 class="text-4xl text-black font-semibold">This is <span class="text-brand">SUE</span></h1>
                        <div class="my-6 text-black">
                            Sue is an aspiring entrepreneur who wants to start her online retail store but the complexity, cost and awful lot of time it takes to build & launch deterred her goal until she found tryba. 
                        </div>
                        <div>
                            <button class="px-10 py-3 bg-white rounded-lg text-sm text-brand">Get Started</button>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-center">
                            <img :src="asset + 'asset/new_homepage/images/girlandchair.png'" class="h-80 w-auto" alt="">
                        </div>
                    </div>
                </div>
                <div v-show="slides[1]" class="grid grid-cols-3 place-items-center">
                    <div class="col-span-2">
                        <h1 class="text-4xl text-black font-semibold">Yup! Sue found Tryba</h1>
                        <div class="my-6 text-black">
                            The digital banking platform that provide business accounts and cards, storefront, and essential business tools suitable for Sue to kickstart and manage her business effectively. 
                        </div>
                        <div>
                            <button class="px-10 py-3 bg-white rounded-lg text-sm text-brand">Get Started</button>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-center">
                            <img :src="asset + 'asset/new_homepage/images/bookings.png'" class="h-80 w-auto" alt="">
                        </div>
                    </div>
                </div>
                <div v-show="slides[2]" class="grid grid-cols-5 place-items-center">
                    <div class="col-span-3">
                        <h1 class="text-4xl text-black font-semibold">....and it only took Sue 10mins </h1>
                        <div class="my-6 text-black">
                            The process from setup to go live was only 10mins, now Sue has a complete storefront with custom domain and instant checkout that settles in seconds.
                        </div>
                        <div>
                            <button class="px-10 py-3 bg-white rounded-lg text-sm text-brand">Get Started</button>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="flex justify-center">
                            <img :src="asset + 'asset/new_homepage/images/instant-checkout.png'" class="h-80 object-fill w-auto" alt="">
                        </div>
                    </div>
                </div>
                <div v-show="slides[3]" class="grid grid-cols-3 place-items-center">
                    <div class="col-span-2">
                        <h1 class="text-4xl text-black font-semibold">Can I take payment from abroad? Sue asked</h1>
                        <div class="my-6 text-black">
                           Yes! with Tryba's multiple currency accounts and payment options, Sue can expand by taking payments globally. 
                        </div>
                        <div>
                            <button class="px-10 py-3 bg-white rounded-lg text-sm text-brand">Get Started</button>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-center">
                            <img :src="asset + 'asset/new_homepage/icons/Saly-1.png'" class="h-80 w-auto" alt="">
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-6 right-0 w-full">
                    <div class="flex justify-center space-x-8 ">
                        <div>
                            <button :class="{'opacity-70':slides[0]}" @click="prev" class="h-10 w-10 bg-white rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <button :class="{'opacity-70':slides[3]}" @click="next" class="h-10 w-10 bg-white rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
           </div> 
           <div id="overflow" class="flex space-x-4 overflow-x-auto lg:hidden my-8">
                <div class="bg-brand/20 relative overflow-hidden h-[560px] rounded-xl p-0 m-0 min-w-[100%]">
                    <div class="p-8">
                        <h1 class="text-2xl text-black font-semibold">This is <span class="text-brand">SUE</span></h1>
                        <div class="my-6 text-black">
                            Sue is an aspiring entrepreneur who wants to start her online retail store but the complexity, cost and awful lot of time it takes to build & launch deterred her goal until she found tryba. 
                        </div>
                        <div>
                            <button class="px-10 py-3 w-full bg-white rounded-lg text-sm text-brand">Open account</button>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <img :src="asset + 'asset/new_homepage/images/girlandchair.png'" class="h-80 w-auto" alt="">
                    </div>
               </div>
                <div class="bg-[#F2C8BF] relative overflow-hidden h-[560px] rounded-xl p-0 m-0 min-w-[100%]">
                    <div class="p-8">
                        <h1 class="text-2xl text-black font-semibold">Yup! Sue found Tryba</h1>
                        <div class="my-6 text-black">
                            The digital banking platform that provide business accounts and cards, storefront, and essential business tools suitable for Sue to kickstart and manage her business effectively. 
                        </div>
                        <div>
                            <button class="px-10 py-3 w-full bg-white rounded-lg text-sm text-brand">Open account</button>
                        </div>
                    </div>
                   <div class="flex justify-center mt-10">
                        <img :src="asset + 'asset/new_homepage/images/bookings.png'" class="h-[220px] w-auto" alt="">
                    </div>
               </div>
                <div class="bg-[#5140C914] relative overflow-hidden h-[560px] rounded-xl p-0 m-0 min-w-[100%]">
                    <div class="p-8">
                        <h1 class="text-2xl text-black font-semibold">....and it only took Sue 10mins</h1>
                        <div class="my-6 text-black">
                            The process from setup to go live was only 10mins,  now Sue has a complete storefront with custom domain and instant checkout that settles in seconds.
                        </div>
                        <div>
                            <button class="px-10 py-3 w-full bg-white rounded-lg text-sm text-brand">Open account</button>
                        </div>
                    </div>
                    <div class="flex justify-center mt-10">
                        <img :src="asset + 'asset/new_homepage/images/instant-checkout.png'" class="w-auto" alt="">
                    </div>
               </div>
                <div class="bg-[#D68F3014] relative overflow-hidden h-[560px] rounded-xl p-0 m-0 min-w-[100%]">
                    <div class="p-8">
                        <h1 class="text-2xl text-black font-semibold">Can I take payment from abroad? Sue asked</h1>
                        <div class="my-6 text-black">
                            Yes! with Tryba's multiple currency accounts and payment options, Sue can expand by taking payments globally. 
                        </div>
                        <div>
                            <button class="px-10 py-3 w-full bg-white rounded-lg text-sm text-brand">Open account</button>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <img :src="asset + 'asset/new_homepage/icons/Saly-1.png'" class="h-72 w-auto" alt="">
                    </div>
               </div>
           </div>
            <div class="text-xs text-center text-gray-400 lg:hidden">&#8810; Swipe to see how Tryba make it easy &#8811;</div>
       </div>
        <div class="flex justify-center lg:hidden w-full absolute bottom-0 left-0">
            <div class="h-[1px] bg-gray-300 w-3/5"></div>
        </div>
   </section>
</template>

<script>
export default {
    name:"Section",
    props:['asset'],
    data(){
        return{
            slides:[
                true,false,false,false
            ]
        }
    },
    methods:{
        next(){
            let index = this.slides.indexOf(true);
            let postion = index + 1             
            if(postion <= 3){
                this.slides[index] = false;   
                this.slides[postion] = true;
            } 
        },
        prev(){
            let index = this.slides.indexOf(true);
            let postion = index - 1         
            if(postion >= 0){
                this.slides[index] = false;   
                this.slides[postion] = true;
            }
        }
    }
}
</script>

<style>
/* Hide scrollbar for Chrome, Safari and Opera */
#overflow::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
#overflow{
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>