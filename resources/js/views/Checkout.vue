<template>
    <Banks v-if="mountBanks" :transaction="transaction" :institution="institution"/>
</template>

<script>
import Banks from '../components/checkout/Banks.vue';
import axios from 'axios';
export default {
    name:"Checkout",
    components:{
        Banks
    },
    data(){
        return{
            institution:[],
            transaction:null,
        }
    },
    computed:{
        mountBanks(){
            return (this.transaction && this.institution.length) ? true : false
        }
    },
    methods:{
        async getYapilyInstitution(){
            let url = window.location.origin + '/getYapilyInstitution';
            let res = await axios.get(url);
            this.institution = res.data.institution
        },
        async getTransaction(){
            let url = window.location.origin + '/checkout/transaction/' + this.$route.params.id;
            let res = await axios.get(url);
            this.transaction = res.data.transaction
        }

    },
    mounted(){
        this.getTransaction();
        this.getYapilyInstitution();     
    }

}
</script>

<style>

</style>