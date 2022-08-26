<template>
   <section class="bg-gray-100 relative py-16 lg:py-0">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                Why Tryba?
            </div>
            <div class="text-center hidden lg:block text-2xl font-semibold">
              Starting a business is quite hard, this is why we built tryba.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl mt-4">
              Starting a business <br> is quite hard,<br> this is why we built <br>
               <p class="p-3 bg-[#604135] inline-block text-gray-100 mt-2">Tryba.</p>
           </div>
           <div id="overflow" class="flex space-x-4 overflow-x-auto lg:overflow-x-visible lg:grid lg:grid-cols-2 lg:gap-8 my-8 lg:mx-28">
               <div class="bg-yellow-100 rounded-xl p-0 m-0 min-w-[85%]">
                   <div class="p-4">
                        <div class="py-4 px-6 lg:px-12">
                            <div class="font-semibold text-2xl mb-8">Without Tryba</div>
                            <ul class="grid grid-rows-1 gap-2 text-sm list-disc">
                                <li>Setting up web presence takes an 
                                     awful lot of time.</li>
                                <li>Expensive transaction charges & 
                                delayed payout settlement. </li>
                                <li>Multiple tools needed to manage a 
                                    business such as invoicing, expense & 
                                    budgeting e.t.c.
                                </li>
                            </ul>
                        </div>
                   </div>
                    <div class="mt-14 rounded flex justify-center">
                        <img :src="asset +'asset/new_homepage/images/questions.png'" class="h-44 w-auto" alt="">
                    </div>
               </div>
                <div class="bg-brand relative text-gray-100 rounded-xl p-0 m-0 min-w-[85%]">
                    <div class="flex flex-col flex-grow space-y-16 py-8 px-12">
                        <div class="font-semibold text-2xl text-center mb-8">With Tryba</div>
                        <div>
                            <div class="flex justify-center">
                                    <img :src="asset +'asset/new_homepage/images/check-mark.png'" class="h-28 w-28" alt="">
                            </div>
                            <div class="font-semibold text-center mt-6">
                                One-App for Businesses to Get Started and Scale
                            </div>
                        </div>
                        <div class="rounded flex justify-center">
                            <button class="text-sm border border-gray-100 py-3 px-6 rounded-md">
                                Learn More
                            </button>
                        </div>
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