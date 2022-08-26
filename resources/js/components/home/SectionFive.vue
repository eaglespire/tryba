<template>
  <section class="container mx-auto py-8 px-8 lg:px-14 overflow-hidden">
        <h1 class="font-extrabold text-2xl lg:text-4xl text-center" >Tryba's solemn promise to businesses.</h1>
        <p class="lg:font-medium lg:text-center text-left text-sx my-4 font-inter">Web and store builder, invoicing, payment links, expense and budgeting, business bank accounts and cards, <br class="hidden lg:block"> APIs, security, instant payment settlement and transactions, all sorted for you.</p>
        <div class="grid lg:grid-cols-3 grid-rows-1 container gap-6 lg:px-10 lg:my-14" >
            <div class="brand-secondary-2 p-6" >
                <div class="flex justify-center my-12" >
                    <img :src="asset + 'asset/new_homepage/icons/free.png'" alt="free">
                </div>
                <h5 class="font-bold text-xl text-center" >Business accounts</h5>
                <p class="text-sm text-center my-4 font-inter">Enabled by Modulr FS Ltd for the provision of tryba’s business accounts and cards</p>
            </div>

            <div class="brand-secondary-2 p-6" >
                <div class="flex justify-center my-12" >
                    <img :src="asset + 'asset/new_homepage/icons/fingerprint.png'" alt="payment">
                </div>
                <h5 class="font-bold text-xl text-center" >Instant payment</h5>
                <p class="text-sm text-center my-4 font-inter">Powered by SafeConnect Ltd for easy and instant bank payment with no chargebacks.</p>
            </div>

            <div class="brand-secondary-2 p-6" >
                <div class="flex justify-center my-12" >
                    <img :src="asset + 'asset/new_homepage/icons/security.png'" alt="security">
                </div>
                <h5 class="font-bold text-xl text-center" >Secure platform</h5>
                <p class="text-sm text-center my-4 font-inter">Secured by the latest security for secure business transactions.</p>
            </div>
        </div>
        <div class="hidden lg:flex justify-center" >
            <a href="register" class="bg-brand flex space-x-6 items-center px-6 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                <p>Create an account</p> 
                <div class="bg-gray-100 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        </div>
        
  </section>    
  <section class="container mx-auto py-16 px-6 lg:px-24" >
       <div class="lg:grid lg:grid-rows-1 lg:gap-10 lg:grid-cols-2" >
              <div class="flex justify-center lg:justify-end lg:ml-16">
                  <img :src="asset + 'asset/new_homepage/icons/tryba-phone.png'" class="h-[350px] w-auto" alt="Credit card">
              </div>
              <div class="flex mt-8 lg:mt-0 justify-center lg:justify-start items-center">
                  <div>
                        <h1 class="font-extrabold text-center lg:text-left text-2xl lg:text-5xl" >Goodbye <br> to messy business setup. </h1>
                        <p class="font-medium text-center lg:text-left font-CabinetGrotesk lg:text-xl text-base my-2">Tryba is your all in one business management tool designed to help your business effortlessly.</p>
                        <div class="flex justify-center lg:justify-start space-x-8 my-4" >
                            <div>
                                <a href="#">
                                    <img :src="asset + 'asset/new_homepage/icons/app-store-black.svg'" alt="App Store">
                                </a>
                            </div>
                            <div>
                                <a href="#">
                                    <img :src="asset +  'asset/new_homepage/icons/google-play-black.svg'" alt="Google play">
                                </a>
                            </div>
                        </div>  
                  </div>
              </div>

          </div>
  </section>
</template>

<script>
export default {
    name:"SectionFive",
    props:['asset']
}
</script>

<style>

</style>