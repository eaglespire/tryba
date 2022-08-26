<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                Everyday Business
            </div>
            <div class="text-center text-2xl hidden lg:block font-semibold">
              Kickstart and scale entirely on the tryba ecosystem. We built it so you don’t have to.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl my-4">
               Kickstart and <br> scale entirely on <br> the tryba ecosystem. <br> We built it so you<br>
               <p class="p-3 bg-[#CA9552] mt-2 text-gray-100 inline-block">don’t have to.</p>
            </div>
            <div id="overflow" class="flex space-x-4 overflow-x-auto lg:overflow-x-visible lg:grid lg:grid-cols-2 lg:gap-14 my-8 place-items-center text-gray-100">                  
                <div class="relative min-w-[100%]">
                    <div class="lg:mx-20 mx-11 bg-[#3F625EA8] rounded-lg pt-96 px-4 pb-16">
                        <div class="absolute flex justify-center top-8 left-0 lg:left-[2px] w-full">
                            <div>
                                 <img :src="asset + 'asset/new_homepage/images/website.png'" class="" alt="">
                            </div>
                        </div>
                        <div class="lg:text-base text-sm text-center">
                            Build your next multipurpose website in 10mins, go live instantly. 
                        </div>
                        <div class="flex justify-center mt-8">
                            <button class="text-sm border border-gray-100 py-3 px-6 rounded-md">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative min-w-[100%]" >
                    <div class="lg:mx-20 mx-11 bg-[#C690A1] rounded-lg pt-96 px-4 pb-16">
                        <div class="absolute flex justify-center top-8 left-0 lg:left-2 w-full">
                            <div>
                                 <img :src="asset + 'asset/new_homepage/images/storefront.png'" class="" alt="">
                            </div>
                        </div>
                        <div class="lg:text-base text-sm text-center">
                            Create your instant storefront that convert sales, go live in 10mins
                        </div>
                        <div class="flex justify-center mt-8">
                            <button class="text-sm border border-gray-100 py-3 px-6 rounded-md">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="text-xs text-center text-gray-400 lg:hidden">&#8810; Swipe to see your beautiful web app &#8811;</div>
            <div class="flex justify-center lg:hidden w-full absolute bottom-0 left-0">
                <div class="h-[1px] bg-gray-300 w-3/5"></div>
            </div>
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