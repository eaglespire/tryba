<template>
   <section class="bg-black/90 overflow-hidden" >
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:p-24" >
           <div class="lg:grid px-4 lg:grid-cols-12 lg:gap-6" >
               <div class="lg:col-span-2">
                   <div class="flex justify-start -ml-4 lg:justify-start">
                       <img :src="asset + 'asset/new_homepage/logo-white.svg'" class="h-10 w-auto" alt="">     
                   </div>
                   <div class="flex justify-start space-x-4 lg:space-x-0 lg:justify-between my-6  lg:mr-4">
                       <div>
                           <a href="https://facebook.com/tryba.io">
                                <img :src="asset + 'asset/new_homepage/icons/facebook.svg'" class="h-4 w-auto" alt=""> 
                           </a>
                       </div>
                        <div>
                           <a href="https://twitter.com/IoTryba">
                                <img :src="asset + 'asset/new_homepage/icons/twitter.svg'" class="h-4 w-auto" alt=""> 
                           </a>
                       </div>
                        <div>
                           <a href="https://instagram.com/tryba.io">
                                <img :src="asset + 'asset/new_homepage/icons/instagram.svg'" class="h-4 w-auto" alt=""> 
                           </a>
                       </div>
                        <div>
                           <a href="#">
                                <img :src="asset + 'asset/new_homepage/icons/linkedin.svg'" class="h-4 w-auto" alt=""> 
                           </a>
                       </div>
                   </div>
               </div>
               <div class="lg:col-span-10 hidden mt-8 lg:mt-0 lg:grid grid-rows-2 lg:grid-rows-1 lg:grid-flow-row lg:grid-cols-10 grid-flow-col gap-3" >
                   <div class="font-inter lg:col-span-2 text-sm" >
                        <h1 class="footer-h1 font-semibold" >LEGAL</h1>
                        <ul class="text-gray-200 my-4 grid grid-rows-1 gap-3 text-sm font-light">
                            <li><a href="terms" class="hover:underline">Terms and conditions</a></li>
                            <li><a href="privacy" class="hover:underline">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="font-inter lg:col-span-2 text-sm" >
                        <h1 class="footer-h1 font-semibold" >RESOURCES</h1>
                        <ul class="text-gray-200 my-4 grid grid-rows-1 gap-3 text-sm font-light">
                            <li><a href="faq" class="hover:underline">FAQs</a></li>
                            <li><a href="https://helpdesk.tryba.io/" class="hover:underline">Help Center</a></li>
                        </ul>
                    </div>
                    <div class="font-inter lg:col-span-2 text-sm" >
                        <h1 class="footer-h1 font-semibold" >INTEGRATIONS</h1>
                        <ul class="text-gray-200 my-4 grid grid-rows-1 gap-3 text-sm font-light">
                            <li><a href="user/merchant-api" class="hover:underline">Developers</a></li>
                            <li><a href="https://tryba.statuspage.io/" class="hover:underline">System Status</a></li>
                        </ul>
                    </div>
                    <div class="font-inter font-light flex flex-col space-y-4 text-xs text-gray-200 lg:col-span-4" >
                        <div>
                            Tryba U.K Limited designs and operates the Tryba websites and app, which offers electronic money (‘e-money’) business current accounts with innovative built-in website and business management functionalities. Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573).
                        </div>
                        <div>
                            Tryba card is an electronic money product issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency.
                        </div>
                        <div class="text-gray-500">
                            Tryba © 2022. All Rights Reserved.
                        </div>
                    </div>
               </div>
               <div class="lg:hidden">
                   <div class="text-gray-200">
                       <div class="flex flex-col space-y-4 my-6">
                           <div @click="toggleShowFeatures" class="flex justify-between py-3">
                               <div class="font-bold">Features</div>
                               <div class="font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': showFeatures}" class="h-6 w-6 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                               </div>
                           </div>
                           <div v-if="showFeatures">
                               <ul class="flex flex-col space-y-4">
                                    <li><a href="#">Website</a></li>
                                    <li><a href="#">Hosted payment links</a></li>
                                    <li><a href="#">Invoicing</a></li>
                                    <li><a href="#">Bookings</a></li>
                                    <li><a href="#">Expense and budgeting</a></li>
                                    <li><a href="#">Connect to marketplace</a></li>
                               </ul>
                           </div>
                            <div @click="toggleShowLegal" class="flex justify-between py-3">
                               <div class="font-bold">Legal</div>
                               <div class="font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': showLegal}"  class="h-6 w-6 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                               </div>
                           </div>
                            <div v-if="showLegal">
                               <ul class="flex flex-col space-y-4">
                                    <li><a href="terms" class="hover:underline">Terms and conditions</a></li>
                                    <li><a href="privacy" class="hover:underline">Privacy Policy</a></li>
                               </ul>
                           </div>
                            <div @click="toggleshowResource" class="flex justify-between py-3">
                               <div class="font-bold">Resources</div>
                               <div class="font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': showResource}"  class="h-6 w-6 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                               </div>
                           </div>
                            <div v-if="showResource">
                               <ul class="flex flex-col space-y-4">
                                    <li><a href="faq" class="hover:underline">FAQs</a></li>
                                    <li><a href="https://helpdesk.tryba.io/" class="hover:underline">Help Center</a></li>
                               </ul>
                           </div>
                            <div @click="toggleshowIntegration" class="flex justify-between py-3">
                               <div class="font-bold">Integration</div>
                               <div class="font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': showIntegration}" class="h-6 w-6 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                               </div>
                           </div>
                            <div v-if="showIntegration">
                               <ul class="flex flex-col space-y-4">
                                    <li><a href="user/merchant-api" class="hover:underline">Developers</a></li>
                                    <li><a href="https://tryba.statuspage.io/" class="hover:underline">System Status</a></li>
                               </ul>
                            </div>
                       </div>
                   </div>
                    <div class="font-inter font-light flex flex-col space-y-4 text-xs text-gray-200 lg:col-span-4" >
                        <div>
                            Tryba U.K Limited designs and operates the Tryba websites and app, which offers electronic money (‘e-money’) business current accounts with innovative built-in website and business management functionalities. Modulr FS Limited is authorised and regulated by the Financial Conduct Authority for issuance of electronic money (FRN 900573).
                        </div>
                        <div>
                            Tryba card is an electronic money product issued by Modulr FS Limited pursuant to license by Visa Europe. Modulr FS Limited holds an amount equivalent to the money in Tryba’s current accounts in a safeguarding account which gives customers protection against Modulr’s insolvency.
                        </div>
                        <div class="text-gray-500">
                            Tryba © 2022. All Rights Reserved.
                        </div>
                    </div>
               </div>
           </div>
       </div>
   </section>
</template>

<script>
export default {
    name:"Footer",
    props:['asset'],
    data(){
        return{
            date: new Date().getFullYear(),
            showFeatures:false,
            showLegal:false,
            showResource:false,
            showIntegration:false
        }
    },
    methods:{
        toggleShowFeatures(){
            this.showFeatures = !this.showFeatures
        },
        toggleShowLegal(){
            this.showLegal = !this.showLegal
        },
        toggleshowResource(){
            this.showResource = !this.showResource
        },
        toggleshowIntegration(){
            this.showIntegration = !this.showIntegration
        }
    }
}
</script>

<style>

</style>