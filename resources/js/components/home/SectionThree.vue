<template>
  <section class="container mx-auto py-16 px-3 lg:px-14" >
      <h1 class="font-extrabold text-2xl lg:text-4xl text-center" >Tryba.io helps businesses launch 10mins.</h1>
      <div class="relative brand-secondary-2 border rounded-xl my-6" >
            <div class="absolute hidden lg:block top-10 -z-10" > 
                <img :src="asset + 'asset/new_homepage/icons/blobs.png'" alt="storefront">
            </div>
            <div v-for="slide,index in slides" :key="slide" >
                <div v-show="slide.show" class="grid lg:grid-cols-2 grid-cols-3 gap-6 lg:px-16 px-4 py-8 lg:py-16">
                    <div class="flex items-center col-span-2 lg:col-span-1" >
                        <div>
                            <h1 :id="'title' + index" :class="{'opacity-0':index != 0}" class="font-extrabold text-xl lg:text-4xl transition-opacity duration-700" >{{ slide.title }}</h1>
                            <p  :id="'content' + index" :class="{'opacity-0':index != 0}" class="lg:my-6 my-4 lg:w-96 font-inter text-sm lg:text-xl transition-opacity duration-700 font-semibold">{{ slide.content }}</p>
                            <div class="flex">
                                <a href="register" class="bg-brand flex space-x-6 items-center lg:px-6 px-6 py-3 lg:py-3 rounded-lg text-gray-100 font-inter font-normal transition duration-300  hover:opacity-70" >
                                    <p class="text-sm lg:text-base">Get started now</p> 
                                    <div class="bg-gray-100 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-4 lg:w-4 h-3 w-3 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end" >
                        <div :id="'image' + index" :class="{'opacity-0':index != 0}" class="transition-opacity duration-700 opacity-0">
                            <img :src=" asset +'asset/new_homepage/icons/'+ slide.img" class="lg:h-96 w-auto object-cover" alt="storefront">
                        </div>
                    </div>
                </div>
            </div>
      </div>
  </section>
</template>

<script>
export default {
    name:"SectionThree",
    props:['asset'],
    data(){
        return{
            slides:[
                {content:"Create fully functioning business websites and storefronts instantly.",title:"Web and Storefront ",img:'undraw_add_to_cart_re_wrdo 1.png',show:true},
                {content:"End-to-End Online payments that is instant without fraudulent chargeback.",title:"Payment",img:'undraw_credit_card_payments_re_qboh.png',show:false},
                {content:"Gain access to tryba’s all in one business tools for the success of your business.",title:"Business tools",img:'undraw_add_notes_re_ln36 1.png',show:false}
            ]
        }
    },
    methods:{
        changeSlides(){
            setInterval(()=>{
                let postion = this.slides.findIndex(item => item.show == true)
                let nextItem = postion + 1
                this.slides[postion].show = false
                let title = document.querySelector('#title'+postion);
                let content = document.querySelector('#content'+postion);
                let image = document.querySelector('#image'+postion);
                title.classList.add('opacity-0')
                content.classList.add('opacity-0')
                image.classList.add('opacity-0')
                if(nextItem == this.slides.length){
                    this.slides[0].show = true
                     setTimeout(()=>{
                        let title = document.querySelector('#title'+0);
                        let content = document.querySelector('#content'+0);
                        let image = document.querySelector('#image'+0)
                        title.classList.remove('opacity-0')
                        content.classList.remove('opacity-0')
                        image.classList.remove('opacity-0')
                    },50)
                }else{
                    this.slides[nextItem].show = true
                    setTimeout(()=>{
                        let title = document.querySelector('#title'+nextItem);
                        let content = document.querySelector('#content'+nextItem);
                        let image = document.querySelector('#image'+nextItem)
                        title.classList.remove('opacity-0')
                        content.classList.remove('opacity-0')
                        image.classList.remove('opacity-0')
  
                    },50)
                 
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