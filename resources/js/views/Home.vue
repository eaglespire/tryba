<template>
    <!-- <Notice/> -->
    <Header @openLoginModal="toggleLogin" @openRegisterModal="toggleRegister" :asset="assetUrl" />
        <SectionOne @openRegisterModal="toggleRegister" :asset="assetUrl"/>
        <SectionTwo :asset="assetUrl"/>
        <SectionThree :asset="assetUrl"/>
        <SectionFour :asset="assetUrl"/>
        <SectionFive :asset="assetUrl"/>
        <SectionSix :asset="assetUrl"/>
        <SectionSeven :asset="assetUrl"/>
        <SectionEight  :asset="assetUrl"/>
        <SectionNine :asset="assetUrl"/>
        <SectionTen :asset="assetUrl"/>
        <SectionEleven  @openRegisterModal="toggleRegister" :asset="assetUrl"/>
    <Footer :asset="assetUrl"/>
</template>

<script>
    import Header from '../components/Header.vue';
    import Notice from '../components/Notice.vue';
    import Footer from '../components/Footer.vue';
    import SectionOne from '../components/new_home/SectionOne.vue'
    import SectionTwo from '../components/new_home/SectionTwo.vue'
    import SectionThree from '../components/new_home/SectionThree.vue'
    import SectionFour from '../components/new_home/SectionFour.vue'
    import SectionFive from '../components/new_home/SectionFive.vue'
    import SectionSix from '../components/new_home/SectionSix.vue'
    import SectionSeven from '../components/new_home/SectionSeven.vue'
    import SectionEight from '../components/new_home/SectionEight.vue'
    import SectionNine from '../components/new_home/SectionNine.vue'
    import SectionTen from '../components/new_home/SectionTen.vue'
    import SectionEleven from '../components/new_home/SectionEleven.vue'

    export default {
        components:{
            Header,SectionOne,SectionTwo,SectionThree,Footer,SectionFive,SectionFour,SectionSix,SectionSeven,SectionEight,SectionNine,SectionTen,SectionEleven,Notice
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
