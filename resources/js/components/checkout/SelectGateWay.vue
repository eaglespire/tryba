<template>
    <section class="py-8 lg:py-0 h-screen relative">
       <div class="container overflow-hidden mx-auto py-7 px-3 lg:px-24">
           <div class="bg-[#00AFEF0D] flex justify-between p-6 mb-6 rounded-xl">
               <div class="flex space-x-3">
                   <div>
                       <img src="asset/new_homepage/images/shop.svg" alt="">
                   </div>
                   <p class="font-inter text-black">You're paying a merchant</p>
               </div>
                <div>
                    <p class="font-bold">$38.00</p>
                </div>
           </div>
            <div class="bg-[#00AFEF0D] p-6 rounded-xl">
                <div class="flex justify-between mb-6">
                    <div class="flex space-x-3">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                        </div>
                        <p class="font-inter text-black">Back</p>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <div><p class="font-bold text-center mb-4">How to pay</p></div>
                <div class="flex justify-center">
                    <div class="grid grid-rows-1 gap-4 mb-16">
                        <div class="bg-white border border-brand p-4 rounded-md">
                            <p class="uppercase text-xs font-bold text-brand font-poppins ">Recommended</p>
                            <p class="font-bold text-black">Instant Bank Transfer</p>
                            <div class="text-sm font-light">
                                Connect your bank account and pay <br> instantly with Open Banking.
                            </div>
                        </div>
                        <div><p class="font-bold text-center mb-4">Or pay with</p></div>
                        <div class="bg-[#00AFEF12] flex space-x-4 rounded-md p-4">
                            <div>
                                 <img src="asset/new_homepage/images/bank.svg" alt="">
                            </div>
                            <p class="font-medium text-black">Manual Bank Transfer</p>
                        </div>
                        <div class="bg-[#00AFEF12] flex space-x-4 rounded-md p-4">
                            <div>
                                 <img src="asset/new_homepage/images/cards.svg" alt="">
                            </div>
                            <p class="font-medium text-black">Credit/debit Card</p>
                        </div>
                        <div class="bg-[#00AFEF12] flex space-x-4 rounded-md p-4">
                            <div>
                                 <img src="asset/new_homepage/images/paypal-logo.svg" alt="">
                            </div>
                            <p class="font-medium text-black">PayPal</p>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </section>
</template>

<script>
export default {

}
</script>

<style>

</style>