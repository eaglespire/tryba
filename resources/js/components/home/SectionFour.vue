<template>
  <section class="container relative mx-auto py-8 px-6 lg:px-14" >
      <div class="relative">
        <div class="grid grid-rows-1 gap-7 lg:grid-cols-2 lg:gap-14" >
            <div class="lg:my-6">
                <h5 class="font-extrabold text-2xl text-center lg:text-left lg:text-5xl" >How to get started</h5>
                <p class="my-4 font-inter lg:font-semibold text-center lg:text-left" >How to get started In just few clicks, you are on the go to launching a business on tryba</p>
                <div class="hidden lg:flex">
                    <a href="register" class="bg-brand flex space-x-6 items-center px-6 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                        <p>Get started now</p> 
                        <div class="bg-gray-100  font-semibold rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
            <div>
                <div v-for="slide,index in firstSlides" :key="slide">
                    <div  v-show="slide.show">
                        <div :style="'background-image:url('+ asset + 'asset/new_homepage/icons/'+ slide.background + ')'" class="relative w-full bg-cover bg-black h-368.99 lg:h-650 rounded-xl overflow-hidden text-white">
                            <div class="absolute h-full w-full top-0 z-20"></div>
                            <div  class="absolute z-40 grid grid-rows-2 h-full p-6 lg:p-10 lg:mt-4">
                                <div class="w-10/12 " >
                                    <h5 class="font-extrabold text-2xl lg:text-4xl animate__animated animate__bounce v animate__fadeIn" >{{ slide.name }}</h5>
                                    <p class="my-6 text-sm lg:text-base font-inter lg:w-3/4 animate__animated animate__bounce v animate__fadeIn" >{{ slide.content }}</p>
                                </div>
                                <div class="flex font-CabinetGrotesk items-end lg:mb-10" >
                                    <div class="flex justify-between flex-grow">
                                        <div>
                                            <button v-if="index == 0" @click="next(index)" class="bg-overlay px-6 py-2 lg:px-10 rounded-md lg:text-xl text-sm text-gray-200" >Next</button>
                                            <button v-else @click="previous(index)" class="bg-overlay py-2 px-4 lg:px-6 rounded-md lg:text-xl text-sm text-gray-200" >Previous</button>                                        
                                        </div>
                                        <div class="flex space-x-2 items-center">
                                            <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 0,'bg-overlay w-2 lg:w-4':index != 0 }" class="lg:h-4 h-2 rounded-full" ></div>
                                            <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 1,'bg-overlay w-2 lg:w-4':index != 1}" class="lg:h-4 h-2 rounded-full" ></div>
                                            <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 2,'bg-overlay w-2 lg:w-4':index != 2}" class="lg:h-4 h-2 rounded-full" ></div>
                                            <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 3,'bg-overlay w-2 lg:w-4':index != 3}" class="lg:h-4 h-2 rounded-full" ></div>
                                            <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 4,'bg-overlay w-2 lg:w-4':index != 4}" class="lg:h-4 h-2 rounded-full" ></div>
                                            <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 5,'bg-overlay w-2 lg:w-4':index != 5}" class="lg:h-4 h-2 rounded-full" ></div>
                                        </div>
                                        <div v-if="index != 0 && index != 5">
                                            <button @click="next(index)" class="bg-overlay py-2 px-6 text-sm lg:px-10 rounded-md lg:text-xl text-gray-200" >Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>  
            </div>
            <div class="absolute bottom-4 -z-10 my-6">
                <img :src="asset + 'asset/new_homepage/icons/shop.png'" alt="shop">
            </div>
      </div>
  
  </section>

    <section id="features" class="container relative mx-auto py-8 px-6 lg:px-14" >
      <div class="relative overflow-hidden">
        <h5 class=" lg:hidden font-extrabold text-center lg:text-left text-2xl lg:text-5xl">Our features</h5>
        <p class=" lg:hidden lg:my-4 mt-2 mb-4 font-inter text-center lg:text-left lg:font-semibold" >The amazing features of Tryba.io</p>
        <div class="grid grid-rows-1 gap-7 lg:grid-cols-2 lg:gap-14 " >
            <div>
                <div class="relative overflow-hidden h-400 lg:h-606 w-full bg-black rounded-xl">
                    <div v-for="second,index in secondSlides" :key="second">  
                        <div v-show="second.show" >
                            <div :class="second.bg" class="absolute h-full w-full top-0 z-20"></div>
                            <div class="absolute z-40 grid grid-rows-3  h-full w-full p-10 text-gray-100">
                                <h1 class="font-extrabold text-center text-2xl lg:text-4xl animate__animated animate__bounce v animate__fadeIn">{{ second.name }}</h1>
                                <div class="flex justify-center animate__animated animate__bounce v animate__fadeIn" > <img :src="asset + 'asset/new_homepage/icons/'+ second.image" class="object-cover h-24 lg:h-auto" :alt="second.name"> </div>
                                <div class="flex items-end lg:items-start" >
                                    <p class="text-center text-xs lg:text-base font-inter font-semibold lg:mt-10 my-4 animate__animated animate__bounce animate__fadeIn" >
                                        {{ second.content }}
                                    </p>
                                </div>
                                <div class="flex space-x-2 justify-center items-center mt-8 lg:mt-0">
                                    <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 0,'bg-overlay w-2 lg:w-4':index != 0 }" class="lg:h-4 h-2 rounded-full" ></div>
                                    <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 1,'bg-overlay w-2 lg:w-4':index != 1}" class="lg:h-4 h-2 rounded-full" ></div>
                                    <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 2,'bg-overlay w-2 lg:w-4':index != 2}" class="lg:h-4 h-2 rounded-full" ></div>
                                    <div :class="{ 'lg:w-8 w-4 bg-gray-100': index == 3,'bg-overlay w-2 lg:w-4':index != 3}" class="lg:h-4 h-2 rounded-full" ></div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="my-6">
                <h5 class="hidden lg:block font-extrabold text-center lg:text-left text-2xl lg:text-5xl">Our features</h5>
                <p class="hidden lg:block lg:my-4 my-2 font-inter text-center lg:text-left lg:font-semibold" >The amazing features of Tryba.io</p>
                <div class="hidden lg:flex justify-center lg:justify-start mt-10">
                    <a href="register" class="bg-brand flex space-x-6 items-center px-6 py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                        <p>Get started now</p> 
                        <div class="bg-gray-100  font-semibold rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
               
            </div>
      </div>
       <div class="absolute bottom-6 -z-10 -right-32">
            <img :src="asset + 'asset/new_homepage/icons/shop-2.png'" alt="shop">
        </div>
      </div>
  
  </section>
</template>

<script>
import 'animate.css';
export default {
    name:"SectionFour",
    props:['asset'],
    data(){
        return {
            firstSlides:[
                {
                    name:"Signup on tryba",content:"In just few clicks you are completely ready to setup your business the smart way.",background:"account-slide.png",show:true
                },
                {
                    name:"Compliance",content:"As a U.K. compliant business, we are legally required to know you and your business. ",background:"marketplace.png",show:false
                },
                {
                    name:"Setup your payment pages",content:"Choose from tryba’s numerous business tools like web and eStore builder etc. to setup your business quickly.",background:"setup-slide.png",show:false
                },
                {
                    name:"Send payment links",content:"Create and send invoice and payment links, let your clients pay you instantly.",background:"payment-links.png",show:false
                },
                {
                    name:"Receive Instant payments",content:"Let your customers, friends and family pay you instantly from all over the world through various channels.",background:"instant-payment.png",show:false
                },
                {
                    name:"Instant Payout",content:"We use End-to-End Open banking technology to ensure funds are instantly settled in tryba’s bank account.",background:"payout.png",show:false
                },
            ],
            secondSlides:[
                {
                    name:"Business tools",bg:"frist-slide",image:"undraw_business_shop_qw-5-t 1.png",content:"Get the best of tryba’s payment link, invoice, expense and budgeting tools for your business.",show:true
                },
                {
                    name:"Web and Storefront ",bg:"second-second-slide",image:"Frame 1177.png",content:'Launch full functioning with custom domain business and eCommerce websites. Go live in 10mins.',show:false
                },
                {
                    name:"Business bank accounts",bg:"second-third-slide",image:"undraw_grandma_re_rnv1 1.png",content:'Tryba’s business bank accounts with virtual and physical cards designed to grow with your business.',show:false
                },
                {
                    name:"Merchant",bg:"second-fouth-slide",image:"undraw_business_deal_re_up4u 1.png",content:"Build tryba’s functionalities into your existing workflow and unlock business potentials like never before.",show:false
                }
            ]
        }
    },
    methods:{
        next(data){
            this.firstSlides[data].show = false
            if(data + 1 >  this.firstSlides.length){
                 this.firstSlides[0].show = true
            }else{
                this.firstSlides[data + 1].show = true
            }
        },
        previous(data){
            this.firstSlides[data].show = false
            this.firstSlides[data - 1].show = true
        },
        changeSlides(){
            setInterval(()=>{
                let index = this.secondSlides.findIndex(item => item.show == true);
                let postion = index + 1
                 this.secondSlides[index].show = false
                if(this.secondSlides.length == postion){
                    this.secondSlides[0].show = true;
                }else{
                    this.secondSlides[postion].show = true
                }
            },4000)
          
        }
    },
    mounted(){
        this.changeSlides();
    }

}
</script>

<style scoped>
.bg-overlay{
    background: rgba(0, 0, 0, 0.35);
}
.second-slide{
    background: linear-gradient(360deg, #099813 0%, rgba(0, 0, 0, 0) 94.95%);
}
.third-slide{
   background: linear-gradient(360deg, #1D0998 0%, rgba(0, 0, 0, 0) 94.95%);

}
.fourth-slide{
    background: linear-gradient(360deg, #590998 0%, rgba(0, 0, 0, 0) 94.95%);
}
.fifth-slide{
    background: linear-gradient(360deg, #983409 0%, rgba(0, 0, 0, 0) 94.95%);
}
.sixth-slide{
    background: linear-gradient(360deg, #098F98 0%, rgba(0, 0, 0, 0) 94.95%);
}
.second-second-slide{
    background: linear-gradient(360deg, #00EFB6 -13.84%, rgba(0, 0, 0, 0) 94.95%);
}
.second-third-slide{
    background: linear-gradient(360deg, #00E1EF -13.84%, rgba(0, 0, 0, 0) 94.95%);
}
.second-fouth-slide{
    background: linear-gradient(360deg, #008BEF -13.84%, rgba(0, 0, 0, 0) 94.95%);
}
</style>