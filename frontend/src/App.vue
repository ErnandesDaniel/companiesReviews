<template>

  <NavigationBar/>

  <div class='View'>
    <router-view/>
  </div>

  

</template>

<script>


import NavigationBar from '@/components/NavigationBar.vue'
import { useGeneralCondition } from "@/stores/generalCondition.js";
  export default {

    components:{ NavigationBar,},

    setup(){

      const generalCondition=useGeneralCondition();

      return{generalCondition}

    },

    created(){

      //Если токен авторизации имеется в localStorage, то пользователь авторизован
      if (localStorage.getItem("authorizationToken") != null){

        this.generalCondition.setAuthorizationStatus(true);
        this.generalCondition.setAuthenticationToken(localStorage.getItem("authorizationToken"));

      }

      //Сразу после загрузки приложения происходит загрузка списка компаний в менеджер состояния
      this.generalCondition.getCompanyList();

    },
}

</script>


<style scoped>

  .View{

    background:rgb(107,117,125);
    width:100%;
    height:calc(100% - 70px);
    overflow-y:auto;

  }

</style>
