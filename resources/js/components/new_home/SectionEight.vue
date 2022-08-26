<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                Time saving feature
            </div>
            <div class="text-center hidden lg:block text-2xl font-semibold">
              Tryba features are beautifully integrated into your business.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl my-4">
               Tryba features are <br> beautifully integrated <br> into your<br>
               <p class="p-3 bg-[#CE6666] text-gray-100 inline-block mt-2">business.</p>
            </div>
            <div class="relative">
                <div id="overflow" ref="feature" class="flex lg:flex-row space-x-4 overflow-x-auto lg:overflow-hidden relative my-8">
                    <div class="relative min-w-full lg:min-w-[32.4%]">
                        <div class="z-10 bg-brand h-[490px] lg:h-[398.7px] relative text-gray-100 rounded-xl p-8 lg:p-6 lg:m-6">
                            <div class="text-xl font-semibold mt-4">
                                Hosted payment links
                            </div>
                            <div class="my-4 text-xs">
                                Request payment from your customers with Tryba's seamless and easy-to use Pay by link services. 
                            </div>
                            <div class="my-4">
                                <button class="bg-white rounded text-brand flex space-x-3 px-4 py-3 text-xs">
                                    <p>Learn more</p>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="absolute left-0 w-full bottom-0 flex justify-center">
                                <img :src="asset + 'asset/new_homepage/images/payment_links.png'" class="h-[150px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="h-44 w-full bg-white hidden lg:block absolute bottom-0 rounded-lg"></div>
                    </div>
                    <div class="relative min-w-full lg:min-w-[32.4%]">
                        <div class="z-10 bg-[#80B9C7] h-[490px] lg:h-[398.7px] relative text-gray-100 rounded-xl p-8 lg:p-6 lg:m-6">
                            <div class="text-xl font-semibold mt-4">
                                Invoicing
                            </div>
                            <div class="my-4 text-xs">
                                Send invoices to customers and collect payment in seconds Mingle with your clients on a whole new level by using our app!
                            </div>
                            <div class="my-4">
                                <button class="bg-white rounded text-brand flex space-x-3 px-4 py-3 text-xs">
                                    <p>Learn more</p>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="absolute left-0 w-full bottom-0 flex justify-center">
                                <img :src="asset + 'asset/new_homepage/images/invoicing.png'" class="h-[260px] lg:h-[180px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="h-44 w-full hidden lg:block bg-white absolute bottom-0 rounded-lg"></div>
                    </div>
                    <div class="relative min-w-full lg:min-w-[32.4%]">
                        <div class="z-10 bg-[#DEA766] h-[490px] lg:h-[398.7px] relative text-gray-100 rounded-lg p-8 lg:p-6 lg:m-6">
                            <div class="text-xl font-semibold mt-4">
                            Bookings & Appointments
                            </div>
                            <div class="my-4 text-xs">
                            Send hosted booking and appointment links to your customers so they can easily book their next event with you.
                            </div>
                            <div class="my-4">
                                <button class="bg-white rounded text-brand flex space-x-3 px-4 py-3 text-xs">
                                    <p>Learn more</p>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="absolute left-0 w-full bottom-0 flex justify-center">
                                <img :src="asset + 'asset/new_homepage/images/booking-calendar.png'" class="h-[260px] lg:h-[160px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="h-44 w-full bg-white  hidden lg:block absolute bottom-0 rounded-lg"></div>
                    </div>
                    <div class="relative min-w-full lg:min-w-[32.4%]">
                        <div class="z-10 bg-[#979AA5] h-[490px] lg:h-[398.7px] relative text-gray-100 rounded-lg p-8 lg:6 lg:m-6">
                            <div class="text-xl font-semibold mt-4">
                            Expense and budgeting
                            </div>
                            <div class="my-4 text-xs">
                            Develop budgets and track expenses seamlessly on the Tryba app.
                            </div>
                            <div class="my-4">
                                <button class="bg-white rounded text-brand flex space-x-3 px-4 py-3 text-xs">
                                    <p>Learn more</p>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="absolute left-0 w-full bottom-0 flex justify-center">
                                <img :src="asset + 'asset/new_homepage/images/expenses.png'" class="h-[260px] lg:h-[160px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="h-44 w-full bg-white  hidden lg:block absolute bottom-0 rounded-lg"></div>
                    </div>
                    <div class="relative min-w-full lg:min-w-[32.4%]">
                        <div class="z-10 bg-[#bc7171f7] h-[490px] lg:h-[398.7px] relative text-gray-100 rounded-lg p-8 lg:p-6 lg:m-6">
                            <div class="text-xl font-semibold mt-4">
                            Connect marketplaces
                            </div>
                            <div class="my-4 text-xs">
                            In few clicks, connect to third party apps within the Tryba marketplace. 
                            </div>
                            <div class="my-4">
                                <button class="bg-white rounded text-brand flex space-x-3 px-4 py-3 text-xs">
                                    <p>Learn more</p>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="absolute left-0 w-full bottom-0 flex justify-center">
                                <img :src="asset + 'asset/new_homepage/images/marketplaces.png'" class="h-[260px] lg:h-[160px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="h-44 w-full bg-white  hidden lg:block absolute bottom-0 rounded-lg"></div>
                    </div>
                    <div class="relative min-w-full lg:min-w-[32.4%]">
                        <div class="z-10 bg-[#2D2D2D] h-[490px] lg:h-[398.7px] relative text-gray-100 rounded-lg p-8 lg:p-6 lg:m-6">
                            <div class="text-xl font-semibold mt-4">
                            Developers
                            </div>
                            <div class="my-4 text-xs">
                            Tryba's APIs are designed so that no matter your development size or team, there'll be something for everyone. 
                            </div>
                            <div class="my-4">
                                <button class="bg-white rounded text-brand flex space-x-3 px-4 py-3 text-xs">
                                    <p>Learn more</p>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="absolute left-0 w-full bottom-0 flex justify-center">
                                <img :src="asset + 'asset/new_homepage/images/developers.png'" class="lg:h-[160px] w-auto" alt="">
                            </div>
                        </div>
                        <div class="h-44 w-full bg-white  hidden lg:block absolute bottom-0 rounded-lg"></div>
                    </div>
                </div>
                <div class="absolute hidden lg:block -left-4 top-[70%]" >
                    <button @click="prev" class="bg-brand flex justify-center items-center rounded-full h-8 w-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
                <div class="absolute hidden lg:block -right-4 top-[70%]" >
                    <button @click="next" class="bg-brand flex justify-center items-center rounded-full h-8 w-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="text-xs text-center text-gray-400 lg:hidden">&#8810; Swipe to see Tryba’s intelligent features &#8811;</div>  
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
    data(){
        return{
            
        }
    },
    methods:{
        prev(){
            console.log(this.$refs.feature.offsetWidth)
            this.$refs.feature.scrollLeft -= this.$refs.feature.offsetWidth + 50; 
        },
        next(){
            console.log(this.$refs.feature.offsetWidth)
            this.$refs.feature.scrollLeft += this.$refs.feature.clientWidth + 50; 
        }
    }
}
</script>

<style>

</style>