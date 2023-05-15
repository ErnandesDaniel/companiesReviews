<template>

  <div class='Page'>

    <CompanyLink 

      v-for="(company,index) in generalCondition.companiesList"
      v-bind:name='company.name'
      v-bind:id='company.id'
      v-bind:address='company.address'
      v-bind:telephone='company.telephone'
      v-bind:general_director='company.general_director'
      v-bind:editable='company.editable'
      v-on:deleteCompany="deleteCompany"
      v-bind:index='index'

    />

    <router-link 

      class='createNewCompany'

      to="/createcompany"

      v-if="generalCondition.authorizationStatus==true"

    >Новая компания</router-link>

  </div>
</template>

<script>

import { useGeneralCondition } from "@/stores/generalCondition.js";
import CompanyLink from '@/components/CompanyLink.vue'
import axios from 'axios'


export default {
  components: {CompanyLink,},

  setup(){

    const generalCondition=useGeneralCondition();

    return{generalCondition}

  },

  data(){
    return{

    }
  },
  
  methods:{

    deleteCompany(index){this.generalCondition.companiesList.splice(index,1);}

  },


}
</script>

<style scoped>

  .Page{
  
    width:90%;
    min-height:90%;

    margin-left:auto;
    margin-right:auto;

    padding-top:15px;
    padding-bottom:15px;

    display: grid;
    grid-auto-rows:min-content;
    grid-row-gap: 20px;
    grid-template-columns: repeat(auto-fit, max(200px,27%));
    justify-items: center;
    justify-content: space-evenly;
    grid-column-gap: 20px;
    padding-left:20px;
    padding-right:20px;

  }

  .createNewCompany{

    height:30px;
    width:200px;
    font-size:18px;
    display:flex;
    justify-content:center;
    align-items:center;
    background:rgb(255,193,52);
    border-radius:5px;
    align-self:center;
    justify-self:start;

  }


</style>
