<template>
  <section class="container overflow-hidden mx-auto my-8 lg:my-16 px-2 lg:px-24" >
       <h1 class="text-4xl lg:text-5xl text-center">
            All our plans come with these <span class="text-brand">benefits</span> 
        </h1>

        <div class="lg:px-28 px-2 my-8 lg:my-16">
            <div id="overflow" class="flex space-x-4 overflow-x-auto lg:overflow-hidden lg:grid lg:grid-cols-2 lg:gap-8 mb-16">
                <div v-for="plan in plans" :key="plan" class="border-brand border min-w-[95%] lg:min-w-max p-8 lg:p-12">
                    <h1 class="font-semibold text-2xl text-center" >{{ plan.name }}</h1>
                    <div class="my-8 py-2 font-inter border-b">
                        <div class="flex justify-between">
                            <p>Maximum account balance</p>
                            <p class="font-semibold">{{ plan.maxAmount }}</p>
                        </div>
                    </div>
                    <div class="my-8 font-inter">
                        <div class=" font-semibold">
                            <p>Limits per transaction </p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Cash deposit via Post Office</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitperTrx.cashDepositPostOffice) }}</p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Cash deposit via PayPoint</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitperTrx.cashDepositPaypoint) }}</p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Account transfers</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitperTrx.accountTransfers) }}</p>
                        </div>
                    </div>
                    <div class="my-8 font-inter">
                        <div class=" font-semibold">
                            <p>Limits per day</p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Cash withdrawal via ATM</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitsPerDay.cashWithdrawlAtm) }}</p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Cash deposit via PayPoint</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitsPerDay.cashDepositPaypoint) }}</p>
                        </div>
                          <div class="flex justify-between border-b my-2 py-2">
                            <p>Card purchases</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitsPerDay.cardPurchase) }}</p>
                        </div>
                    </div>
                    <div class="my-8 font-inter">
                        <div class=" font-semibold">
                            <p>Limits per month</p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Account transfers</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitsPerMonth.accountTransfers) }}</p>
                        </div>
                        <div class="flex justify-between border-b my-2 py-2">
                            <p>Cash deposit via PayPoint</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitsPerMonth.cashDepositPaypoint) }}</p>
                        </div>
                          <div class="flex justify-between border-b my-2 py-2">
                            <p>Card purchases</p>
                            <p class="font-semibold">£{{ this.formatNumber.formatNumber(plan.limitsPerMonth.cardPurchase) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center font-inter my-8" >
                Most of our costs are based on your activity, so if your business  has a quieter month your subscription fee may decrease. Equally, if you have a fantastic month with lots of money deposited, it may increase. We aim to partner with our customers and charge fairly for our services – we hope you approve.
            </div>
        </div>

        
  </section>
</template>

<script>
export default {
    name:"Listing",
    props:['asset'],
    data(){
        return{
            plans:[
                {
                    name:"Self employed",
                    maxAmount:'£50,000',
                    limitperTrx:{
                        cashDepositPostOffice: 500,
                        cashDepositPaypoint: 500,
                        accountTransfers:25000
                    },
                    limitsPerDay:{
                        cashWithdrawlAtm: 500,
                        cashDepositPaypoint: 500,
                        cardPurchase:25000
                    },
                    limitsPerMonth:{
                        accountTransfers:100500,
                        cashDepositPaypoint:500,
                        cardPurchase:25000
                    }
                },
                {
                    name:"Limited company",
                    maxAmount:'£50,000',
                    limitperTrx:{
                        cashDepositPostOffice: 500,
                        cashDepositPaypoint: 500,
                        accountTransfers:25000
                    },
                    limitsPerDay:{
                        cashWithdrawlAtm: 500,
                        cashDepositPaypoint: 500,
                        cardPurchase:25000
                    },
                    limitsPerMonth:{
                        accountTransfers:100500,
                        cashDepositPaypoint:500,
                        cardPurchase:25000
                    }
                }
                
            ]
        }
    }
}
</script>

<style scoped>
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