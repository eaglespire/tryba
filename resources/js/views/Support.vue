<template>
   <Header :asset="assetUrl"/>
        <SectionOne :asset="assetUrl"/>
   <Footer :asset="assetUrl"/>
</template>

<script>
import Header from '../components/HeaderOne.vue';
import Footer from '../components/Footer.vue';
import SectionOne from '../components/support/SectionOne.vue'
export default {
    name:"Support",
    components:{
        Header, Footer, SectionOne
    },
    data(){
      return{
          assetUrl: window.assetUrl.url
      }
    }
}
</script>

<style>

</style>