<template>
    <section class="container overflow-hidden mx-auto py-8 px-3 lg:px-14" >
        <div class="lg:grid lg:grid-cols-3">
            <div class="flex item-center py-3 lg:py-24 lg:col-span-2" >
                <div>
                    <p class="font-bold text-center lg:text-left lg:leading-[70px] text-3xl lg:text-6xl">
                        <span class="text-brand">Amazing features </span>  
                        that makes banking and Business easy for You 
                    </p>
                    <p class="font-inter hidden font-semibold text-xl lg:block lg:my-4 my-2">Built for freelancers, contractors and limited companies </p>
                </div>
            </div>
            <div class="flex justify-center lg:justify-end" >
                <div>
                    <img :src="asset + 'asset/new_homepage/icons/undraw_features_overview_re_2w78 1.svg'" class="lg:h-[500] w-auto" alt="subscription">
                </div>
            </div>
        </div>
        <p class="font-inter text-base text-center font-medium lg:hidden block my-6">Built for freelancers, contractors and limited companies</p>
    </section>
    <h1 class="text-3xl font-semibold text-center mb-6">Features</h1>
    <section class="bg-gray-100" >
        <div class="container overflow-hidden mx-auto py-8 px-6 lg:px-14">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-2">
                <div class="flex item-center py-3 lg:py-24" >
                    <div>
                        <p class="font-bold text-center lg:text-left text-2xl lg:text-5xl">
                            Web and Store builder with Custom domain
                        </p>
                        <p class="font-inter text-center lg:text-left font-medium lg:block lg:my-4 my-2">
                            Create a business website that allows your customers to
                            know more about your product and services 
                        </p>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end" >
                    <div class="p-4">
                        <img :src="asset + 'asset/new_homepage/icons/image480.png'" class="h-[229px] lg:h-[360px]" alt="subscription">
                    </div>
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
        }
    },
    methods:{
        
    },
    mounted(){

    }
}
</script>

<style>

</style>