<template>
    <Header  @openLoginModal="toggleLogin" @openRegisterModal="toggleRegister" :asset="assetUrl" />
        <SectionOne  :asset="assetUrl" />
        <SectionTwo  :asset="assetUrl" />
        <SectionThree  :asset="assetUrl" />
    <Footer :asset="assetUrl"/>
</template>

<script>
    import Header from '../components/HeaderOne.vue';
    import Footer from '../components/Footer.vue';
    import SectionOne from '../components/features/SectionOne.vue'
    import SectionTwo from '../components/features/SectionTwo.vue'
    import SectionThree from '../components/features/SectionThree.vue'
    export default {
        components:{
            Header,Footer,SectionOne,SectionTwo,SectionThree
        },
        data(){
            return{
                assetUrl: window.assetUrl.url
            }
        },
        methods:{
            toggleLogin(){
                this.$emit("openLoginModal")
            },
            toggleRegister(){
                this.$emit("openRegisterModal")
            }
        },
  }
</script>
