<template>
    <section class="container mx-auto my-28 px-6 lg:px-24" >
        <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-6 my-6">
            <div class="mt-14 flex items-center lg:mt-0">
                <div>
                    <h1 class="text-3xl font-semibold text-center lg:text-left lg:text-5xl" >
                        Pricing that changes <br> with your <span class="text-brand" >business</span> 
                    </h1>
                    <p class="font-inter my-4 text-center lg:text-left">
                        It's important to us that you're happy. If the cost of our services decrease or increase depending on how much activity is happening in a given month, we would love for this change rate between months and seasons so as not leave anyone out!
                    </p>
                </div>
            </div>
            <div class="flex justify-center" >
                <img :src="asset + 'asset/new_homepage/icons/pricing.png'" class="lg:h-[500px] h-[300px] w-auto" alt="Tryba">
            </div>
        </div>
    </section>
    <section class="container mx-auto my-28 px-3 lg:px-12" >
        <div class="bg-gray-100 p-6 lg:p-12 rounded-lg" >
            <h1 class="text-3xl lg:text-5xl text-center">
                All our plans come with these <span class="text-brand">benefits</span> 
            </h1>
            <div class="grid grid-rows-1 gap-8 lg:grid-cols-3 lg:gap-8 my-8 lg:my-16">
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Business current account</h3>
                        <p class="font-inter">
                            Open an account in minutes to get a Visa card, sort code and account number.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Website and eStore builder</h3>
                        <p class="font-inter">
                            Build a complete website in 10mins with our instant, all text based web and eStore builder with custom domain name.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Booking and appointment</h3>
                        <p class="font-inter">
                            If your business offer booking service, you can build it on tryba instantly.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Expense and budgeting</h3>
                        <p class="font-inter">
                            Keep organised on the go with tryba’s budgeting system.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Invoicing and payment links</h3>
                        <p class="font-inter">
                            Send invoice and payment links in seconds. Know who’s paid you at a glance with invoices sorted.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Connections</h3>
                        <p class="font-inter">
                            Connect to your external workflows like Xero, Paypal etc. 
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Instant notifications</h3>
                        <p class="font-inter">
                            Stay on top of your business income and spending with tryba’s report notifications.. 
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Profit & loss</h3>
                        <p class="font-inter">
                           Instantly see how your business is performing at a glance.
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-3" >
                    <div><img :src="asset + 'asset/new_homepage/icons/tick-circle.svg'" class="h-10 w-10" alt="Tryba"></div>
                    <div class="col-span-6" >
                        <h3 class="font-semibold text-xl">Elegant APIs</h3>
                        <p class="font-inter">
                          Easily connect our APIs to your existing service and instantly see tryba in action.
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <h1 class="font-semibold my-8 text-2xl">Transaction charges</h1>
            <div class="grid grid-rows-1 lg:grid-cols-3 gap-8 font-inter" >
                <div>Invoice/Payment links <span class="font-bold" >1%</span></div>
                <div>ATM withdrawals <span class="font-bold" >£1</span></div>
                <div>Post Office deposit <span class="font-bold" >£1</span></div>
                <div>PayPoint deposit <span class="font-bold" >3%</span></div>
                <div>Foreign currency transaction fee <span class="font-bold" >3%</span></div>
                <div> Account transfers in/out <span class="font-bold" >30p</span></div>
                 
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name:"SectionThree",
    props:['asset']

}
</script>
