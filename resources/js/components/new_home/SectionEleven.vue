<template>
   <section class="bg-gray-100 pt-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="flex justify-center  lg:hidden">
                <p class="p-3 bg-black my-2 text-gray-100 font-bold inline-block text-center text-3xl lg:hidden">FAQS</p>
            </div>
            <div class="lg:my-8 mt-4 mb-8 bg-white rounded-2xl lg:py-28 p-10 lg:px-14 relative">
                <div class="grid grid-rows-1 gap-8 lg:grid-cols-2 lg:gap-14">
                    <div>
                        <h1 class="text-2xl hidden lg:block p lg:text-4xl text-black font-semibold">Frequently asked Questions</h1>
                        <div class="my-6 text-black">
                          We understand you may have additional question about tryba, we have you covered!
                        </div>
                        <div>
                            <a href="" class="text-brand hover:underline transition delay-150">Learn more</a>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-3 w-full text-black">
                        <div v-if="ShowFaq1" @click="toogleShowFaq1" :class="{'animate__fadeOut': !ShowFaq1,'animate__fadeIn': ShowFaq1 }" class="border-black cursor-pointer border p-3 flex-grow flex items-center justify-between rounded-lg w-full animate__animated">
                            <div class="font-semibold text-sm ">What is Tryba?</div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div v-else :class="{'animate__fadeOut': ShowFaq1,'animate__fadeIn': !ShowFaq1 }" class="bg-brand/10 p-3 cursor-pointer flex-grow rounded-lg w-full animate__animated">
                            <div @click="toogleShowFaq1" class="flex items-center cursor-pointer justify-between text-brand">   
                                <div class="font-semibold text-sm ">What is Tryba?</div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="h-0.5 w-full my-4 bg-gray-200"></div>
                            <div class="text-sm">
                                <div class="mb-2">
                                    Tryba is a business banking and management platform built for self employed and companies.
                                </div>
                                <div>
                                    Tryba.io is equipped with modern multi currency business accounts and Visa cards, website and storefront builders, invoicing, payment links, expense and budgeting etc, that enable businesses start and grow effortlessly while maintaining speed and affordability.
                                </div>                                
                            </div>
                        </div>
                        <div v-if="ShowFaq2" @click="toogleShowFaq2" :class="{'animate__fadeOut': !ShowFaq2,'animate__fadeIn': ShowFaq2 }" class="border-black cursor-pointer animate__animated border p-3 flex-grow flex items-center justify-between rounded-lg w-full">
                            <div class="font-semibold text-sm ">Who can open an account?</div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div v-else :class="{'animate__fadeOut': ShowFaq2,'animate__fadeIn': !ShowFaq2 }" class="bg-brand/10 p-3 cursor-pointer flex-grow rounded-lg w-full animate__animated">
                            <div  @click="toogleShowFaq2" class="flex items-center cursor-pointer justify-between text-brand">   
                                <div class="font-semibold text-sm ">Who can open an account?</div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="h-0.5 w-full my-4 bg-gray-200"></div>
                            <div class="text-sm">
                                All U.K. based business owners are eligible to open an account on Tryba and discover the wonders of our service.
                            </div>
                        </div>
                        <div v-if="ShowFaq3" @click="toogleShowFaq3" :class="{'animate__fadeOut': !ShowFaq3,'animate__fadeIn': ShowFaq3 }" class="border-black cursor-pointer animate__animated border p-3 flex-grow flex items-center justify-between rounded-lg w-full">
                            <div class="font-semibold text-sm ">Is Tryba a bank?</div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div v-else  :class="{'animate__fadeOut': ShowFaq3,'animate__fadeIn': !ShowFaq3 }" class="bg-brand/10 p-3 flex-grow rounded-lg w-full animate__animated">
                            <div @click="toogleShowFaq3" class="flex items-center cursor-pointer justify-between text-brand">   
                                <div class="font-semibold text-sm ">Is Tryba a Bank?</div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="h-0.5 w-full my-4 bg-gray-200"></div>
                            <div class="text-sm">
                               No Tryba is not a bank but an e-money distributor of Modulr FS. Tryba offer GBP business account number and Sortcode, EUR IBAN and Visa cards similar to the traditional banks.
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="pt-16">
                <div class="flex justify-center lg:hidden w-full">
                    <div class="h-[1px] bg-gray-300 w-3/5"></div>
                </div>
            </div>
            <div class="my-8 bg-[#FFCC00] rounded-2xl lg:p-16 p-8 mt-24 relative">
                <div class="grid grid-rows-1 gap-8 lg:grid-cols-2 lg:place-items-center">
                    <div>
                        <h1 class="text-2xl lg:text-4xl text-black font-bold">Say goodbye to messy business setup. </h1>
                        <div class="my-6 text-black font-semibold">
                          Tryba's features are built to assist you in starting and managing your business efficiently.
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
                            <img :src="asset + 'asset/new_homepage/images/messy_payments.png'" class="lg:h-96 h-48 w-auto" alt="">
                        </div>
                    </div>
                </div>
           </div> 
       </div>
   </section>
</template>

<script>
import 'animate.css';
export default {
    name:"Section",
    props:['asset'],
    emits:['openLoginModal','openRegisterModal'],
    data(){
        return{
            ShowFaq1:true,
            ShowFaq2:true,
            ShowFaq3:true
        }
    },
    methods: {
        toogleShowFaq1(){
            this.ShowFaq1 =  !this.ShowFaq1
        },
        toogleShowFaq2(){
            this.ShowFaq2 =  !this.ShowFaq2
        },
        toogleShowFaq3(){
            this.ShowFaq3 =  !this.ShowFaq3
        },
        showPopup(){
            this.$emit('openRegisterModal')
        }
    },
}
</script>

<style>

</style>