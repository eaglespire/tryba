<template>
      <Modal>
        <div :class="{'justify-between': tabs.personal || tabs.credentails}" class="flex justify-end" >
            <div v-if="tabs.personal || tabs.credentails">
                <button @click="goToPages((tabs.personal) ? 'country' : 'personal')" class="flex space-x-2 font-inter items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <p class="text-brand text-sm">Previous</p>
                </button>
            </div>
            <div>
                <button @click="emitClose" class="text-brand">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        </div>
        <h1 class="text-2xl font-poppins font-semibold">Register</h1>
        <p class="font-normal mb-4 font-inter text-sm">The smart way to do business</p>
        <div v-if="error" class="text-red-400 text-sm font-inter my-2" >{{ error }}</div>
        <div v-if="success" class="text-green-600 text-sm font-inter my-2" >{{ success }}</div>
        <form v-if="tabs.country" @submit.prevent="submitCountry">
            <select v-model="countryID" class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
                <option value="">Select country</option>
                <option v-for="country in countries" :key="country" :value="country.country_id">{{ country.real.nicename }}</option>
            </select>
            <div class="my-4">
                <button type="submit" class="px-8 w-full text-sm font-inter space-x-3 py-3 bg-brand rounded-md text-white">
                    Next
                </button>
            </div>
        </form>
         <form v-else-if="tabs.personal" @submit.prevent="submitName">
            <div class="mb-4">
                <input type="text" v-model="firstName" placeholder="Enter First Name" class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div class="mb-4">
                <input type="text" v-model="lastName" placeholder="Enter Last Name" class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
                 <div class="mb-4">
                <input type="text" v-model="middleName" placeholder="Enter Middle Name (Optional)" class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div class="mb-4">
                <div class="flex">
                    <div class="border-2 font-inter w-1/5 text-sm flex justify-center items-center rounded-tl rounded-bl">
                        <div>+{{ phonecode }}</div>
                    </div>
                    <div class=" flex-grow">
                        <input type="text" v-model="phone" placeholder="Enter your phone number " class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded-tr rounded-br">
                    </div>
                </div>
            </div>

            <div class="my-4">
                <button type="submit" class="px-8 w-full text-sm font-inter space-x-3 py-3 bg-brand rounded-md text-white">
                    Next
                </button>
            </div>
        </form>
        <form v-else @submit.prevent="register" class="mt-4">
            <div class="mb-4">
                <input type="email" v-model="email" placeholder="Enter your email address" class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div class="mb-4">
                <input type="password" v-model="password" placeholder="Password" class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div>
                <input type="password" v-model="confirm_password" placeholder="Repeat Password" class="p-3 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div class="my-4">
                <div class="form-check">
                    <input v-model="checkbox" class="form-check-input appearance-none p-2 custom-checkbox h-4 w-4 border rounded-full border-gray-300 bg-white checked:bg-brand checked:border-brand focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label font-inter text-sm text-gray-800" for="flexCheckDefault">
                        I have read and agree to recieve electronic communication about my account and service in accordance with <a href="terms" class="text-brand text-underline">Tryba’s T&Cs</a>  & <a href="modulr-terms" class="text-brand text-underline">Modulr T&Cs</a>
                    </label>
                </div>
            </div>
            <div class="my-4">
                <button type="submit" class="px-8 w-full text-sm font-inter space-x-3 py-3 bg-brand rounded-md text-white">
                    <div class="flex space-x-3 justify-center items-center" v-if="showPreloader">
                        <p>Registering ...</p> <Preloader/>
                    </div>
                    <span v-else>Register</span>
                </button>
            </div>
        </form>
        <div class="font-inter text-sm">
            Already have an account? <button @click="openLoginModal" class="text-brand text-sm">Log in</button>
        </div>
    </Modal>
</template>

<script>
import Modal from './Modal.vue';
import Preloader from './Preloader.vue';
export default {
    name:"Login",
    emits: ["closeRegisterModal",'openLoginModal','openRegisterModal'],
    components:{
        Modal,Preloader
    },
    data(){
        return{
            error:"",
            success:"",
            email:"",
            password:"",
            firstName:"",
            phone:"",
            lastName:"",
            middleName:"",
            confirm_password:"",
            checkbox:false,
            showPreloader:false,
            homeUrl : window.location.origin,
            token: window.token.token,
            selectedCountry:false,
            countries:[],
            countryID:"",
            phonecode:"",
            tabs:{
                country: true,
                personal: false,
                credentails: false
            }
        }
    },
    methods:{
        emitClose(){
            this.$emit('closeRegisterModal')
        },
        async register(){
            let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(!this.email) {
                this.error = "Email address field is required"  
            }else if (!this.email.match(regexEmail)) {
                this.error = "Invaild email address entered" 
            }else if (!this.password){
                this.error = "Password field is required" 
            }
            let data = {
                first_name:this.firstName,
                last_name:this.lastName,
                middle_name: (this.middleName) ? this.middleName :"",
                phone: this.phone,
                email:this.email,
                password:this.password,
                password_confirmation: this.confirm_password,
                terms:this.checkbox,
                _token : this.token,
                country: this.countryID
            }
            this.error = null;
            let url = this.homeUrl + '/register';
            try {
                this.toggleShowPreloader();
                let res = await fetch(url,{
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                let result = await res.json(); 
                if (res.ok) {
                    window.location.href = this.homeUrl + '/user/dashboard';
                }else{
                    this.toggleShowPreloader();
                    this.error = result.message;
                }
            } catch (error) {
                this.toggleShowPreloader();
                console.log(error)
            }
        },
        toggleShowPreloader(){
            this.showPreloader = !this.showPreloader
        },
        async getCountries(){
            let url = this.homeUrl + '/api/list_supported_countries';
            try {
                let res = await fetch(url,{
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                let result = await res.json(); 
                if (res.ok) {
                    this.countries = result
                }else{
                    this.error = result.message;
                }
            } catch (error) {
                console.log(error)
            }
        },
        submitCountry(){
            if(this.countryID){
                let country = this.countries.find((item) => item.country_id == this.countryID);
                this.phonecode = country.real.phonecode
                this.goToPages('personal')
                this.error = ""
            }else{
                this.error = "Select a country"
            }
        },
        goToPages(to){
            let pages = this.tabs
            Object.keys(pages).map(function(key, index) {
                 if(key == to){
                    pages[key] = true;
                }else{
                    pages[key] = false;
                }
            });
        },
        submitName(){
            if(!this.firstName){
                this.error = "First Name field is required"
            }else if(!this.lastName){
                this.error = "Last Name field is required"
            }else if(!this.phone){
                this.error = "Phone number field is required"
            }else{
                this.error = "";
                this.goToPages('credentails')
            }

        },
        openLoginModal(){
            this.$emit('openLoginModal')
        }
    },
    mounted(){
        this.getCountries();
    }

}
</script>

<style>

</style>