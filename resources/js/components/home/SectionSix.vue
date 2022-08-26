<template>
    <section class="container mx-auto py-8 lg:pt-16 lg:px-24" >
        <div class="px-6 lg:px-0" >
            <h1 class="font-semibold text-center text-3xl lg:text-4xl" >Pricing that's <span class="text-brand">business friendly</span></h1>
            <p class="font-inter text-center my-2" >Pricing that's business friendly, Our dynamic pricing model to grow with you.</p>
        </div>
        <div id="overflow" class="flex space-x-4 overflow-x-auto lg:overflow-x-visible lg:grid lg:grid-cols-3 lg:gap-6 my-6">
            <div v-for="plan,index in plansBackend" :key="plan" :class="{'ml-6 lg:ml-0': index == 0,'mr-6 lg:mr-0': index == 2 }" :style="'background-image:url('+ asset + 'asset/new_homepage/icons/'+ plan.background + ')'" class="relative lg:w-full bg-cover h-[350px] min-w-[80%] lg:min-w-[100%] bg-black rounded-xl overflow-hidden text-white">
                <div class="absolute z-40  grid grid-rows-2 h-full w-full p-6 lg:p-10 lg:mt-10">
                    <div class="flex justify-center lg:items-start items-center" >
                        <div>
                            <h5 class="font-extrabold text-center text-2xl lg:text-3xl" >£{{ this.formatNumber.formatNumber(plan.amount) }}/{{ plan.durationType }}</h5>
                            <p class="text-sm text-center font-inter my-2" >Total monthly deposits</p>
                            <p v-if="plan.id != 3" class="font-extrabold text-center text-2xl lg:text-3xl" >£{{ this.formatNumber.formatNumber(plan.annualstartPrice) }} - £{{ this.formatNumber.formatNumber(plan.annualendPrice) }}</p>
                            <p v-else  class="font-extrabold text-center text-2xl lg:text-3xl" >Unlimited</p>
                        </div> 
                    </div>
                    <div class="flex justify-center items-center lg:items-end lg:mb-10" >
                         <button class="bg-brand px-6 py-2 rounded-md text-gray-200" >Get Started</button>
                    </div>
                </div>
        
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
export default {
    name:"Pricing",
    props:['asset'],
    data(){
        return{
            plans:[
                {id:1,monthPrice:"£5/month",annualPrice:"£0 - £2,500",background:"payout.png"},
                {id:2,monthPrice:"£9.99/month",annualPrice:"£2,500 - £12,850",background:"payout2.png"},
                {id:3,monthPrice:"£50/month",annualPrice:"Unlimited",background:"unlimited.png"},
            ],
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

<style scoped>
.bg-overlay{
    background: linear-gradient(360deg, #097298 13.14%, rgba(42, 169, 216, 0) 94.95%);
}

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