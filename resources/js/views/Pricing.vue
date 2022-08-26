<template>
  <Header  @openLoginModal="toggleLogin" @openRegisterModal="toggleRegister" :asset="assetUrl"/>
    <SectionOne :asset="assetUrl"/>
    <SectionTwo :asset="assetUrl"/>
    <SectionThree :asset="assetUrl"/>
    <!-- <SectionFour :asset="assetUrl"/> -->
  <Footer :asset="assetUrl"/>
</template>

<script>
import Header from '../components/HeaderOne.vue';
import Footer from '../components/Footer.vue';
import SectionOne from '../components/pricing/SectionOne.vue'
import SectionTwo from '../components/pricing/SectionTwo.vue'
import SectionThree from '../components/pricing/SectionThree.vue'
import SectionFour from '../components/pricing/SectionFour.vue'
export default {
  name:"Pricing",
  components:{
    Header,Footer,SectionOne,SectionTwo,SectionThree,SectionFour
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

<style>

</style>