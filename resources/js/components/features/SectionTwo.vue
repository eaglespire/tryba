<template>
     <section class="container overflow-hidden mx-auto py-8 px-6 lg:px-14" >
        <div class="lg:grid lg:grid-cols-7">
            <div class="flex justify-center lg:justify-start lg:col-span-3">
                <div>
                    <img :src="asset + 'asset/new_homepage/icons/image482.png'" class="h-[232px] lg:h-[360px] w-auto" alt="booking">
                </div>
            </div>
            <div class="flex item-center pt-3 lg:py-24 lg:col-span-4" >
                <div>
                    <p class="font-bold text-center lg:text-left text-2xl lg:text-5xl ">
                        Booking and appointment
                    </p>
                    <p class="font-inter text-center lg:text-left font-medium lg:block lg:my-4 my-2">
                        Download the Tryba app to create custom made booking and appointment
                        tailored to your style of business
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-100" >
        <div class="container overflow-hidden mx-auto py-8 px-6 lg:px-14">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-2">
                <div class="flex justify-center lg:justify-start item-center py-2 lg:py-24" >
                    <div>
                        <p class="font-bold text-center lg:text-left text-2xl lg:text-5xl">
                            Expense and Budgeting
                        </p>
                        <p class="font-inter hidden font-medium lg:block lg:my-4 my-2">
                            Download the Tryba app to be in charge on how ans where you
                            money goes but creating your personal expense and budgeting scheduls 
                            all by yourself
                        </p>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end" >
                    <div>
                        <img :src="asset + 'asset/new_homepage/icons/image482.png'" class="h-[232px] lg:h-[360px] w-auto" alt="subscription">
                    </div>
                </div>
            </div>
            <p class="font-inter text-center lg:text-lefta text-sm lg:hidden block">
                Download the Tryba app to be in charge on how ans where you
                money goes but creating your personal expense and budgeting scheduls 
                all by yourself
            </p>
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