<template>
   <section class="bg-gray-100 relative pb-16 lg:pb-0">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                Who is Tryba for?
            </div>
            <div class="text-center hidden text-black lg:block text-2xl font-bold">
               Business solutions designed with much love for the gig economy.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl mt-4">
               Business solutions <br> designed with <br> much love for the <br>
               <p class="p-3 bg-[#FFCC00] inline-block mt-2">SME economy.</p>
           </div>
           <div id="overflow" class="flex space-x-4 lg:space-x-0 overflow-x-auto lg:overflow-x-visible lg:grid lg:grid-cols-3 lg:gap-8 my-8">
               <div class="bg-yellow-100 overflow-hidden relative min-w-[95%] lg:min-w-[100%] rounded-xl">
                    <div class="py-8 px-6">
                        <div class="text-center text-[#5C8993] font-semibold text-xl mb-4">Online Sellers</div>
                        <div class="text-center text-[#4F4F4F] font-semibold">
                            With our services, you can sell global without any hassle. We help online sellers take instant payment while reducing charge cost.
                        </div>
                    </div>
                    <div class="mt-20 absolute bottom-0">
                        <img :src="asset +'asset/new_homepage/images/online-selling.png'" alt="">
                    </div>
               </div>
               <div class="bg-[#3F625EA8]/60 text-gray-100 min-w-[95%] lg:min-w-[100%]  rounded-xl">
                    <div class="py-8 px-6">
                        <div class="text-center font-semibold text-xl mb-4">Freelancers</div>
                        <div class="text-center font-semibold">
                            You'll be able to take instant payments from your clients while providing them with the service they want.
                        </div>
                    </div>
                    <div class="mt-14">
                        <img :src="asset +'asset/new_homepage/images/freelancer.png'" alt="">
                    </div>
               </div>
                <div class="bg-[#5D4D43] text-gray-100 rounded-xl min-w-[90%] lg:min-w-[100%] relative">
                    <div class="py-8 px-6">
                        <div class="text-center font-semibold text-xl mb-4">Companies</div>
                        <div class="text-center font-semibold">
                            The companies we work with are able to harmonise their banking, payments and reconciliation thanks in large part due to our help.
                        </div>
                    </div>
                    <div class="mt-16 absolute bottom-0">
                        <img :src="asset +'asset/new_homepage/images/offical.png'" alt="">
                    </div>
               </div>
           </div>
           <div class="text-xs text-center text-gray-400 lg:hidden">&#8810; Swipe to see more about who can use Tryba &#8811;</div>
       </div>
       <div class="lg:hidden flex justify-center w-full absolute bottom-0 left-0">
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