<template>
   <section class="bg-gray-100 py-16 lg:py-0 relative">
       <div class="container overflow-hidden mx-auto py-14 px-3 lg:px-24">
            <div class="text-center text-gray-400 text-base font-semibold">
                Pricing that’s small business friendly
            </div>
            <div class="text-center text-2xl hidden lg:block font-semibold">
                Our pricing has emotions. It feels every moment in your business.
           </div>
            <div class="text-left text-black lg:hidden font-bold text-3xl my-4">
              Our pricing has <br> emotions. It feels <br> every moment in<br>
               <p class="p-3 bg-[#192A52] text-gray-100 inline-block mt-2">your business.</p>
            </div>
            <div id="overflow" class="flex space-x-4 lg:space-x-0 overflow-x-auto lg:overflow-x-visible lg:grid lg:grid-cols-3 lg:gap-6 my-8">
                <div v-for="plan in plansBackend" :key="plan" :class="{'bg-brand text-gray': plan.id == 1 ,'bg-[#FFE770A6] text-black': plan.id == 2,'bg-[#FFB8B8] text-gray-100': plan.id == 3}" class="bg-brand relative min-w-[80%] lg:min-w-full space-y-8 flex flex-col text-gray-100 rounded-lg shadow-lg px-4 py-8">
                    <div class="text-xl text-center font-semibold">
                        £{{ this.formatNumber.formatNumber(plan.amount) }}/{{ plan.durationType }}
                    </div>
                    <div class="text-xs text-center">
                        Total monthly deposits
                    </div>
                    <div class="text-2xl text-center font-semibold">
                        £{{  this.formatNumber.formatNumber(plan.annualstartPrice) }} - <span v-if="plan.id != 3" >£{{  this.formatNumber.formatNumber(plan.annualendPrice) }}</span> <span v-else>Unlimited</span>
                    </div>
                    <div class="flex justify-center">
                        <button :class="{'border-black': plan.id == 2}" class="text-sm border border-gray-100 py-3 px-6 rounded-md">
                            Learn More
                        </button>
                    </div>
                    <div class="text-xs my-4">
                        *Our pricing adjusts with your monthly transactions
                    </div>
                </div>
            </div>
           <div class="text-xs text-center text-gray-400 lg:hidden">&#8810; Swipe to see Tryba's emotional pricing &#8811;</div>
       </div>
        <div class="flex justify-center lg:hidden w-full absolute bottom-0 left-0">
            <div class="h-[1px] bg-gray-300 w-3/5"></div>
        </div>
   </section>
</template>

<script>
import axios from "axios";
export default {
    name:"Section",
    props:['asset'],
    data(){
        return{
            plansBackend:[]
        }
    },
    methods:{
        async getPlans(){
            let url = window.location.origin + '/api/plan';
            let res = await axios.get(url);
            this.plansBackend = res.data.plans;
            this.plansBackend.map((item)=>{
                let plan = this.plans.find((plan) => plan.id == item.id);
                item.background = plan.background
                if(item.id == 3){
                    item.annualendPrice = "Unlimited"
                }
            });
        }
    },
    beforeMount(){
        this.getPlans();
    }
}
</script>

<style>

</style>