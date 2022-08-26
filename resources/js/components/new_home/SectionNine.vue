<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                Press room
            </div>
            <div class="text-center text-2xl hidden lg:block font-semibold">
              Happenings from our press room
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl my-4">
               Happenings from our<br>
               <p class="p-3 bg-[#192A52] text-gray-100 inline-block mt-2">press room</p>
            </div>
           <div id="overflow" class="flex space-x-4 overflow-x-auto lg:overflow-x-visible lg:grid lg:grid-cols-2 lg:gap-8 my-8 lg:mx-28">
                <div class="bg-black h-[533px] relative overflow-hidden text-gray-100 rounded-xl p-0 m-0 min-w-full">
                   <div class="p-4">
                        <div class="py-4 px-8">
                            <div class="font-semibold text-2xl mb-8">Tryba Partners with Modulr Finance</div>
                            <div class="text-sm my-6">
                                For the provision of Tryba’s business accounts and Visa cards. Modulr is authorised and regulated by FCA (FRN 900573) 
                            </div>
                                <a href="blog" class="text-sm border border-gray-100 py-3 px-6 rounded-md">
                                    Read this article
                                </a>
                        </div>
                   </div>
                    <div class="absolute -bottom-4 left-0 w-full rounded flex justify-center">
                        <img :src="asset +'asset/new_homepage/images/bot.png'" class="h-44 w-auto" alt="">
                    </div>
                </div>
                <div class="bg-[#192A52] h-[533px] relative overflow-hidden text-gray-100 rounded-xl p-0 m-0 min-w-full">
                   <div class="p-4">
                        <div class="py-4 px-8">
                            <div class="font-semibold text-2xl mb-8">Tryba Partners with Yapily Limited</div>
                            <div class="text-sm my-6">
                                To provide open banking within tryba’s payment framework. Yapily is authorised and regulated by FCA (FRN 900573) 
                            </div>
                            <a href="blog" class="text-sm border border-gray-100 py-3 px-6 rounded-md">
                                Read this article
                            </a>
                        </div>
                   </div>
                    <div class="mt-8 border-red-100 absolute -bottom-4 left-0 w-full rounded flex justify-center">
                        <img :src="asset +'asset/new_homepage/images/yapily.png'" class="h-48 w-auto" alt="">
                    </div>
               </div>
           </div>
           <div class="text-xs text-center text-gray-400 mt-4 lg:hidden">&#8810; Swipe to read all of our press &#8811;</div>
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