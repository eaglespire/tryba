<template>
      <section id="started" class="bg-black/90 text-gray-100">
          <div class="container mx-auto py-8 px-6 lg:px-14" >
            <div class="grid grid-rows-1 lg:grid-cols-2" >
                <div>
                    <img :src="asset + 'asset/new_homepage/icons/credit-cards-with-round-stone-mockup.png'" alt="Credit card">
                </div>
                <div class="flex items-center">
                    <div>
                        <h1 class="font-extrabold text-2xl text-center lg:text-left lg:text-4xl" >Business accounts and Visa cards for your startup business.</h1>
                        <p class="font-inter font-medium my-4  text-center lg:text-left">Tryba’s business accounts and cards are designed to give you flexibility, allowing you to focus on your business.</p>
                        <div class="flex justify-center lg:justify-end space-x-4 my-4" >
                            <div><a href="#"><img :src="asset + 'asset/new_homepage/icons/app-store-white.svg'" alt="App Store"></a></div>
                            <div><a href="#"><img :src=" asset + 'asset/new_homepage/icons/google-play-white.svg'" alt="Google play"></a></div>
                        </div> 
                    </div> 
                </div>

            </div>
          </div>
      </section>
      <section class="container mx-auto py-16 lg:px-14 px-6" >
          <div class="grid grid-rows-1 lg:grid-cols-2" >
              <div>
                  <h1 class="font-extrabold text-2xl lg:text-4xl text-center lg:text-left" >Easy startup tools that makes Business really peasy!</h1>
                  <p class="font-inter font-medium my-6">Launch a complete business on the tryba’s ecosystem, with tools like web and store builder, invoicing, payment links etc.</p>
                  <div v-show="slides[0]" class="grid grid-cols-6 font-CabinetGrotesk brand-secondary-2 border py-4 rounded-lg overflow-hidden">
                      <div class="relative col-span-2 my-4">
                          <div class="-ml-4 brand-secondary mt-8 w-32 h-32 lg:h-44 lg:w-44 rounded-full"></div>
                          <div class=" absolute top-16 lg:top-20 -left-2 z-0 bg-white h-16 w-16 flex items-center justify-center rounded-lg shadow-2xl" >
                              <div>
                                  <img :src="asset + 'asset/new_homepage/icons/Union.png'" alt="Love">
                              </div> 
                          </div>
                          <div class="absolute lg:-top-8 -right-8 -top-4  lg:-right-4">
                              <img :src="asset + 'asset/new_homepage/icons/Marni5.png'" class="h-56 w-auto lg:h-auto" alt="Marin">
                          </div>
                      </div>
                      <div class="col-span-4 flex items-center lg:px-4">
                          <div class="px-4" >
                               <h1 class="font-extrabold text-2xl lg:text-4xl">This is <span class="text-brand" >SUE</span></h1>
                                <p class="font-inter font-medium text-sm lg:text-base my-4">Sue owns a cleaning company and wants her clients to book for services, so she chooses Tryba.</p>
                            </div>
                      </div>
                  </div>
                    <div v-show="slides[1]" class="grid grid-cols-6 font-CabinetGrotesk brand-secondary-2 border py-4 rounded-lg overflow-hidden">
                      <div class="relative col-span-2 my-4">
                          <div class="-ml-4 brand-secondary mt-8 h-32 w-32 lg:h-44 lg:w-44 rounded-full"></div>
                          <div class=" absolute lg:top-20 top-16 -left-2 z-0 bg-white h-16 w-16 flex items-center justify-center rounded-lg shadow-2xl" >
                              <div>
                                  <img :src="asset + 'asset/new_homepage/icons/Union.png'" alt="Love">
                              </div> 
                          </div>
                          <div class="absolute lg:-top-8 -top-4 -right-8 lg:-right-4">
                              <img :src="asset + 'asset/new_homepage/icons/Marni2.png'" class="h-56 w-auto lg:h-auto" alt="Marin">
                          </div>
                      </div>
                      <div class="col-span-4 flex items-center lg:px-4">
                          <div class="px-4" >
                               <h1 class="font-extrabold text-xl lg:text-3xl">Tryba provides <span class="text-brand" >SUE</span> with varieties of business management tools to get started with like;</h1>
                            </div>
                      </div>
                    </div>
                    <div v-show="slides[2]"  class="grid grid-cols-6 font-CabinetGrotesk brand-secondary-2 border py-4 rounded-lg overflow-hidden">
                      <div class="relative col-span-2 my-4">
                          <div class="-ml-4 brand-secondary mt-8 w-32 h-32 lg:h-44 lg:w-44 rounded-full"></div>
                          <div class=" absolute lg:top-20 top-16 -left-2 z-0 bg-white h-16 w-16 flex items-center justify-center rounded-lg shadow-2xl" >
                              <div>
                                  <img :src="asset + 'asset/new_homepage/icons/Union.png'" alt="Love">
                              </div> 
                          </div>
                          <div class="absolute lg:top-8 top-8 -right-8 lg:-right-6">
                              <img :src="asset + 'asset/new_homepage/icons/Saly-12.png'" class="h-28 w-auto lg:h-auto" alt="Marin">
                          </div>
                      </div>
                      <div class="col-span-4 flex items-center px-4">
                          <div class="pl-6 lg:px-4" >
                               <h1 class="font-semibold text-base lg:text-2xl">A functioning website with booking system for her clients.</h1>
                            </div>
                      </div>
                    </div>
                    <div v-show="slides[3]"  class="grid grid-cols-6 font-CabinetGrotesk brand-secondary-2 border py-4 rounded-lg overflow-hidden">
                      <div class="relative col-span-2 my-4">
                          <div class="-ml-4 opacity-0 brand-secondary mt-8 h-32 w-32 lg:h-44 lg:w-44 rounded-full"></div>                        
                        <div class="absolute lg:top-2 top-2 -right-4 lg:right-4">
                              <img :src="asset + 'asset/new_homepage/icons/Payment-Card.png'" alt="Card">
                          </div>
                      </div>
                      <div class="col-span-4 flex items-center px-4">
                          <div class="px-4" >
                               <h1 class="font-semibold text-base lg:text-2xl">A payment collection system to take payments with.</h1>
                            </div>
                      </div>
                    </div>
                    <div v-show="slides[4]" class="grid grid-cols-6 font-CabinetGrotesk brand-secondary-2 border py-4 rounded-lg overflow-hidden">
                      <div class="relative col-span-2 my-4">
                          <div class="-ml-4 opacity-0 brand-secondary mt-8 h-32 w-32 lg:h-44 lg:w-44 rounded-full"></div>                        
                        <div class="absolute lg:top-4 top-2 -right-4 lg:right-4">
                              <img :src="asset + 'asset/new_homepage/icons/Saly-26.png'" class="h-32 lg:h-auto w-auto" alt="Card">
                          </div>
                      </div>
                      <div class="col-span-4 flex items-center px-4">
                          <div class="px-4" >
                               <h1 class="font-semibold text-base lg:text-2xl">An invoice, payment links, expense and budgeting system to manage her business.</h1>
                            </div>
                      </div>
                    </div>
                    
              </div>
              <div class="flex lg:justify-end justify-center items-center">
                  <div>
                      <img :src="asset + 'asset/new_homepage/icons/Saly-1.png'" class="lg:h-96 w-auto" alt="speed">
                      <div class="flex justify-center">
                        <a href="register" class="flex space-x-6 items-center px-6 border text-brand border-brand py-3 rounded-lg font-inter font-normal transition duration-300  hover:opacity-70" >
                            <p>Launch your business</p> 
                            <div class="bg-brand rounded-full p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </a>
                      </div>
                  </div>

              </div>

          </div>
      </section>
</template>

<script>
export default {
    name:"Section2",
    props:['asset'],
    data(){
        return{
            slides:[
                true,false,false,false,false
            ]
        }
    },
    methods:{
        changeSlides(){
            setInterval(()=>{
                let postion = this.slides.findIndex(item => item == true)
                let nextItem = postion + 1
                this.slides[postion] = false
                if(nextItem == this.slides.length){
                    this.slides[0] = true
                }else{
                    this.slides[nextItem] = true
                }
            },5000)
          
        }
    },
    mounted(){
        this.changeSlides();
    }

}
</script>

<style>

</style>