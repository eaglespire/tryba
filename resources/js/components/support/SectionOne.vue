<template>
    <section class="container overflow-hidden mx-auto py-8 px-8 lg:px-14" >
        <div class="grid grid-rows-1 lg:grid-cols-2">
            <div class="flex item-center py-3 lg:py-24 " >
                <div>
                    <p class="font-semibold text-center lg:text-left text-4xl lg:text-5xl">
                        We are always here to support you 
                        <span class="text-brand" >Ask Us Anything</span>  
                    </p>
                    <p class="font-inter hidden lg:block lg:my-4 my-2">Contact us on any challenge you are facing as touching our product and services, we will always provide support</p>
                </div>
            </div>
            <div class="flex justify-end" >
                <img :src="asset + 'asset/new_homepage/icons/undraw_active_support_re_b7sj 1.svg'" class="h-[500] w-auto" alt="subscription">
            </div>
        </div>
        <p class="font-inter text-sm lg:hidden block my-6">Contact us on any challenge you are facing as touching our product and services, we will always provide support</p>
    </section>

    <section class="container overflow-hidden mx-auto py-8 px-8 lg:px-14">
        <div class="grid lg:grid-cols-2 gap-3 mb-4" >
            <div>
                <input type="text" placeholder="Enter your email address" class="p-4 font-inter text-sm w-full bg-gray-200 rounded">
            </div>
        </div>
        <div class="mb-4">
            <textarea name="" class="p-4 font-inter text-sm w-full bg-gray-200 rounded" placeholder="Enter your query here" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="text-right">
            <button type="submit" class="px-8 text-sm font-inter py-3 bg-brand rounded-md text-white" >Submit</button>
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