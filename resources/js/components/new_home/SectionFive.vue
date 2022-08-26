<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
               Smart Business Accounts & Cards
            </div>
            <div class="text-center text-2xl hidden lg:block font-semibold">
              Powered by innovative banking technology, backed by humans.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl mt-4">
               Powered by <br> innovative banking <br> technology, backed <br>
               <p class="p-3 mt-2 bg-[#252525] text-gray-100 inline-block">by humans</p>
            </div>
            <div class="my-8 bg-white rounded-2xl p-8 lg:p-12 relative">
                <div class="flex flex-col-reverse gap-16 lg:grid lg:grid-cols-2 place-items-center">
                    <div>
                        <div class="flex justify-center">
                            <img :src="asset + 'asset/new_homepage/images/cards.png'" class="h-[399px] w-auto" alt="">
                        </div>
                    </div>
                    <div>
                        <h1 class="lg:text-4xl text-xl text-black font-bold">Smart Business Account</h1>
                        <div class="my-6 text-black">
                           Tryba provides you with U.K and Euro account number, sort code, Iban and Visa cards for all your business transactions.
                        </div>
                        <div class="flex space-x-3 justify-center lg:justify-start">
                            <div>
                                <img :src="asset + 'asset/new_homepage/images/google-play.png'" class="lg:h-12 h-12 w-auto" alt="">
                            </div>
                            <div>
                                <img :src="asset + 'asset/new_homepage/images/apple-store.png'" class="lg:h-12 h-12 w-auto" alt="">
                            </div>
                        </div>
                    </div>
                </div>
           </div> 
            <div class="my-8 bg-[#CE905236] rounded-2xl p-8 lg:p-16 relative">
                <div class="flex flex-col gap-16 lg:gap-0 lg:grid lg:grid-cols-2 lg:place-items-center">
                    <div>
                        <h1 class="lg:text-4xl text-xl text-black font-bold">Payment in seconds</h1>
                        <div class="my-6 text-black">
                           Request payment from individuals and businesses with Tryba's Pay by link services in record time settlement
                        </div>
                        <div class="flex space-x-3 justify-center lg:justify-start">
                            <div>
                                <img :src="asset + 'asset/new_homepage/images/google-play.png'" class="lg:h-12 h-12 w-auto" alt="">
                            </div>
                            <div>
                                <img :src="asset + 'asset/new_homepage/images/apple-store.png'" class="lg:h-12 h-12 w-auto" alt="">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-center">
                            <img :src="asset + 'asset/new_homepage/images/payment.png'" class=" w-auto" alt="">
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