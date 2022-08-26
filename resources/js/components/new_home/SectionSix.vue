<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
               Borderless Checkout
            </div>
            <div class="text-center hidden lg:block text-2xl font-semibold">
              Lightweight hosted checkout with multiple payment options in 30secs.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl my-4">
               Lightweight hosted <br> checkout with <br> multiple payment <br> options<br>
               <p class="p-3 bg-[#FFB8B8] text-gray-100 inline-block mt-2">in 30secs.</p>
            </div>
           <div class="relative mt-32 lg:mt-0">
                <div class="lg:mt-44 mb-8 bg-[#FFCC00] rounded-2xl p-8 lg:p-14">
                    <div class="flex flex-col lg:grid lg:grid-cols-2 place-items-center">
                        <div>
                            <div class="flex lg:justify-start justify-center -mt-32 lg:mt-0 lg:absolute lg:w-2/4 lg:left-8 lg:bottom-8 ">
                                <img :src="asset + 'asset/new_homepage/images/checkout.png'" class="lg:h-[350px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="mt-8 lg:mt-0">
                            <h1 class="text-xl lg:text-4xl text-black font-bold">Experience Speed</h1>
                            <div class="my-4 text-black text-sm">
                                How do you get paid so quickly? Ask others. We have the solution for businesses. Tryba’s borderless checkout help you accept payments in 30 secs!
                            </div>
                            <div>
                               <a href="#" class="text-white font-semibold text-sm">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div> 
           </div>
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
}
</script>

<style>

</style>