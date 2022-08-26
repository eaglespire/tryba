<template>
      <Modal>
        <div class="flex justify-end" >
            <div>
                <button @click="emitClose" class="text-brand">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        </div>
        <h1 class="text-2xl font-poppins font-semibold">Log in</h1>
        <p class="font-normal mb-4 font-inter text-sm">The smart way to do business</p>
        <form @submit.prevent="login" class="mt-4">
            <div v-if="error" class="text-red-400 text-sm font-inter my-2" >{{ error }}</div>
            <div v-if="success" class="text-green-600 text-sm font-inter my-2" >{{ success }}</div>
            <div class="mb-4">
                <input type="text" v-model="email" placeholder="Enter your email address" class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div>
                <input type="password" v-model="password" placeholder="Password" class="p-4 focus:outline-none font-inter text-sm w-full bg-gray-100 rounded">
            </div>
            <div class="flex justify-between my-6 font-inter">
                <div class="flex items-center space-x-6">
                    <div class="form-check">
                        <input v-model="checkbox" class="form-check-input appearance-none custom-checkbox h-4 w-4 border rounded-full border-gray-300 bg-white checked:bg-brand checked:border-brand focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label text-sm inline-block text-gray-800" for="flexCheckDefault">
                            Remember me
                        </label>
                    </div>
                </div>
                <div>
                    <a href="user-password/reset" class="text-brand text-sm">Forgot  password?</a>
                </div>
            </div>
            <div class="my-4">
                <button type="submit" class="px-8 w-full text-sm font-inter space-x-3 py-3 bg-brand rounded-md text-white">
                    <div class="flex space-x-3 justify-center items-center" v-if="showPreloader">
                        <p>Logging in</p> <Preloader/>
                    </div>
                    <span v-else>Log in</span>
                </button>
            </div>
        </form>
        <div class="font-inter text-sm">
           Do not have an account? <button @click="openRegisterModal" class="text-brand text-sm">Register</button>
        </div>
    </Modal>
</template>

<script>
import Modal from './Modal.vue';
import Preloader from './Preloader.vue';
export default {
    name:"Login",
    emits: ["closeLoginModal",'openLoginModal','openRegisterModal'],
    components:{
        Modal,Preloader
    },
    data(){
        return{
            error:"",
            success:"",
            email:"",
            password:"",
            checkbox:false,
            showPreloader:false,
            homeUrl : window.location.origin,
            token: window.token.token,
        }
    },
    methods:{
        emitClose(){
            this.$emit('closeLoginModal')
        },
        async login(){
           let data = {
                email:this.email,
                password:this.password,
                remember_me:this.checkbox,
                _token : this.token
            }
            this.error = null;
            let url = this.homeUrl + '/login';
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
                    if(result.doubleAuth == false){
                        window.location.href = this.homeUrl + '/user/dashboard';
                    }else{
                        window.location.href = this.homeUrl + '2fa';
                    }
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
        openRegisterModal(){
            this.$emit('openRegisterModal')
        }
    }

}
</script>

<style>

</style>