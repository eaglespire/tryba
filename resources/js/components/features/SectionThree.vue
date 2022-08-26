<template>
     <section class="container overflow-hidden mx-auto py-8 px-6 lg:px-14" >
        <div class="lg:grid lg:grid-cols-7">
             <div class="flex justify-center lg:justify-start lg:col-span-3" >
                <div>
                    <img :src="asset + 'asset/new_homepage/icons/image478.png'" class="h-[233px] lg:h-[363px] w-auto" alt="invoicing">
                </div>
            </div>
            <div class="flex item-center py-3 lg:py-24 col-span-4" >
                <div>
                    <p class="font-bold text-center lg:text-left text-2xl lg:text-5xl">
                       Invoicing and payment Links
                    </p>
                    <p class="font-inter text-center lg:text-left font-medium lg:my-4 my-2">
                        Create and manage invoice sent to your cutomers saved 
                        email addresses which is one of the most reliable way to get 
                        paid quickly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-100" >
        <div class="container overflow-hidden mx-auto py-8 px-6 lg:px-14">
            <div class="flex flex-col-reverse lg:grid gap-14 lg:grid-cols-7">
                <div class="flex justify-center item-center py-2 lg:py-24 col-span-4" >
                    <div>
                        <p class="font-bold text-center lg:text-left text-2xl lg:text-5xl">
                            Business bank accounts and cards
                        </p>
                        <p class="font-inter hidden font-medium lg:block lg:my-4 my-2">
                            Download the Tryba app to apply for your business account creation, most 
                            commonly within 3-4 minutes, then receive your contactless Visacard. 
                            All you'll need is proof of ID and a selfie. 
                        </p>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end col-span-3" >
                    <div>
                        <img :src="asset + 'asset/new_homepage/icons/card-iphone.png'" class="h[336px] w-auto" alt="bank accounts">
                    </div>
                </div>
            </div>
            <p class="font-inter text-center lg:text-left text-sm lg:hidden block">
                Download the Tryba app to apply for your business account creation, most 
                commonly within 3-4 minutes, then receive your contactless Visacard. 
                All you'll need is proof of ID and a selfie. 
            </p>
        </div>
    </section>

     <section class="container overflow-hidden mx-auto py-14 px-6 lg:px-14" >
        <div class="lg:grid lg:grid-cols-2">
             <div class="flex justify-center lg:justify-start items-center" >
                <div>
                    <img :src="asset + 'asset/new_homepage/icons/undraw_developer_activity_re_39tg 1.svg'" class="h-[269px] w-auto" alt="invoicing">
                </div>
            </div>
            <div class="flex item-center py-3 lg:py-24" >
                <div>
                    <p class="font-bold text-center lg:text-left text-2xl lg:text-5xl">
                       Developers
                    </p>
                    <p class="font-inter text-center lg:text-left font-medium lg:my-4 my-2">
                        Create and manage invoice sent to your cutomers saved 
                        email addresseswhich is one of the most reliable way to get 
                        paid quickly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="container overflow-hidden mx-auto mb-14 py-8 px-6 lg:px-14" >
        <h1 class="lg:text-5xl text-2xl font-semibold text-center mb-6" >Why Tryba? (in 1:34 mins)</h1>
        <div class="flex justify-center">
            <div v-show="showVideo" >   
                <YouTube 
                    src="https://www.youtube.com/watch?v=KPF8wiAW8Q4" 
                    @ready="onReady"
                    width="640"
                    height="360"
                    ref="youtube" 
                />
            </div>
            <div v-show="showVideo == false">
                <button @click="toogleVideo"><img :src="asset + 'asset/new_homepage/icons/TV.svg'" class=" w-auto" alt="youtube"></button> 
            </div>
        </div>
    </section>


</template>

<script>
import YouTube from 'vue3-youtube'
export default {
    name:"Section",
    props:['asset'],
    components: { YouTube },
    data(){
        return{
            showVideo: false,
        }
    },
    methods:{
        onReady() {
            // this.$refs.youtube.playVideo()
        },
        toogleVideo(){
            this.showVideo = !this.showVideo
            if(this.showVideo){
                this.$refs.youtube.playVideo();
            }
        }
    },
    mounted(){

    }
}
</script>

<style>
@media (max-width: 789px) {
    iframe{
        width:340px !important;
        height: 350px  !important;
        margin:auto;
    }
}
</style>