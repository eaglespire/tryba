<template>
    <section v-show="showNotice" class="bg-black/90 text-gray-100">
        <div class="container mx-auto lg:px-14 px-3 lg:mb-2 mb-4 text-white" >
            <div class="flex w-full text-brand rounded p-3" >                    
                <div class="text-center font-inter text-sm w-[95%]" >Tryba is in beta, <button @click="toggleshowPopup" class="text-gray-100" >Request access.</button></div>
                <div class="top-0 left-0 px-2  w-[5%] h-full items-center flex justify-end">
                    <button @click="closeComingSoon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div v-if="showPopup" class="fixed flex justify-center items-center bg-overlay z-[999] p-4 top-0 left-0  w-full h-full">
        <div class="bg-white rounded px-4 py-4 w-[30rem]">
           <div class="flex justify-between" >
               <p class="font-poppins text-xl">Request access</p>
               <div>
                    <button class="text-brand" @click="toggleshowPopup">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
               </div>
           </div>
           <form @submit.prevent="joinWaitlist" class="mt-4">
                <div v-if="error" class="text-red-400 text-sm font-inter my-2" >{{ error }}</div>
                <div v-if="success" class="text-green-600 text-sm font-inter my-2" >{{ success }}</div>
                <div class="grid grid-cols-2 mb-4 gap-4">
                    <div>
                        <input type="text" v-model="first_name" placeholder="First Name" class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
                    </div>
                       <div>
                        <input type="text" v-model="last_name" placeholder="Last Name" class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
                    </div>
                </div>
                <div class="mb-4">
                    <input type="text" v-model="email" placeholder="Enter your email address" class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
                </div>
                <div class="mb-4">
                    <div class="flex">
                        <div class="font-inter w-1/5 flex bg-gray-100 text-sm  justify-center items-center rounded-tl rounded-bl">
                            <div>+{{ phonecode }}</div>
                        </div>
                        <div class=" flex-grow">
                            <input type="text" v-model="phone" placeholder="Enter your phone number " class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded-tr rounded-br">
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <button type="submit" class="px-8 text-sm font-inter space-x-3 py-3 bg-brand rounded-md text-white">
                        <div class="flex space-x-3 items-center" v-if="showPreloader">
                            <p>Requesting ...</p> <Preloader/>
                        </div>
                        <span v-else>Request</span>
                    </button>
                </div>
           </form>
        </div>
    </div>
</template>
<script>
     import Preloader from '../components/Preloader.vue';
    export default{
        name:"Notice",
        components:{
            Preloader
        },
        data(){
            return{
                showNotice:true,
                showPopup:false,
                showPreloader:false,
                error:null,
                homeUrl : window.location.origin,
                token: window.token.token,
                email:"",
                success:null,
                first_name:"",
                last_name:"",
                phonecode:"44",
                phone:""
            }
        },
        methods:{
            closeComingSoon(){
                this.showNotice = !this.showNotice
            },
            toggleshowPopup(){
                this.showPopup = !this.showPopup
            },
            toggleshowPreloader(){
                this.showPreloader = !this.showPreloader
            },
            async joinWaitlist(){
                let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if(!this.first_name)
                    this.error = "First name field is required"  
                else if(!this.last_name) {
                  this.error = "Last name field is required"  
                }
                else if(!this.email) {
                  this.error = "Email address field is required"  
                }else if (!this.email.match(regexEmail)) {
                    this.error = "Invaild email address entered" 
                }else if (!this.phone) {
                    this.error = "Phone number field is required" 
                }
                else{
                    this.error = null;
                    let url = this.homeUrl + '/api/waiting-list/add'
                    let data = {
                        email: this.email,
                        name:`${this.first_name} ${this.last_name}`,
                        phonecode:`+${this.phonecode}`,
                        phone:this.phone,
                        _token : this.token
                    }
                    try {
                        this.toggleshowPreloader()
                        let res = await fetch(url,{
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        });
                        let result = await res.json(); 
                        this.toggleshowPreloader();
                        if (res.ok) {
                            this.success = "You will get notified when we give you access"
                            setTimeout(()=>{
                                this.success = null;
                                this.email = this.first_name = this.last_name = "";
                                this.toggleshowPopup();
                            },2000)
                        }else{
                            this.error = result.error
                        }
                        //this.toggleshowPreloader();
                    } catch (error) {
                        console.log(error)
                    }
                  
                }
            }
        }
    }
</script>