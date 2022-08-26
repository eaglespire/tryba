<template>
    <section class="container overflow-hidden mx-auto py-8 px-8 lg:px-14" >
        <div class="grid grid-rows-1 lg:grid-cols-2">
            <div class="flex item-center py-3 lg:py-24 " >
                <div>
                    <p class="font-semibold text-center lg:text-left text-4xl lg:text-5xl">
                       Get started with <span class="text-brand">intelligent pricing</span>
                    </p>
                    <p class="font-inter hidden lg:block lg:my-4 my-2">No matter your business, our subscription model is designed with you in mind and intelligently too.</p>
                </div>
            </div>
            <div class="flex justify-end" >
                <img :src="asset + 'asset/new_homepage/icons/undraw_online_calendar_re_wk3t 1.svg'" alt="subscription">
            </div>
        </div>
        <p class="font-inter text-sm lg:hidden block my-6">No matter your business, our subscription model is designed with you in mind and intelligently too.</p>
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