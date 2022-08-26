<template>
    <section class="py-8 lg:py-0 h-screen relative">
       <div class="container overflow-hidden mx-auto lg:py-16 px-3 lg:px-24">
           <div class="bg-[#00AFEF0D] flex justify-between items-center p-4 mb-6 rounded-xl">
               <div class="flex space-x-3 items-center">
                   <div class="bg-[#00AFEF1F] flex items-center justify-center p-2 rounded-full">
                       <img src="asset/new_homepage/images/shop.svg" alt="">
                   </div>
                   <p class="font-inter text-black">You're paying a merchant</p>
               </div>
                <div>
                    <p class="font-bold">{{ getTransaction.rex.symbol }}{{ this.formatNumber.formatNumber(getTransaction.amount) }}</p>
                </div>
           </div>
            <div class="bg-[#00AFEF0D] p-6 rounded-xl">
                <div class="flex justify-center text-sm">
                    <div class="flex items-center space-x-3">
                        <p :class="{'opacity-40': selectedBank}" class="font-inter text-black">1. Bank</p>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </div>
                        <p :class="{'opacity-40': !selectedBank}" class="font-inter text-black">2. Reviews</p>
                    </div>
                </div>
                <div v-if="!selectedBank">
                    <div><p class="font-semibold text-center my-8">Choose your Bank</p></div>
                    <div class="flex justify-center items-center mb-6">
                        <div class="lg:w-2/4 w-[90%] bg-[#00AFEF12] rounded-full flex space-x-3 py-2 px-4">
                            <div class="flex justify-center items-center">
                                <img src="asset/new_homepage/images/search.svg" alt="">
                            </div>
                            <input type="text" v-model="search" class="bg-transparent text-sm flex-grow p-2 focus:outline-none" placeholder="Search">
                        </div>
                    </div>
                    <div  class="flex justify-center">
                        <div class="3/5">
                            <div><p class="font-semibold text-center my-4">Most Popular Banks</p></div>
                            <div v-if="getInstution.length">
                                <div class="grid lg:grid-cols-5 grid-cols-3 gap-6 mb-8">
                                    <div v-for="bank in getInstution" :key="bank" @click="selectBank(bank.id)">
                                        <div class="flex justify-center mb-4">
                                            <div class="rounded-full h-[50px] w-[50px] border-2 bg-white border-brand overflow-hidden flex items-center justify-center p-1">
                                                <img :src="bank.media[0].source" class="w-full h-auto" alt="">
                                            </div>
                                        </div>
                                        <p class="font-normal text-xs text-center">{{ bank.name }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-center my-8">
                                    <button type="button" @click="showAllInstution" class="flex space-x-3 text-sm text-gray-500">
                                        <div>
                                            <span v-if="this.slice == this.institution.length">Scroll Up</span>
                                            <span v-else>Scroll Down</span>  
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180' : this.slice == this.institution.length}" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div v-else class="flex justify-center">
                                <p class="text-sm text-center">Institution not found</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div><p class="font-semibold text-center my-8">Confirm Payment</p></div>
                    <div class="flex justify-center">
                        <div class="flex justify-center w-[70%] lg:w-[10%] my-6">
                            <div class="relative">
                                <div class="z-10 flex justify-center items-center space-x-16">
                                    <div class="bg-[white] border-white border-2 flex items-center justify-center h-[60px] w-[60px] rounded-full">
                                        <img src="asset/new_homepage/images/shop.svg" alt="">
                                    </div>
                                    <div class="flex items-center justify-center h-[60px] w-[60px] border-2 bg-white border-brand rounded-full">
                                        <img src="asset/new_homepage/logo.svg" class="h-[10px]" alt="">
                                    </div>
                                    <div class="flex items-center justify-center h-[60px] w-[60px] overflow-hidden border-2 bg-white border-brand rounded-full">
                                        <img :src="selectedBank.media[0].source" class="w-full h-auto" alt="">
                                    </div>
                                </div>
                                <div class="border-dashed border-brand border-2 absolute top-[50%] -z-10 w-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center my-6 text-xl">
                        <div class="font-semibold">
                            <p class="text-center">You're paying Merchant</p>
                            <p class="text-center">{{ getTransaction.rex.symbol }}{{ this.formatNumber.formatNumber(getTransaction.amount) }}</p>
                        </div>
                    </div>
                    <div class="flex justify-center mb-6">
                        <form target="_blank" :action="url + '/authorize-payment/' + $route.params.id" method="post">
                            <input type="hidden" name="_token" :value="token">
                            <input type="hidden" name="bank_id" :value="selectedBank.id">
                            <button type="submit" class="bg-brand text-gray-100 py-3 px-8 lg:px-16 rounded-lg text-sm font-inter">
                                Continue to pay
                            </button>
                        </form>
                    </div>
                </div>
           </div>
       </div>
    </section>
</template>

<script>
export default {
    name:"Banks",
    props:['institution','transaction'],
    data(){
        return {
            slice:10,
            search:"",
            selectedBank:null,
            url:window.location.origin,
            token: window.token.token
        }
    },
    computed:{
        getInstution(){
           let sortedBanks = (this.search) ? this.institution.filter((item) => item.name.toLowerCase().includes(this.search.toLowerCase())  && item.features.includes("CREATE_DOMESTIC_SINGLE_PAYMENT")) : this.institution.filter((item) => item.features.includes("CREATE_DOMESTIC_SINGLE_PAYMENT"));
           return sortedBanks.slice(0,this.slice)
        },
        getTransaction(){
            return (this.transaction) ? this.transaction : {}
        }
    },
    methods:{
        showAllInstution(){
            this.slice = (this.slice == this.institution.length) ? 10 : this.institution.length
        },
        selectBank(id){
            this.selectedBank = this.institution.find((item) => item.id == id);
        }
    }
}
</script>

<style>

</style>