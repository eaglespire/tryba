<template>
    <Notice/>
    <Header @openLoginModal="toggleLogin" @openRegisterModal="toggleRegister" :asset="assetUrl" />
        <SectionOne @openRegisterModal="toggleRegister" @openLoginModal="toggleLogin"  :asset="assetUrl"/>
        <SectionTwo :asset="assetUrl"/>
        <SectionThree :asset="assetUrl"/>
        <SectionFour :asset="assetUrl"/>
         <SectionSix :asset="assetUrl"/>
        <SectionFive :asset="assetUrl"/>
    <Footer :asset="assetUrl"/>
</template>

<script>
    import Header from '../components/HeaderOne.vue';
    import Notice from '../components/Notice.vue';
    import Footer from '../components/Footer.vue';
    import SectionOne from '../components/home/SectionOne1.vue'
    import SectionTwo from '../components/home/SectionTwo.vue'
    import SectionThree from '../components/home/SectionThree.vue'
    import SectionFour from '../components/home/SectionFour.vue'
    import SectionFive from '../components/home/SectionFive.vue'
    import SectionSix from '../components/home/SectionSix.vue'
    export default {
        components:{
            Header,SectionOne,SectionTwo,SectionThree,Footer,SectionFive,SectionFour,SectionSix,Notice
        },
        data(){
            return{
                assetUrl: window.assetUrl.url,
                showLogin:false
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
        created(){
        }
    }
</script>
