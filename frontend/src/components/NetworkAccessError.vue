<template>

  <nav>

    <img src='@/assets/logo.png'>

    <router-link to="/">Компании</router-link>

    <router-link to="/enter" v-if="generalCondition.authorizationStatus==false">Войти</router-link>

    <router-link to="/register" v-if="generalCondition.authorizationStatus==false">Регистрация</router-link>

    <button v-if="generalCondition.authorizationStatus==true">Выйти</button>
   
  </nav>

</template>

<script>

import { useGeneralCondition } from "@/stores/generalCondition.js";

export default {

  setup(){

    const generalCondition=useGeneralCondition();

    return{generalCondition}

  },

}
</script>


<style scoped>

nav{

  height:70px;
  background:rgb(33,37,41);
  display:flex;
  padding-right:10px;


}


a, a:visited, button{

  display:block;
  min-width:100px;
  font-size:20px;
  padding-left:5px;
  padding-right:5px;
  display:flex;
  justify-content:center;
  align-items:center;
  color:white;

}

img{

  width:auto;
  height:auto;
  display:block;
  margin-right:auto;

}


button{background:none;}


@media (max-width: 550px) {

  img{display:none;}


  nav{

    padding-right:0px;
    justify-content:space-between;
    justify-content:space-around;

  }


  a,button{

    min-width:0px;
    font-size:20px;
    display:flex;

    font-size: calc(18px + 8 * ((100vw - 320px) / (1280 - 320)));

  }


}

</style>
